<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatSession;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;
use Gemini\Enums\Role;
use Gemini\Data\GenerationConfig;
use Gemini\Data\Schema;
use Gemini\Enums\DataType;
use Gemini\Enums\ResponseMimeType;

class ChatController extends Controller
{
    private $systemPrompt = "Anda adalah asisten keuangan. Selalu jawab hanya seputar topik keuangan, manajemen keuangan, budgeting, investasi, tabungan, atau pertanyaan finansial lainnya. Jika ada pertanyaan di luar topik keuangan, arahkan kembali ke topik keuangan dengan sopan. Selalu gunakan format markdown jika cocok, misal untuk tabel, list, atau penjelasan kode.";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $session = ChatSession::where('slug', $slug)->firstOrFail();
        $messages = collect($session->messages ?? [])->map(function($m, $i) {
            return array_merge($m, ['id' => $i]);
        })->values()->all();
        return view('chat.session', [
            'session' => $session,
            'messages' => $messages,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createSession()
    {
        $slug = (string) Str::uuid();
        $session = ChatSession::create([
            'slug' => $slug,
            'messages' => [], // Initializing with empty messages
        ]);
        return redirect()->route('chat.show', ['slug' => $slug]);
    }

    public function storeMessage(Request $request, $slug)
    {
        $request->validate([
            'message' => 'required|string',
            'structured' => 'nullable|boolean',
        ]);

        $session = ChatSession::where('slug', $slug)->firstOrFail();
        $messages = $session->messages ?? [];
        
        // Always ensure system prompt is present at the start
        if (empty($messages) || $messages[0]['role'] !== 'system') {
            array_unshift($messages, [
                'role' => 'system',
                'content' => $this->systemPrompt
            ]);
        } else {
            $messages[0]['content'] = $this->systemPrompt;
        }

        // Add user message
        $userMessage = [
            'role' => 'user',
            'content' => $request->input('message'),
        ];
        $messages[] = $userMessage;

        // Summarize if history is too long
        if (count($messages) > 12) {
            $summary = $this->summarizeHistory($messages);
            $messages = [
                ['role' => 'system', 'content' => $this->systemPrompt],
                ['role' => 'system', 'content' => 'Summary of previous conversation: ' . $summary],
                $userMessage
            ];
        }

        $aiReply = '';
        $isStructured = $request->boolean('structured', false);

        try {
            if ($isStructured) {
                // Structured output for financial data
                $result = Gemini::generativeModel(model: 'gemini-2.0-flash')
                    ->withGenerationConfig(
                        generationConfig: new GenerationConfig(
                            responseMimeType: ResponseMimeType::APPLICATION_JSON,
                            responseSchema: new Schema(
                                type: DataType::OBJECT,
                                properties: [
                                    'financial_advice' => new Schema(type: DataType::STRING),
                                    'estimated_cost' => new Schema(type: DataType::NUMBER),
                                    'time_horizon' => new Schema(type: DataType::STRING),
                                    'risk_level' => new Schema(type: DataType::STRING),
                                    'action_steps' => new Schema(
                                        type: DataType::ARRAY,
                                        items: new Schema(type: DataType::STRING)
                                    )
                                ],
                                required: ['financial_advice', 'action_steps']
                            )
                        )
                    )
                    ->generateContent($request->input('message'));
                $aiReply = json_encode($result->json());
            } else {
                // Multi-turn chat with financial context
                $history = collect($messages)->map(function($msg) {
                    return Content::parse(part: $msg['content'], role: $msg['role'] === 'user' ? Role::USER : ($msg['role'] === 'system' ? Role::USER : Role::MODEL));
                })->toArray();
                
                $chat = Gemini::chat(model: 'gemini-2.0-flash')->startChat(history: $history);
                $response = $chat->sendMessage($request->input('message'));
                $aiReply = $response->text();
            }
        } catch (\Exception $e) {
            \Log::error('Gemini API Error', ['error' => $e->getMessage()]);
            $aiReply = 'Maaf, terjadi kesalahan: ' . $e->getMessage();
        }

        $html = null;
        $plainText = strip_tags($aiReply);
        if (class_exists('Illuminate\\Support\\Str') && method_exists('Illuminate\\Support\\Str', 'markdown')) {
            $html = Str::markdown($aiReply);
        } elseif (class_exists('League\\CommonMark\\GithubFlavoredMarkdownConverter')) {
            $html = (new \League\CommonMark\GithubFlavoredMarkdownConverter())->convert($aiReply);
        } else {
            $html = nl2br(e($aiReply));
        }
        $messages[] = [
            'role' => 'assistant',
            'content' => $plainText,
            'content_html' => $html,
        ];
        
        $session->messages = $messages;
        $session->save();
        
        return redirect()->route('chat.show', ['slug' => $slug]);
    }

    // Multi-turn Chat: use session chat history for context
    public function multiTurnChat(Request $request, $slug)
    {
        $session = ChatSession::where('slug', $slug)->firstOrFail();
        $messages = $session->messages ?? [];
        // Convert messages to Gemini Content objects with roles
        $history = collect($messages)->map(function($msg) {
            return Content::parse(part: $msg['content'], role: $msg['role'] === 'user' ? Role::USER : Role::MODEL);
        })->toArray();
        $userInput = $request->input('message');
        $chat = Gemini::chat(model: 'gemini-2.0-flash')->startChat(history: $history);
        $response = $chat->sendMessage($userInput);
        // Save AI reply to session
        $messages[] = ['role' => 'user', 'content' => $userInput];
        $messages[] = ['role' => 'assistant', 'content' => $response->text()];
        $session->messages = $messages;
        $session->save();
        return response()->json(['response' => $response->text()]);
    }


    // Structured Output: allow structured prompt from chat session
    public function structuredOutput(Request $request, $slug)
    {
        $session = ChatSession::where('slug', $slug)->firstOrFail();
        $prompt = $request->input('prompt');
        
        $result = Gemini::generativeModel(model: 'gemini-2.0-flash')
            ->withGenerationConfig(
                generationConfig: new GenerationConfig(
                    responseMimeType: ResponseMimeType::APPLICATION_JSON,
                    responseSchema: new Schema(
                        type: DataType::OBJECT,
                        properties: [
                            'financial_advice' => new Schema(type: DataType::STRING),
                            'estimated_cost' => new Schema(type: DataType::NUMBER),
                            'time_horizon' => new Schema(type: DataType::STRING),
                            'risk_level' => new Schema(type: DataType::STRING),
                            'action_steps' => new Schema(
                                type: DataType::ARRAY,
                                items: new Schema(type: DataType::STRING)
                            )
                        ],
                        required: ['financial_advice', 'action_steps']
                    )
                )
            )
            ->generateContent($prompt);

        $messages = $session->messages ?? [];
        $messages[] = ['role' => 'user', 'content' => $prompt];
        $messages[] = ['role' => 'assistant', 'content' => json_encode($result->json())];
        $session->messages = $messages;
        $session->save();

        return response()->json($result->json());
    }

    // Summarization Example (to reduce token usage)
    public function summarizeHistory(array $messages)
    {
        $historyText = implode("\n", array_map(fn($msg) => ($msg['role'] === 'user' ? 'User: ' : '') . $msg['content'], $messages));
        $result = Gemini::generativeModel(model: 'gemini-2.0-flash')
            ->generateContent("Sebagai asisten keuangan, rangkum percakapan ini dalam 1-2 kalimat, fokus pada aspek keuangan:\n" . $historyText);
        return $result->text();
    }

    // Saved Info Example (store/retrieve user preferences or context)
    public function saveUserInfo(Request $request)
    {
        $userId = $request->user() ? $request->user()->id : $request->ip();
        $info = $request->input('info');
        \Cache::put('gemini_user_info_' . $userId, $info, now()->addDays(7));
        return response()->json(['status' => 'saved']);
    }

    public function getUserInfo(Request $request)
    {
        $userId = $request->user() ? $request->user()->id : $request->ip();
        $info = \Cache::get('gemini_user_info_' . $userId);
        return response()->json(['info' => $info]);
    }

    public function streamStory(Request $request, $slug)
    {
        // SIMULASI ERROR UI - HAPUS BARIS INI UNTUK MENGEMBALIKAN KE NORMAL
        // return response()->json(['error' => 'Simulasi error Gemini! Ini hanya untuk test UI error bubble. Hapus kode ini jika sudah tidak diperlukan.'], 500);

        $prompt = $request->input('prompt');
        $session = ChatSession::where('slug', $slug)->firstOrFail();
        $messages = $session->messages ?? [];

        // Always ensure system prompt is present at the start
        if (empty($messages) || $messages[0]['role'] !== 'system') {
            array_unshift($messages, [
                'role' => 'system',
                'content' => $this->systemPrompt
            ]);
        } else {
            $messages[0]['content'] = $this->systemPrompt;
        }

        $userMessage = ['role' => 'user', 'content' => $prompt];
        $messages[] = $userMessage;
        $session->messages = $messages;
        $session->save();

        // Best practice: summarize if history >= 12
        $contextMessages = $messages;
        if (count($messages) >= 12) {
            $summary = $this->summarizeHistory($messages);
            $lastMsgs = array_slice($messages, -4, 3);
            $contextMessages = array_merge([
                ['role' => 'system', 'content' => $this->systemPrompt],
                ['role' => 'system', 'content' => 'Summary of previous conversation: ' . $summary]
            ], $lastMsgs, [$userMessage]);
        }

        // Format chat history with financial context
        $historyText = $this->systemPrompt . "\n\n";
        foreach ($contextMessages as $msg) {
            if ($msg['role'] === 'user') {
                $historyText .= "User: {$msg['content']}\n";
            } elseif ($msg['role'] === 'system') {
                $historyText .= "System: {$msg['content']}\n";
            } else {
                $historyText .= "Assistant: {$msg['content']}\n";
            }
        }
        $historyText .= "Assistant: ";

        try {
            $stream = Gemini::generativeModel(model: 'gemini-2.0-flash')->streamGenerateContent($historyText);
        } catch (\Exception $e) {
            \Log::error('Gemini API Error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Maaf, terjadi kesalahan koneksi ke AI. Silakan coba lagi nanti.'], 500);
        }

        return response()->stream(function () use ($stream, $session, $messages) {
            $aiContent = '';
            $firstChunk = true;
            try {
                foreach ($stream as $response) {
                    $chunk = $response->text();
                    if ($firstChunk) {
                        $chunk = preg_replace('/^Assistant:\s*/i', '', $chunk);
                        $firstChunk = false;
                    }
                    $aiContent .= $chunk;
                    echo $chunk;
                    ob_flush();
                    flush();
                }
                // Simpan hanya plain text ke database
                $plainText = strip_tags($aiContent);
                $messages[] = ['role' => 'assistant', 'content' => $plainText];
                $session->messages = $messages;
                $session->save();
            } catch (\Exception $e) {
                \Log::error('Gemini Streaming Error', ['error' => $e->getMessage()]);
                echo "[ERROR] Maaf, terjadi kesalahan saat streaming AI.";
            }
        }, 200, [
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no'
        ]);
    }
}

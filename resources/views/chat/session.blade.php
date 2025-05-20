<x-chat-layout>
  
      <!-- Chat Container -->
      <div class="flex-1 overflow-y-auto p-4 md:p-6 chat-container" id="chatContainer">
          <div class="max-w-3xl mx-auto space-y-6 pt-4" id="messages">
              <!-- Render old messages from backend -->
              @foreach($messages as $msg)
                  <div class="flex items-start {{ $msg['role'] === 'user' ? 'justify-end' : 'space-x-3' }} message {{ $msg['role'] === 'user' ? 'user-message' : 'ai-message' }}">
                      @if($msg['role'] === 'assistant')
                          <img src="{{ asset('assets/logo.png') }}" alt="Akira" class="w-9 h-9 rounded-full flex-shrink-0 shadow-lg" onerror="this.src='{{ asset('assets/logo.png') }}'">
                          <div class="flex flex-col">
                              <span class="text-xs text-amber-500 font-semibold mb-1 ml-1">Akira</span>
                              <div class="ai-bubble p-4 shadow-sm max-w-md">
                                  <div class="markdown-output prose prose-sm max-w-none">
                                      @if (!empty($msg['content_html']))
                                          {!! $msg['content_html'] !!}
                                      @elseif (!empty($msg['content']))
                                          @if (class_exists('Illuminate\\Support\\Str') && method_exists('Illuminate\\Support\\Str', 'markdown'))
                                              {!! Illuminate\Support\Str::markdown($msg['content']) !!}
                                          @elseif (class_exists('League\\CommonMark\\GithubFlavoredMarkdownConverter'))
                                              {!! (new League\CommonMark\GithubFlavoredMarkdownConverter())->convert($msg['content']) !!}
                                          @else
                                              {!! nl2br(e($msg['content'])) !!}
                                          @endif
                                      @endif
                                  </div>
                              </div>
                          </div>
                      @else
                      <div class="flex items-start justify-end w-full gap-2">
    {{-- Nama dan bubble chat --}}
    <div class="flex flex-col items-end">
        <span class="text-xs text-violet-700 font-semibold mb-1 mr-1">
            @auth
                {{ Auth::user()->name }}
            @else
                Pengunjung
            @endauth
        </span>
        <div class="user-bubble p-4 shadow-md max-w-md text-white bg-violet-600 rounded-lg">
            <p>{{ $msg['content'] }}</p>
        </div>
    </div>

    {{-- Avatar atau inisial --}}
    @auth
        @if(Auth::user()->avatar)
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                 alt="{{ Auth::user()->name }}"
                 class="w-8 h-8 rounded-full object-cover border border-white ml-2">
        @else
            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center ml-2">
                <span class="text-purple-600 font-semibold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </span>
            </div>
        @endif
    @else
        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5.121 17.804A9.003 9.003 0 0112 15a9.003 9.003 0 016.879 2.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
    @endauth
</div>

                      @endif
                  </div>
              @endforeach
              @if(count($messages) === 0)
                  <div class="flex flex-col items-center justify-center min-h-[300px]">
                      <img src="{{ asset('assets/logo.png') }}" alt="Tabungin" class="w-20 h-20 mb-2" onerror="this.src='{{ asset('assets/logo.png') }}'">
                      <span class="text-2xl font-bold text-lavender-700 mb-1">Tabungin</span>
                      <span class="text-gray-500 text-center max-w-xs mb-2">Tabungin adalah asisten AI <b>khusus keuangan</b> yang siap membantu Anda menabung, mengelola keuangan, dan menjawab pertanyaan Anda dengan cerdas dan ramah. Jawaban AI dapat mengandung <b>format markdown</b> seperti tabel, list, atau kode.</span>
                  </div>
              @endif
          </div>
      </div>
      <!-- Input Area -->
  
      <footer class="input-container border-t border-lavender/20 p-4 md:p-6">
          <div class="max-w-3xl mx-auto">
              <div class="relative">
                  <input 
                      type="text" 
                      id="messageInput" 
                      class="w-full border border-lavender/30 bg-white rounded-full py-4 pl-6 pr-16 focus:outline-none focus:ring-2 focus:ring-lavender shadow-md"
                      placeholder="Type your message..."
                  >
                  <button 
                      id="sendButton" 
                      class="send-button absolute right-2 top-1/2 transform -translate-y-1/2 text-white rounded-full w-10 h-10 flex items-center justify-center focus:outline-none shadow-lg"
                  >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                      </svg>
                  </button>
              </div>
          </div>
      </footer>
      <script>
          const tabunginLogo = @json(asset('assets/logo.png'));
          const userDefault = @json(asset('assets/user-default.png'));
          const isLoggedIn = @json(Auth::check());
          const userName = @json(Auth::check() ? Auth::user()->name : null);
          const userPhoto = @json(Auth::check() ? (Auth::user()->profile_photo_url ?? null) : null);
          const userAvatar = @json(Auth::check() && Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : null);
          document.addEventListener('DOMContentLoaded', function() {
              const chatContainer = document.getElementById('chatContainer');
              const messagesDiv = document.getElementById('messages');
              const messageInput = document.getElementById('messageInput');
              const sendButton = document.getElementById('sendButton');
              const slug = @json($session->slug);
              function addMessage(text, isUser = false, isError = false) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex items-start ${isUser ? 'justify-end' : 'space-x-3'} message ${isUser ? 'user-message' : 'ai-message'}`;
    let messageHTML = '';
    if (isUser) {
        messageHTML += `
            <div class="flex items-start justify-end w-full gap-2">
                <div class="flex flex-col items-end">
                    <span class="text-xs text-violet-700 font-semibold mb-1 mr-1">
                        ${isLoggedIn ? userName : 'Pengunjung'}
                    </span>
                    <div class="user-bubble p-4 shadow-md max-w-md text-white bg-violet-600 rounded-lg">
                        <p class="whitespace-pre-line">${text}</p>
                    </div>
                </div>
        `;
        if (isLoggedIn) {
            if (userAvatar) {
                messageHTML += `<img src="${userAvatar}" alt="${userName}" class="w-8 h-8 rounded-full object-cover border border-white ml-2">`;
            } else {
                const initials = userName ? userName.substring(0, 2).toUpperCase() : 'U';
                messageHTML += `<div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center ml-2">
                    <span class="text-purple-600 font-semibold text-sm">${initials}</span>
                </div>`;
            }
        } else {
            messageHTML += `<div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9.003 9.003 0 0112 15a9.003 9.003 0 016.879 2.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>`;
        }
        messageHTML += `</div>`;
    } else {
        let errorObj = null;
        try {
            errorObj = typeof text === 'string' && text.trim().startsWith('{') ? JSON.parse(text) : null;
        } catch (e) { errorObj = null; }
        if (isError || (errorObj && errorObj.error)) {
            // Bubble error style
            messageHTML += `
                <img src="${tabunginLogo}" alt="Akira" class="w-9 h-9 rounded-full flex-shrink-0 shadow-lg">
                <div class="flex flex-col">
                    <span class="text-xs text-amber-500 font-semibold mb-1 ml-1">Akira</span>
                    <div class="ai-bubble p-4 shadow-sm max-w-md bg-red-50 border border-red-200 text-red-700 flex items-center gap-2" style="border-radius: 16px;">
                        <svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5 text-red-400 mr-2 flex-shrink-0' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z' /></svg>
                        <span>${errorObj && errorObj.error ? errorObj.error : text}</span>
                    </div>
                </div>
            `;
        } else {
            // gunakan marked untuk markdown rendering
            const html = marked.parse(text);
            messageHTML += `
                <img src="${tabunginLogo}" alt="Akira" class="w-9 h-9 rounded-full flex-shrink-0 shadow-lg">
                <div class="flex flex-col">
                    <span class="text-xs text-amber-500 font-semibold mb-1 ml-1">Akira</span>
                    <div class="ai-bubble p-4 shadow-sm max-w-md">
                        <div class="markdown-output prose prose-sm max-w-none">
                            ${html}
                        </div>
                    </div>
                </div>
            `;
        }
    }
    messageDiv.innerHTML = messageHTML;
    messagesDiv.appendChild(messageDiv);
    chatContainer.scrollTop = chatContainer.scrollHeight;
    return messageDiv;
}

              function showTypingIndicator() {
                  const indicatorDiv = document.createElement('div');
                  indicatorDiv.className = 'flex items-start space-x-3 message ai-message typing-indicator-container';
                  indicatorDiv.innerHTML = `
                      <img src="${tabunginLogo}" alt="Akira" class="w-9 h-9 rounded-full flex-shrink-0 shadow-lg" onerror="this.src='${tabunginLogo}'">
                      <div class="ai-bubble p-4 shadow-sm">
                          <div class="typing-indicator">
                              <span></span><span></span><span></span>
                          </div>
                      </div>
                  `;
                  messagesDiv.appendChild(indicatorDiv);
                  chatContainer.scrollTo({ top: chatContainer.scrollHeight, behavior: 'smooth' });
                  return indicatorDiv;
              }
              function addAIBubble() {
                  const messageDiv = document.createElement('div');
                  messageDiv.className = 'flex items-start space-x-3 message ai-message';
                  messageDiv.innerHTML = `
                      <img src="${tabunginLogo}" alt="Akira" class="w-9 h-9 rounded-full flex-shrink-0 shadow-lg" onerror="this.src='${tabunginLogo}'">
                      <div class="flex flex-col">
                          <span class="text-xs text-amber-500 font-semibold mb-1 ml-1">Akira</span>
                          <div class="ai-bubble p-4 shadow-sm max-w-md">
                              <div class="markdown-output prose prose-sm max-w-none"></div>
                          </div>
                      </div>
                  `;
                  messagesDiv.appendChild(messageDiv);
                  chatContainer.scrollTo({ top: chatContainer.scrollHeight, behavior: 'smooth' });
                  return messageDiv.querySelector('.markdown-output');
              }
              async function sendMessage() {
                  const text = messageInput.value.trim();
                  if (text === '') return;
                  addMessage(text, true);
                  messageInput.value = '';
                  const typingIndicator = showTypingIndicator();
                  // Streaming fetch
                  const response = await fetch(`/gemini/stream/${slug}`, {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                      body: JSON.stringify({ prompt: text, slug: slug })
                  });
                  typingIndicator.remove();
                  if (!response.ok) {
                      let errorText = 'Maaf, terjadi kesalahan.';
                      try {
                          const data = await response.json();
                          errorText = data.error || errorText;
                      } catch (e) {
                          errorText = await response.text();
                      }
                      addMessage(errorText, false, true);
                      return;
                  }
                  const aiBubble = addAIBubble();
                  let aiText = '';
                  if (!response.body) {
                      aiBubble.textContent = 'Sorry, streaming not supported.';
                      return;
                  }
                  const reader = response.body.getReader();
                  const decoder = new TextDecoder();
                  let done = false;
                  let isError = false;
                  while (!done) {
                      const { value, done: doneReading } = await reader.read();
                      done = doneReading;
                      if (value) {
                          aiText += decoder.decode(value);
                          // Cek jika error JSON
                          let errorObj = null;
                          try {
                              errorObj = aiText.trim().startsWith('{') ? JSON.parse(aiText) : null;
                          } catch (e) { errorObj = null; }
                          if (errorObj && errorObj.error) {
                              aiBubble.innerHTML = `<div class='flex items-center gap-2 text-red-700'><svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5 text-red-400 mr-2 flex-shrink-0' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z' /></svg><span>${errorObj.error}</span></div>`;
                              isError = true;
                          } else if (!isError) {
                              if (window.marked) {
                                  aiBubble.innerHTML = marked.parse(aiText);
                              } else {
                                  aiBubble.textContent = aiText;
                              }
                          }
                      }
                  }
              }
              sendButton.addEventListener('click', sendMessage);
              messageInput.addEventListener('keypress', function(e) {
                  if (e.key === 'Enter') sendMessage();
              });
              messageInput.focus();
          });
      </script>

</x-chat-layout>


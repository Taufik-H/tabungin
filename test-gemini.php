<?php
$apiKey = 'ISI_API_KEY_GEMINI_KAMU'; // Ganti dengan API key Gemini kamu
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:streamGenerateContent?key=' . $apiKey;

$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => "Halo, ini tes koneksi dari PHP!"]
            ]
        ]
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Ubah ke false hanya jika ingin skip SSL (tidak disarankan)

$response = curl_exec($ch);

if ($response === false) {
    echo 'Curl error: ' . curl_error($ch) . "\n";
} else {
    echo "Response from Gemini API:\n";
    echo $response;
}

curl_close($ch);
<?php

// Check what POST /login returns
$ch = curl_init('https://perpustakaan-250441100058.vercel.app/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
curl_close($ch);

preg_match('/name="_token" value="([^"]+)"/', $html, $matches);
$token = $matches[1] ?? '';

$ch = curl_init('https://perpustakaan-250441100058.vercel.app/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $token,
    'email' => 'admin@gmail.com',
    'password' => 'admin123',
]));
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Code: $code\n";
echo "Length: " . strlen($res) . "\n";
echo substr($res, 0, 500) . "\n";

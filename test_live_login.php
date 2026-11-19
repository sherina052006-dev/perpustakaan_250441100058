<?php

$cookieFile = __DIR__ . '/test_cookie.txt';
if (file_exists($cookieFile)) unlink($cookieFile);

// Step 1: GET /login
$ch = curl_init('https://perpustakaan-250441100058.vercel.app/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Step 1 GET /login HTTP Code: $httpCode\n";

// Extract CSRF token
preg_match('/name="_token" value="([^"]+)"/', $response, $matches);
$token = $matches[1] ?? null;
echo "CSRF Token: " . ($token ? substr($token, 0, 10) . '...' : 'NOT FOUND') . "\n";

// Show cookies received
if (file_exists($cookieFile)) {
    echo "Cookies in jar:\n" . file_get_contents($cookieFile) . "\n";
} else {
    echo "No cookie file created!\n";
}

if (!$token) {
    echo "Failed to extract CSRF token.\n";
    exit(1);
}

// Step 2: POST /login
$ch = curl_init('https://perpustakaan-250441100058.vercel.app/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $token,
    'email' => 'admin@gmail.com',
    'password' => 'admin123',
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$postResponse = curl_exec($ch);
$postHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$postRedirect = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
curl_close($ch);

echo "Step 2 POST /login HTTP Code: $postHttpCode\n";
echo "Redirect URL: $postRedirect\n";
if (file_exists($cookieFile)) {
    echo "Cookies in jar after POST:\n" . file_get_contents($cookieFile) . "\n";
}

// Step 3: GET the redirect URL
if ($postRedirect) {
    $ch = curl_init($postRedirect);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    $step3Response = curl_exec($ch);
    $step3HttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $step3Redirect = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_close($ch);

    echo "Step 3 GET $postRedirect HTTP Code: $step3HttpCode\n";
    echo "Step 3 Redirect: $step3Redirect\n";
}

if (file_exists($cookieFile)) unlink($cookieFile);

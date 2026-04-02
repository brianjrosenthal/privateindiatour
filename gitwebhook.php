<?php
// /var/www/myapp/webhook.php

$secret = 'blahblahblahblah';

$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';

if (!$payload || !$signature) {
    http_response_code(400);
    echo "Missing payload or signature\n";
    exit;
}

$expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expected, $signature)) {
    http_response_code(403);
    echo "Invalid signature\n";
    exit;
}

if ($event !== 'push') {
    http_response_code(200);
    echo "Ignored non-push event\n";
    exit;
}

// Run deploy script and capture output
$output = [];
$returnVar = 0;
exec('//home/brosenthal/deploy_private_india_tour.sh 2>&1', $output, $returnVar);

if ($returnVar !== 0) {
    http_response_code(500);
    echo "Deploy failed\n";
    echo implode("\n", $output);
    exit;
}

http_response_code(200);
echo "Deploy successful\n";
echo implode("\n", $output);
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('720771503979-n73atsg08kaghr40g02uirfmpncnuiop.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/micro-oss/auth/google-callback.php');
$client->addScope("email");
$client->addScope("profile");
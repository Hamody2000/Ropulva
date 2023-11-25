<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Calendar;

$client = new Client();
$client->setAuthConfig('oauth-credentials.json');
$client->setScopes(Google_Service_Calendar::CALENDAR);

$code = 'YOUR_AUTHORIZATION_CODE';
$client->authenticate($code);

$token = $client->getAccessToken();
file_put_contents('token.json', json_encode($token));

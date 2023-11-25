<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Calendar;

$client = new Client();
$client->setAuthConfig('oauth-credentials.json');
$client->setScopes(Google\Service\Calendar::CALENDAR);

$authUrl = $client->createAuthUrl();

return redirect($authUrl);

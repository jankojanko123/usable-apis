<?php

require_once 'vendor/autoload.php';

/*
* could get user game data
 * pics video and other media
 * add psn frends, games...
 * remote play
 * status
 *
*/



use PlayStation\Client;

$client = new Client();
//                           v code from above HARD TO GET ---->https://tusticles.com/psn-php/first_login.html
$client->loginWithNpsso('<64 character npsso code>');

$refreshToken = $client->refreshToken(); // Save this code somewhere (database, file, cache) and use this for future logins

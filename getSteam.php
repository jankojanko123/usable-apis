<?php
require __DIR__ . '/vendor/autoload.php';

/*
* could make tournaments/plays/challenge me-s/
 * remote group play
 * cloud play
 * user data
 * game data
 * news,
 * add steam frends, games
 * status
*/



use GuzzleHttp\Client;
use Steam\Configuration;
use Steam\Runner\GuzzleRunner;
use Steam\Runner\DecodeJsonStringRunner;
use Steam\Steam;
use Steam\Utility\GuzzleUrlBuilder;

$steam = new Steam(new Configuration([
    Configuration::STEAM_KEY => '89701ADFB2E464D1392602447E95D558'
]));
$steam->addRunner(new GuzzleRunner(new Client(), new GuzzleUrlBuilder()));
$steam->addRunner(new DecodeJsonStringRunner());

/** @var array $result */
//$result = $steam->run(new \Steam\Command\Apps\GetAppList());
$result = $steam->run(new \Steam\Command\User\GetFriendList('76561198205416892'));
$result = $steam->run(new \Steam\Command\PlayerService\GetOwnedGames('76561198205416892'));


//$result = $steam->run(new \Steam\Command\UserOAuth\GetTokenDetails('acesstoken'));



var_dump($result);
//link
//https://steamapi.xpaw.me/#IGameInventory
?>
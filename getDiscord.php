<?php
include __DIR__.'/vendor/autoload.php';

use RestCord\DiscordClient;

// the documentation is shitty https://www.restcord.com/
/*
* could make tournaments/plays/challenge me-s/ ,
 * create gulid and add people to it
 * add bots to police the whole thing
 * post results on page
 * add to achevements
 *
 * stream the whole thing on twitch///
 *
 * status
*/

$discord = new DiscordClient(['token' => 'NzIyMzgxMDg0ODYzNjI3MjY0.XuiVCA.J78vZS2X57WjYDQHqUqSLEh8qTs']); // Token is required

$channel = $discord->channel->getChannel([
    'channel.id'=>  '722380108131991594',
]);

var_dump($channel);


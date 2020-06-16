<?php
/**
 * # Instantiate.
 */


/*
* could make tournaments/plays/challenge me-s/
 * remote group play
 * user data
 * game data
 * add xbox frends, games
 * status
*/

require __DIR__ . '/vendor/autoload.php';
use \OpenXBL\Api;

$xbox = new Api('008c00o8ksoo4o44wg8ckgg0s4oggwc4ook');

print $xbox->get('/account');
print $xbox->get('/account/2535439072332371');
print $xbox->get('/player/summary');
print $xbox->get('/dvr/screenshots ');
var_dump(json_decode($xbox->get('/achievements ')));

/*
 * other shiz and link---> https://xbl.io/console
 *
GET /account/{xuid} another's profile information
GET /friends get friends list
GET /friends?xuid={xuid} get anthor's friends list
GET /friends/search?gt=OpenXBL Search for gamertag
GET /friends/add/{xuid} Add a friend
GET /friends/remove/{xuid} Remove a friend
POST /friends/favorite Add a friend as favorite
POST /friends/favorite/remove Remove friend from favorites
GET /recent-players Gets recent players for this account
GET /presence get friend's presence
GET /{xuid}/presence get multiple friend's presence
GET /conversations/requests get message requests
GET /conversations get conversations
GET /conversations/{xuid} get a conversation
POST /conversations send a message to a single person
GET /group Get all group conversations.
GET /group/summary/{group id} Get a group chat summary.
GET /group/messages/{group id} Get a group chats messages.
POST /group/create Create a new message group.
POST /group/send Send text message to group.
POST /group/rename Rename a message group.
POST /group/invite/voice Invite message group to voice chat.
POST /group/leave Leave a message group.
POST /group/invite Invite to message group.
POST /group/kick Kick user from message group.
POST /generate/gamertag generate a random gamertag
GET /clubs/{clubId} Club Details/Summary
POST /clubs/recommendations Club Recommendations
GET /clubs/owned Clubs Owned (by this user)
POST /clubs/create Create a Club
GET /clubs/find?q=my search query Find Clubs
POST /clubs/reserve Check if Club Name is Available
GET /activity/feed Get Activity Feed
POST /activity/feed Post to Activity Feed
GET /activity/history Get Activity History
GET /alerts Get Notifications/Alerts
GET /player/summary Get Player Summary
GET /dvr/gameclips Get Player Game Clips
POST /dvr/gameclips/delete/{{GameContentID}} Deletes a game clip
GET /dvr/screenshots Get Player Screenshots
GET /achievements/player/{xuid} Get Another Players Overall Achievements
GET /achievements/player/{xuid}/title/{titleid} Get Another Players Game Achievements
GET /achievements Get Player Achievements List
POST /achievements/stats/{titleId} Get user stats for a particular title
GET /achievements/title/{titleId} Get Specific Game Achievements
GET /achievements/{titleId} Get Game Achievements history
Beta GET /party Returns session directory information
Beta POST /party/invite/{sessionId/scid}
 */







?>
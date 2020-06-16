<?php
require __DIR__ . '/vendor/autoload.php';

// Assuming you already have the access token.
$accessToken = '//';
$clientId = '08248ch672bkkbxn88tz3bpt16o29k';
$clientSecret = '///';

// The Guzzle client used can be the included `HelixGuzzleClient` class, for convenience.
// You can also use a mock, fake, or other double for testing, of course.
$helixGuzzleClient = new HelixGuzzleClient($clientId);

// Instantiate NewTwitchApi. Can be done in a service layer and injected as well.
$newTwitchApi = new NewTwitchApi($helixGuzzleClient, $clientId, $clientSecret);

try {
    // Make the API call. A ResponseInterface object is returned.
    $response = $newTwitchApi->getUsersApi()->getUserByAccessToken($accessToken);

    // Get and decode the actual content sent by Twitch.
    $responseContent = json_decode($response->getBody()->getContents());

    // Return the first (or only) user.
    return $responseContent->data[0];
} catch (GuzzleException $e) {
    // Handle error appropriately for your application
}


/* u need accesstoken ... this should get it
 *
 * GET https://id.twitch.tv/oauth2/authorize
    ?client_id=08248ch672bkkbxn88tz3bpt16o29k
    &redirect_uri=www.google.si
    &response_type=code
    &scope=analytics:read:extensions analytics:read:games bits:read

curl -i -H "Accept: application/xml" -H "Content-Type: application/json" -X GET https://id.twitch.tv/oauth2/authorize?client_id=08248ch672bkkbxn88tz3bpt16o29k&redirect_uri=www.google.si&response_type=token&scope=analytics:read:extensions analytics:read:games bits:read

<a href="https://www.twitch.tv/login?client_id=08248ch672bkkbxn88tz3bpt16o29k&amp;redirect_params=client_id%3D08248ch672bkkbxn88tz3bpt16o29k">Found</a>.


 */

?>
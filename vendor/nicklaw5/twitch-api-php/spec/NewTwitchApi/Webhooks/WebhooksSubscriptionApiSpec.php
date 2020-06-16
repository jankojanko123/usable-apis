<?php

namespace spec\NewTwitchApi\Webhooks;

use GuzzleHttp\Client;
use PhpSpec\ObjectBehavior;

class WebhooksSubscriptionApiSpec extends ObjectBehavior
{
    function let(Client $guzzleClient)
    {
        $this->beConstructedWith('client-id', 'client-secret', $guzzleClient);
    }

    function it_validates_valid_signature()
    {
        $this->validateWebhookEventCallback(
            'sha256=4bce6127177f214c7e3efa547048148e9d607574412dedf93e67af17450473ba',
            'content'
        )->shouldReturn(true);
    }

    function it_rejects_invalid_signature()
    {
        $this->validateWebhookEventCallback(
            'sha256=invalidhash',
            'content'
        )->shouldReturn(false);
    }

    function it_subscribes_to_a_stream(Client $guzzleClient)
    {
        $guzzleClient->post('webhooks/hub', [
            'headers' => [
                'Authorization' => 'Bearer bearer-token',
                'Client-ID' => 'client-id',
            ],
            'body' => '{"hub.callback":"https:\/\/redirect.url","hub.mode":"subscribe","hub.topic":"https:\/\/api.twitch.tv\/helix\/streams?user_id=12345","hub.lease_seconds":100,"hub.secret":"client-secret"}'
        ])->shouldBeCalled();

        $this->subscribeToStream('12345', 'https://redirect.url', 'bearer-token', 100);
    }

    function it_subscribes_to_subscription_events(Client $guzzleClient)
    {
        $guzzleClient->post('webhooks/hub', [
            'headers' => [
                'Authorization' => 'Bearer bearer-token',
                'Client-ID' => 'client-id',
            ],
            'body' => '{"hub.callback":"https:\/\/redirect.url","hub.mode":"subscribe","hub.topic":"https:\/\/api.twitch.tv\/helix\/subscriptions\/events?broadcaster_id=12345&first=1","hub.lease_seconds":100,"hub.secret":"client-secret"}'
        ])->shouldBeCalled();

        $this->subscribeToSubscriptionEvents('12345', 'https://redirect.url', 'bearer-token', 100);
    }

    function it_subscribes_to_a_user(Client $guzzleClient)
    {
        $guzzleClient->post('webhooks/hub', [
            'headers' => [
                'Authorization' => 'Bearer bearer-token',
                'Client-ID' => 'client-id',
            ],
            'body' => '{"hub.callback":"https:\/\/redirect.url","hub.mode":"subscribe","hub.topic":"https:\/\/api.twitch.tv\/helix\/users?id=12345","hub.lease_seconds":100,"hub.secret":"client-secret"}'
        ])->shouldBeCalled();

        $this->subscribeToUser('12345', 'https://redirect.url', 'bearer-token', 100);
    }

    function it_subscribes_to_user_follows(Client $guzzleClient)
    {
        $guzzleClient->post('webhooks/hub', [
            'headers' => [
                'Authorization' => 'Bearer bearer-token',
                'Client-ID' => 'client-id',
            ],
            'body' => '{"hub.callback":"https:\/\/redirect.url","hub.mode":"subscribe","hub.topic":"https:\/\/api.twitch.tv\/helix\/users\/follows?from_id=12345&to_id=54321&first=1","hub.lease_seconds":100,"hub.secret":"client-secret"}'
        ])->shouldBeCalled();

        $this->subscribeToUserFollows('12345', '54321', 1, 'https://redirect.url', 'bearer-token', 100);
    }

    function it_subscribes_to_a_user_without_bearer(Client $guzzleClient)
    {
        $guzzleClient->post('webhooks/hub', [
            'headers' => [
                'Client-ID' => 'client-id',
            ],
            'body' => '{"hub.callback":"https:\/\/redirect.url","hub.mode":"subscribe","hub.topic":"https:\/\/api.twitch.tv\/helix\/users\/follows?from_id=12345&to_id=54321&first=1","hub.lease_seconds":100,"hub.secret":"client-secret"}'
        ])->shouldBeCalled();

        $this->subscribeToUserFollows('12345', '54321', 1, 'https://redirect.url', null, 100);
    }

    function it_unsubscribes_from_a_stream(Client $guzzleClient)
    {
        $guzzleClient->post('webhooks/hub', [
            'headers' => [
                'Client-ID' => 'client-id',
            ],
            'body' => '{"hub.callback":"https:\/\/redirect.url","hub.mode":"unsubscribe","hub.topic":"https:\/\/api.twitch.tv\/helix\/streams?user_id=12345"}'
        ])->shouldBeCalled();

        $this->unsubscribeFromStream('12345', 'https://redirect.url');
    }

    function it_unsubscribes_from_a_user(Client $guzzleClient)
    {
        $guzzleClient->post('webhooks/hub', [
            'headers' => [
                'Client-ID' => 'client-id',
            ],
            'body' => '{"hub.callback":"https:\/\/redirect.url","hub.mode":"unsubscribe","hub.topic":"https:\/\/api.twitch.tv\/helix\/users?id=12345"}'
        ])->shouldBeCalled();

        $this->unsubscribeFromUser('12345', 'https://redirect.url');
    }

    function it_unsubscribes_from_user_follows(Client $guzzleClient)
    {
        $guzzleClient->post('webhooks/hub', [
            'headers' => [
                'Client-ID' => 'client-id',
            ],
            'body' => '{"hub.callback":"https:\/\/redirect.url","hub.mode":"unsubscribe","hub.topic":"https:\/\/api.twitch.tv\/helix\/users\/follows?from_id=12345&to_id=54321&first=1"}'
        ])->shouldBeCalled();

        $this->unsubscribeFromUserFollows('12345', '54321', 1, 'https://redirect.url');
    }
}

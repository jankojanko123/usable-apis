<?php

declare(strict_types=1);

namespace NewTwitchApi\Webhooks;

use GuzzleHttp\Client;
use NewTwitchApi\HelixGuzzleClient;

class WebhooksSubscriptionApi
{
    public const SUBSCRIBE = 'subscribe';
    public const UNSUBSCRIBE = 'unsubscribe';

    private $clientId;
    private $secret;
    private $guzzleClient;

    public function __construct(string $clientId, string $secret, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->guzzleClient = $guzzleClient ?? new HelixGuzzleClient($clientId);
    }

    public function subscribeToStream(string $twitchId, string $callback, string $bearer = null, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function subscribeToSubscriptionEvents(string $twitchId, string $callback, string $bearer, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/subscriptions/events?broadcaster_id=%s&first=1', $twitchId),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function subscribeToUser(string $twitchId, string $callback, string $bearer = null, int $leaseSeconds = 0): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/users?id=%s', $twitchId),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function subscribeToUserFollows(string $followerId, string $followedUserId, int $first, string $callback, string $bearer = null, int $leaseSeconds = 0): void
    {
        $queryParams = [];
        if ($followerId) {
            $queryParams['from_id'] = $followerId;
        }
        if ($followedUserId) {
            $queryParams['to_id'] = $followedUserId;
        }
        if ($first) {
            $queryParams['first'] = $first;
        }
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/users/follows?%s', http_build_query($queryParams)),
            $callback,
            $bearer,
            $leaseSeconds
        );
    }

    public function unsubscribeFromStream(string $twitchId, string $callback): void
    {
        $this->unsubscribe(
            sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId),
            $callback
        );
    }

    public function unsubscribeFromUser(string $twitchId, string $callback)
    {
        $this->unsubscribe(
            sprintf('https://api.twitch.tv/helix/users?id=%s', $twitchId),
            $callback
        );
    }

    public function unsubscribeFromUserFollows(string $followerId, string $followedUserId, int $first, string $callback)
    {
        $queryParams = [];
        if ($followerId) {
            $queryParams['from_id'] = $followerId;
        }
        if ($followedUserId) {
            $queryParams['to_id'] = $followedUserId;
        }
        if ($first) {
            $queryParams['first'] = $first;
        }
        $this->unsubscribe(
            sprintf('https://api.twitch.tv/helix/users/follows?%s', http_build_query($queryParams)),
            $callback
        );
    }

    public function validateWebhookEventCallback(string $xHubSignature, string $content): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $xHubSignature);
        $generatedHash = hash_hmac($hashAlgorithm, $content, $this->secret);

        return $expectedHash === $generatedHash;
    }

    private function subscribe(string $topic, string $callback, string $bearer = null, int $leaseSeconds = 0): void
    {
        $headers = [
            'Client-ID' => $this->clientId,
        ];
        if (!is_null($bearer)) {
            $headers['Authorization'] = sprintf('Bearer %s', $bearer);
        }

        $body = [
            'hub.callback' => $callback,
            'hub.mode' => self::SUBSCRIBE,
            'hub.topic' => $topic,
            'hub.lease_seconds' => $leaseSeconds,
            'hub.secret' => $this->secret,
        ];

        $this->guzzleClient->post('webhooks/hub', [
            'headers' => $headers,
            'body' => json_encode($body),
        ]);
    }

    private function unsubscribe(string $topic, string $callback): void
    {
        $headers = [
            'Client-ID' => $this->clientId,
        ];

        $body = [
            'hub.callback' => $callback,
            'hub.mode' => self::UNSUBSCRIBE,
            'hub.topic' => $topic,
        ];

        $this->guzzleClient->post('webhooks/hub', [
            'headers' => $headers,
            'body' => json_encode($body),
        ]);
    }
}

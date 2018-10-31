<?php

namespace Cmsmax\ZohoCrmApiHelper;

use Cmsmax\ZohoCrmApi\Exceptions\InvalidTokenException;
use Cmsmax\ZohoCrmApiHelper\Models\ZohoToken;

class ZohoCrmApiClientHelper
{
    protected $client;
    protected $clientId;
    protected $clientSecret;
    protected $accessToken;
    protected $refreshToken;

    public function __construct($clientId, $clientSecret, $accessToken, $refreshToken)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->accessToken = $accessToken ?: new ZohoToken(['type' => 'access']);
        $this->refreshToken = $refreshToken ?: new ZohoToken(['type' => 'refresh']);

        $this->client = new \Cmsmax\ZohoCrmApi\Client([
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'access_token' => $this->accessToken->value,
        ]);
    }

    public function getTokens($grantToken, $redirectUri)
    {
        $response = $this->client->getTokens($grantToken, $redirectUri);
        $this->accessToken->updateAccessToken($response);
        $this->refreshToken->updateRefreshToken($response);

        $this->client->config([
            'access_token' => $this->accessToken->value,
        ]);
    }

    public function send($request)
    {
        if ($this->accessToken->expired()) {
            $this->refreshToken();
        }

        try {
            return $this->client->send($request);
        } catch (InvalidTokenException $e) {
            $this->refreshToken();
            return $this->client->retry();
        }
    }

    public function refreshToken()
    {
        $newToken = $this->client->refreshToken($this->refreshToken->value);
        $this->accessToken->updateAccessToken($newToken);
    }
}

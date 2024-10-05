<?php

namespace Theposeidonas\LaravelParasutApi;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


/**
 * Paraşüt OAuth2 işlemleri
 */
class Auth
{
    private array $config;

    /**
     * Auth constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get the cached token or fetch a new one.
     *
     * @return string
     */
    public function getToken(): string
    {
        $accessToken = Cache::get('parachute_token');

        if (!$accessToken) {
            return $this->fetchNewToken();
        }

        return $accessToken;
    }

    /**
     * Fetch a new access token from the OAuth endpoint.
     *
     * @return string
     */
    private function fetchNewToken(): string
    {
        $tokenEndpoint = 'https://api.parasut.com/oauth/token';

        try {
            $response = Http::asForm()->post($tokenEndpoint, [
                'grant_type'    => 'password',
                'client_id'     => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'username'      => $this->config['username'],
                'password'      => $this->config['password'],
                'redirect_uri'  => $this->config['redirect_uri'],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Cache::put('parachute_token', $data['access_token'], now()->addSeconds($data['expires_in']));
                return $data['access_token'];
            }

            throw new \Exception('Token fetch failed: ' . $response->body());

        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}

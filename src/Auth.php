<?php

namespace Theposeidonas\LaravelParasutApi;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


/**
 * Paraşüt OAuth2 işlemleri
 */
class Auth
{

    /**
     * @param $config
     * @return string
     */
    public static function getToken($config): string
    {
        $accessToken = Cache::get('parachute_token');

        if (!$accessToken) {
            return self::fetchNewToken($config);
        }

        return $accessToken;
    }

    /**
     * @param $config
     * @return string
     */
    private static function fetchNewToken($config): string
    {
        $tokenEndpoint = 'https://api.parasut.com/oauth/token';

        $response = Http::asForm()->post($tokenEndpoint, [
            'grant_type'    => 'password',
            'client_id'     => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'username'      => $config['username'],
            'password'      => $config['password'],
            'redirect_uri'  => $config['redirect_uri'],
        ]);

        if ($response->successful()) {
            $data = json_decode($response->body());
            Cache::put('parachute_token', $data->access_token, now()->addSeconds($data->expires_in));
            return $data->access_token;
        }
        else return $response->body();
    }

}
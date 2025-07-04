<?php

namespace App\Service;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;

class OAuth
{
    public function __construct() {}

    public function provider($type)
    {
        $config = config('oauth.'.$type);
        $provider = new GenericProvider($config);

        return $provider;
    }

    public function url($type)
    {
        return $this->provider($type)->getAuthorizationUrl();
    }

    public function auth(Request $request, $type)
    {
        if (! $request->has('code')) {
            return false;
        }

        $provider = $this->provider($type);

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $request->code,
        ]);

        $user = $provider->getResourceOwner($token)->toArray();

        return [
            'token' => $token->getToken(),
            'user' => $user,
        ];
    }
}

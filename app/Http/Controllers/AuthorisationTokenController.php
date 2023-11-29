<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\Http;

class AuthorisationTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $state = $request->session()->pull('state');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class,
            'Invalid state value.'
        );

        $response = Http::asForm()->post('http://api.oauthserver.com:8080/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => 1,
            'client_secret' => 'weAeGGbyd52gt5DT50A8RoVhRU2rK9j62eqqyH8X',
            'redirect_uri' => 'http://api.oauthclient.com:8082/callback',
            'code' => $request->code,
        ]);
        return $response->json();
    }
}

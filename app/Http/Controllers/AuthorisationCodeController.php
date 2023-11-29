<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthorisationCodeController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => 1,
            'redirect_uri' => 'http://api.oauthclient.com:8082/callback',
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
            // 'prompt' => '', // "none", "consent", or "login"
        ]);
        return redirect('http://api.oauthserver.com:8080/oauth/authorize?' . $query);
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


/**
 * Class AuthAPIController
 * @package App\Http\Controllers\API
 */

class AuthAPIController
{
    public function getTokenWithSessionId(Request $request){
        $response = json_encode([
            'session_id'    => $request->all()['session_id'],
            'token'         => Cache::get($request->all()['session_id'])
        ]);
        Cache::delete($request->all()['session_id']);
        return $response;
    }

    public function deauthentication(Request $request)
    {   
        Cache::delete("access_token_".Auth::user()->provider_id);
        JWTAuth::invalidate($request['token']);
        return response()->json(
            [
                'message' => 'Tu session ha sido finalizada!',
                'redirectUrl'=>env('APP_URL').'/azure/logout',
            ], 200);
    }

}

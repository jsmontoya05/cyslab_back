<?php

namespace Tests\Generators;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

final class GenerateToken {

    public function __construct() {
        
    }

    public function execute($user,$expireIn){
        $accessToken = null;
        try {
            JWTAuth::factory()->setTTL($expireIn);
            $accessToken = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            $accessToken = null;
        }
        return  $accessToken;
    }
}
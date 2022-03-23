<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Support\Facades\Cache;
use App\Services\CredentialService;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Http\Middleware\RefreshToken;

class TokenService
{
    use ConsumesExternalService;

    private $credentialService;

    private $credential;

    public function __construct(CredentialService $credentialServ)
    {
        $this->credentialService = $credentialServ;
        $this->credential = $this->credentialService->getCredential();
    }

    /**
     * Obtain one single token for azure management from the token service
     * @return string
     */
    public function obtainTokenForAzureManagement()
    {
        $tokenCached = $this->getTokenCached('access_token_admin');

        if (is_null($tokenCached)) {
            $baseUri                     = 'https://login.microsoftonline.com';
            $requestUrl                  = '/'.$this->credential['tenant'].'/oauth2/token';
            $formParams['client_id']     = $this->credential['client_id'];
            $formParams['client_secret'] = $this->credential['client_secret'];
            $formParams['resource']      = $this->credential['resource'];
            $formParams['grant_type']    = $this->credential['grant_type'];
            $response                    = $this->formatResponse($this->performRequest('POST', $requestUrl, $formParams, [], $baseUri));

            Cache::put('access_token_admin', $response['access_token'], $response['expires_in']);
            $tokenCached = $response['access_token'];
        }

        return $tokenCached;
    }

    /**
    * Obtain one single token from the token service
    * @return string
    */
    public function obtainTokenForAzureGraph($userId, $refreshToken)
    {
        try {
            $tokenCached = null;//Cache::get("access_token_".$userId);
            if (is_null($tokenCached)) {
                $response = $this->refreshTokenForUser($refreshToken);
                Cache::put("access_token_".$userId, $response['access_token'], $response['expires_in']);
                $tokenCached = $response['access_token'];
            }
            return $tokenCached;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error obtainTokenForAzureGraph', $e);
            return null;
        }
    }

    public function refreshTokenForUser($refreshToken)
    {
        $baseUri                     = 'https://login.microsoftonline.com';
        $requestUrl                  = '/'.$this->credential['tenant'].'/oauth2/v2.0/token';
        $formParams['client_id']     = $this->credential['client_id'];
        $formParams['scope']         = 'https://graph.microsoft.com/mail.read';
        $formParams['client_secret'] = $this->credential['client_secret'];
        //$formParams['redirect_uri']  = env('APP_URL');
        $formParams['grant_type']    = 'refresh_token';
        $formParams['refresh_token'] = $refreshToken;
        $response                    = $this->formatResponse($this->performRequest('POST', $requestUrl, $formParams, [], $baseUri));
        return $response;
    }


    private function getTokenCached(String $key)
    {
        return Cache::get($key);
    }

    private function formatResponse($response)
    {
        return json_decode($response, true);
    }

    
}

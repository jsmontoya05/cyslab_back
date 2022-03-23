<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use App\Services\TokenService;
use Illuminate\Support\Facades\Auth;

class GraphService
{
    use ConsumesExternalService;

    /**
     * The base uri to consume the laboratories service
     * @var string
     */
    public $baseUri = 'https://graph.microsoft.com/';

    /**
     * The refreshToken to consume the authors service
     * @var string
     */
    public $refreshToken;


    public function __construct()
    {

    }

    /**
     * Obtain the full list of my groups
     * @return string
     */
    public function obtainMyGroups($accessToken)
    {   
        $endpoint = "v1.0/me/memberOf";
        $response = json_decode($this->performRequest('GET', $endpoint, [], [], $this->baseUri, $accessToken),true);
        return $response;
    }


    /**
     * Format response of http request to array with only the content of attribute value
     * @return string
     */
    private function formatResponse($response, $attribute)
    {
        return json_decode($response, true)[$attribute];
    }

        /**
     * Format response of http request to array with only the content of attribute value
     * @return string
     */
    private function formatResponseWithoutAttribute($response)
    {
        return json_decode($response, true);
    }
}

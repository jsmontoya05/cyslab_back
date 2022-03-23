<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumesExternalService
{
    public function __constructor()
    {
    }

    /**
     * Send a request to any service
     * @return string
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [], $baseuri = null, $secret = null)
    {
        try {
            $client = new Client([
                'base_uri' => !empty($baseuri) ? $baseuri :$this->baseUri,
            ]);
            if (isset($secret)) {
                $headers['Authorization'] = 'Bearer '.$secret;
            }
            $response = $client->request($method, $requestUrl, ['form_params' => $formParams, 'headers' => $headers]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            \Illuminate\Support\Facades\Log::error($e);
        }
        return $response->getBody()->getContents();
    }

    public function performRequestPUT($method, $requestUrl, $formParams = [], $headers = [], $baseuri = null, $secret = null)
    {
        try {
            $client = new Client(['base_uri' => !empty($baseuri) ? $baseuri :$this->baseUri,]);
            if (isset($secret)) { $headers['Authorization'] = 'Bearer '.$secret; }
            $response = $client->request($method, $requestUrl, ['body' => json_encode($formParams), 'headers' => $headers]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            \Illuminate\Support\Facades\Log::error($e);
        }
        return ['content'=>json_decode($response->getBody()->getContents(),true),'status'=>$response->getStatusCode()];
    }

    /**
     * Send a request to any service
     * @return string
     */
    public function performRequestNatural($method, $requestUrl, $formParams = [], $headers = [], $baseuri = null, $secret = null)
    {
        try {
            $client = new Client(['base_uri' => !empty($baseuri) ? $baseuri :$this->baseUri]);

            if (isset($secret)) {
                $headers['Authorization'] = 'Bearer '.$secret;
            }

            $response = $client->request($method, $requestUrl, ['form_params' => $formParams, 'headers' => $headers]);
        
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            \Illuminate\Support\Facades\Log::error($e);
        }
        return $response;
    }
}

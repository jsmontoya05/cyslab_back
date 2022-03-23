<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Support\Facades\Cache;
use App\Services\TokenService;
use App\Services\CredentialService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EnvironmentService
{
    use ConsumesExternalService;

    /**
     * The base uri to consume the laboratories service
     * @var string
     */
    public $baseUri = 'https://management.azure.com/';

    /**
     * The secret to consume the authors service
     * @var string
     */
    public $secret;

    /**
     * The credential to consume the laboratories service
     * @var array
     */
    private $credential;

    /**
     * The subscription id to consume the laboratories service
     * @var string
     */
    private $subscriptionId;

    /**
     * The subscription id to consume the laboratories service
     * @var string
     */
    private $resourceGroupName = "CYSLABGROUP";

    /**
     * The laboratory account to consume the laboratories service
     * @var string
     */
    private $labAccountName = "a9db6107-648a-44cc-a5fd-f796727b1a09";


    public function __construct(CredentialService $credentialService, TokenService $tokenService)
    {
        $this->credential     = $credentialService->getCredential();
        $this->subscriptionId = $this->credential['subscription_id'];
        $this->resourceGroupName = $this->credential['resource_group'];
        $this->tokenService   = $tokenService;
        $this->secret         = $tokenService->obtainTokenForAzureManagement();
    }

    /**
     * Obtain the full list of Environments from the Environments service
     * @return string
     */
    public function obtainEnviroments($labAccountName,$labName, $environmentSettingName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/{$environmentSettingName}/environments?api-version=2018-10-15";
        $laboratories = json_decode($this->performRequest('GET', $endpoint, [], [], $this->baseUri, $this->secret),true)['value'];
        return $laboratories;
    }


    /**
     * Create one Environments using the Environments service
     * @return string
     */
    public function createEnvironment($labAccountName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}?api-version=2018-10-15";
        //$formParams["location"] = "East US";
        $response = $this->performRequestPUT('PUT', $endpoint, [], ['Content-Type'=>'application/json'], $this->baseUri, $this->secret);

        return $response;
    }

     /**
     * Create one Environments using the Environments service
     * @return string
     */
    public function defineMaxUsers(String $labAccountName, String $labName, Int $maxUsers = 1)
    {
        $endpoint                                  = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}?api-version=2018-10-15";
        $formParams['properties']['maxUsersInLab'] = $maxUsers;
        $response                                  = $this->performRequestPUT('PUT', $endpoint, $formParams, ['Content-Type'=>'application/json'], $this->baseUri, $this->secret);
        return $response;
    }

    /**
     * Delete a student
     * @return string
     */
    public function deleteEnvironment(String $labAccountName, String $labName, String $environmentSettingName, String $environmentName)
    {   
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/{$environmentSettingName}/environments/{$environmentName}?api-version=2018-10-15";
        $response = $this->performRequestNatural('DELETE', $endpoint, [], [], $this->baseUri, $this->secret);
        return $response->getStatusCode() !== 200 ? ['status'=>$response->getStatusCode(),'message'=>'not found environment!'] : ['status'=>$response->getStatusCode(),'message'=>'Environment deleted!'];
    }

    /**
     * Start a environment
     * @return array
     */
    public function startEnvironment(String $labAccountName, String $labName, String $environmentSettingName, String $environmentName)
    {   
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/{$environmentSettingName}/environments/{$environmentName}/start?api-version=2018-10-15";
        $response                                  = $this->performRequestPUT('POST', $endpoint, [], ['Content-Type'=>'application/json'], $this->baseUri, $this->secret);
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

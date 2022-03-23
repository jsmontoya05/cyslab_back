<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use App\Services\TokenService;
use App\Services\CredentialService;

class StudentService
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
     * Obtain the full list of Students from the Students service
     * @return string
     */
    public function obtainStudents(String $labAccountName,$labName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/users?api-version=2018-10-15";
        $laboratories = $this->formatResponse($this->performRequest('GET', $endpoint, [], [], $this->baseUri, $this->secret),'value');
        return $laboratories;
    }

    /**
     * Delete a student
     * @return string
     */
    public function deleteStudent(String $labAccountName, String $labName, String $userName)
    {   
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/users/{$userName}?api-version=2018-10-15";
        $response = $this->performRequestNatural('DELETE', $endpoint, [], [], $this->baseUri, $this->secret);
        return $response->getStatusCode() !== 202 ? null : ['message'=>'usuario Eliminado!'];
    }


    /**
     * Create one Environments using the Environments service
     * @return string
     */
    public function createStudents(String $labAccountName, $labName,$emails)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/addUsers?api-version=2018-10-15";
        $formParams['emailAddresses'] = $emails; 
        $response = $this->performRequestPUT('POST', $endpoint, $formParams, ['Content-Type'=>'application/json'], $this->baseUri, $this->secret);
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

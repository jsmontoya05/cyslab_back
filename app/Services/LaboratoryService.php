<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use App\Services\TokenService;
use App\Services\CredentialService;
use App\Services\EnviromentSettingsService;


class LaboratoryService
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


    public function __construct(CredentialService $credentialService, TokenService $tokenService, EnviromentSettingsService $enviromentSettingsService)
    {
        $this->credential     = $credentialService->getCredential();
        $this->subscriptionId = $this->credential['subscription_id'];
        $this->resourceGroupName = $this->credential['resource_group'];
        $this->tokenService   = $tokenService;
        $this->secret         = $tokenService->obtainTokenForAzureManagement();
        $this->enviromentSettingsService = $enviromentSettingsService;
    }

    /**
     * Obtain the full list of laboratories from the laboratories service
     * @return string
     */
    public function obtainLaboratories(String $labAccountName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs?api-version=2018-10-15";
        $laboratories = json_decode($this->performRequest('GET', $endpoint, [], [], $this->baseUri, $this->secret),true);
        $laboratories = isset($laboratories['value']) ?  $laboratories['value'] : $laboratories;
        return $laboratories;
    }


    /**
     * Create one laboratory using the laboratory service
     * @return string
     */
    public function createLaboratory(String $labAccountName,$labName,$maxUsersInLab,$usageQuota)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}?api-version=2018-10-15";
        $formParams["properties"] = [
            "maxUsersInLab" => $maxUsersInLab,
            "usageQuota"    => $usageQuota,
        ];
        $response = $this->performRequestPUT('PUT', $endpoint, $formParams, [], $this->baseUri, $this->secret);
        return $response;
    }

    /**
     * Obtain one single laboratory from the laboratory service
     * @return string
     */
    public function obtainLaboratory(String $labAccountName,$labName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}?api-version=2018-10-15";
        $response = json_decode($this->performRequest('GET', $endpoint, [], [], $this->baseUri, $this->secret),true);
        return $response;
    }

    /**
     * Update an instance of laboratory using the laboratory service
     * @return string
     */
    public function editLaboratory(String $labAccountName,$laboratory)
    {
        $labName    = $laboratory['name'];
        $endpoint   = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}?api-version=2018-10-15";
        $formParams = $laboratory;
        $response   = $this->performRequestPUT('PUT', $endpoint, $formParams, [], $this->baseUri, $this->secret);
        return $response;
    }

    /**
     * Remove a single laboratory using the laboratory service
     * @return string
     */
    public function deleteLaboratory(String $labAccountName,$laboratoryName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$laboratoryName}?api-version=2018-10-15";
        $response = $this->performRequestNatural('DELETE', $endpoint, [], [], $this->baseUri, $this->secret);
        return $response->getStatusCode() !== 202 ? ['status'=>$response->getStatusCode(),'message'=>'not found laboratory!'] : ['status'=>$response->getStatusCode(),'message'=>'Laboratory deleted!'];
    }

    /**
     * Format response of http request to array with only the content of attribute value
     * @return string
     */
    private function formatResponse($response, $attribute)
    {
        return json_decode($response, true)[$attribute];
    }
}

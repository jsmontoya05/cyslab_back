<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Support\Facades\Cache;
use App\Services\TokenService;
use App\Services\CredentialService;
use Illuminate\Support\Facades\Auth;

class LabAccountService
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
     * Obtain the full list of LabAccount from the LabAccount service
     * @return string
     */
    public function obtainLabAccounts()
    {
            $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts?api-version=2018-10-15";
            $laboratories = $this->formatResponse($this->performRequest('GET', $endpoint,[],[], $this->baseUri, $this->secret),'value');

        return $laboratories;
    }


    /**
     * Create one LabAccount using the LabAccount service
     * @return string
     */
    public function createLabAccount($labAccountName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}?api-version=2018-10-15";
        $formParams["location"] = "East US 2";
        $response = $this->performRequestPUT('PUT', $endpoint,$formParams,['Content-Type'=>'application/json'], $this->baseUri, $this->secret);
        return $response;
    }

    /**
     * get all sizes of vms
     * @return array
     * https://management.azure.com/subscriptions/157b7e6b-3fe4-45b0-82aa-0b46ca01d69c/resourceGroups/rg-cyslab-production/providers/Microsoft.LabServices/labaccounts/a9db6107-648a-44cc-a5fd-f796727b1a09/getPricingAndAvailability?api-version=2019-01-01-preview
     */
    public function obtainSizesVms(String $labAccountName){
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/getPricingAndAvailability?api-version=2019-01-01-preview";
        #$endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/getRegionalAvailability?api-version=2018-10-15";
        $response = $this->performRequestPUT('POST', $endpoint, [], ['Content-Type'=>'application/json'], $this->baseUri, $this->secret);
        return $response;
    }

    /**
     * Format response of http request to array with only the content of attribute value
     * @return string
     */
    private function formatResponse($response,$attribute){
        return json_decode($response ,true)[$attribute];
    }
}

<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

use App\Services\TokenService;
use App\Services\CredentialService;
use Illuminate\Support\Facades\Auth;

class EnviromentSettingsService
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
        $this->resourceGroupName = $this->credential['resource_group'];
        $this->subscriptionId = $this->credential['subscription_id'];
        $this->tokenService   = $tokenService;
        $this->secret         = $tokenService->obtainTokenForAzureManagement();
    }

    /**
     * Obtain the full list of obtainEnviromentSettings from the laboratories service labaccounts/{labAccountName}/labs/{labName}/environmentsettings
     * @return string
     */
    public function obtainEnviromentSettings(String $labAccountName, String $labName, String $environmentSettingName)
    {
            $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/{$environmentSettingName}?api-version=2018-10-15";
            $enviromentSettings = json_decode($this->performRequest('GET', $endpoint,[],[], $this->baseUri, $this->secret),true);
            return $enviromentSettings;
    }


    /**
     * Create one EnviromentSetting using the EnviromentSetting service
     * @return string
     */
    public function createEnviromentSettings(String $labAccountName, $labName,$enviromentSetting)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/{$enviromentSetting['name']}?api-version=2018-10-15";
        $formParams["properties"] = [
            "resourceSettings" => [
                "galleryImageResourceId" => $enviromentSetting['galleryImageResourceId'], //"/subscriptions/438fe8a7-037b-4b33-987f-d5be719baa73/resourceGroups/cyslabgroup/providers/microsoft.labservices/labaccounts/juan.vargasva/galleryimages/windows 10 pro, version 1909",
                "Size" => $enviromentSetting['size'],
               "referenceVm" =>  [
                    "userName" =>  $enviromentSetting['userName'],
                    "password" =>  $enviromentSetting['password']
                ]
            ]
        ];

        $response = $this->performRequestPUT('PUT', $endpoint,$formParams,[], $this->baseUri, $this->secret);

        return $response;
    }



    /**
     * Update an instance of EnviromentSetting using the EnviromentSetting service
     * @return string
     */
    public function publishEnviromentSetting(String $labAccountName, $labName,$enviromentSettingName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/default/publish?api-version=2018-10-15";
        $formParams["useExistingImage"]=true;
        $response = $this->performRequestPUT('POST', $endpoint, $formParams, ['Content-Type'=>'application/json'], $this->baseUri, $this->secret);
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

<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use App\Services\TokenService;
use App\Services\CredentialService;
use App\Services\EnviromentSettingsService;


class ScheduleService
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
     * Obtain the full list of schedules from the laboratories service
     * @return string
     */
    public function obtainSchedules(String $labAccountName,String $labName,String $environmentSettingName)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/{$environmentSettingName}/schedules?api-version=2019-01-01-preview";
        $laboratories = json_decode($this->performRequest('GET', $endpoint, [], [], $this->baseUri, $this->secret),true);
        $laboratories = isset($laboratories['value']) ?  $laboratories['value'] : $laboratories;
        return $laboratories;
    }


    /**
     * Create one laboratory using the laboratory service
     * @return string
     */
    public function createSchedule(
        String $labAccountName,
        String $labName,
        String $environmentSettingName,
        String $name,
        String $start,
        String $end,
        String $notes,
        String $timeZoneId
    )
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/{$environmentSettingName}/schedules/{$name}?api-version=2019-01-01-preview";
        $formParams["properties"] = [
            "name"              => $name,
            "start"             => $start,
            "end"               => $end,
            "notes"             => $notes,
            "enableState"       => "Enabled",
            "recurrencePattern" => [
                "frequency"     => "Weekly",
                "weekDays"      => ["Tuesday"],
                "interval"      => 1
            ],
            "timeZoneId"        => $timeZoneId,
            "startAction"       => [
                "enableState"   => "Enabled",
                "actionType"    => "Start"
            ],
            "endAction"         => [
                "enableState"   => "Enabled",
                "actionType"    => "Stop"
            ],
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
    public function deleteSchedule(String $labAccountName, String $labName, String $environmentSettingName, String $name)
    {
        $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/labs/{$labName}/environmentsettings/{$environmentSettingName}/schedules/{$name}?api-version=2019-01-01-preview";
        $response = $this->performRequestNatural('DELETE', $endpoint, [], [], $this->baseUri, $this->secret);
        return $response->getStatusCode() !== 200 ? ['status'=>$response->getStatusCode(),'message'=>'not found schedule!'] : ['status'=>$response->getStatusCode(),'message'=>'Schedule deleted!'];
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

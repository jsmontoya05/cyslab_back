<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Support\Facades\Cache;
use App\Services\TokenService;
use App\Services\CredentialService;
use Illuminate\Support\Facades\Auth;

class GalleryImageService
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
     * Obtain the full list of laboratories from the laboratories service
     * @return string
     */
    public function obtainGalleryimages(String $labAccountName,$filter)
    {
        $galleryimages = Cache::get('galleryimages');
        if (is_null($galleryimages)) {
            $endpoint = "/subscriptions/{$this->subscriptionId}/resourceGroups/{$this->resourceGroupName}/providers/Microsoft.LabServices/labaccounts/{$labAccountName}/galleryimages".$filter."&api-version=2018-10-15";
            $galleryimages = $this->formatResponse($this->performRequest('GET', $endpoint,[],[], $this->baseUri, $this->secret),'value');
            Cache::put('galleryimages', $galleryimages, 5);
        }
        return $galleryimages;
    }

    /**
     * Format response of http request to array with only the content of attribute value
     * @return string
     */
    private function formatResponse($response,$attribute){
        return json_decode($response ,true)[$attribute];
    }
}

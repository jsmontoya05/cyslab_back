<?php

declare(strict_types=1);

namespace App\UsesCase\Environment;

use App\Services\EnvironmentService;
use Illuminate\Support\Facades\Log;

final class FindEnvirometsUseCase
{
    public function __construct(EnvironmentService $environmentService)
    {
        $this->environmentService = $environmentService;
    }

    public function execute(String $labAccountName, String $labName, String $environmentSettingName)
    {   
        
        $response = $this->environmentService->obtainEnviroments($labAccountName, $labName, $environmentSettingName);

        if ($response) {
           // Log::debug($response);
        }
        
        return $response;
    }
}

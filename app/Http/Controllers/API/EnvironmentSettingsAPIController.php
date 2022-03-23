<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\UsesCase\Laboratory\FindProcessStatusLaboratoryUseCase;
use Illuminate\Support\Facades\Auth;

/**
 * Class EnvironmentSettingsAPIController
 * @package App\Http\Controllers\API
 */

class EnvironmentSettingsAPIController extends AppBaseController
{
    /** @var  FindProcessStatusLaboratoryUseCase */
    private FindProcessStatusLaboratoryUseCase $findProcessStatusLaboratoryUseCase;

    public function __construct(
        FindProcessStatusLaboratoryUseCase $findProcessStatusLaboratoryUseCase
    )
    {
        $this->findProcessStatusLaboratoryUseCase = $findProcessStatusLaboratoryUseCase;

    }

    public function processStatusOfLaboratory($labName, $enviromentSettingsName = 'default'){
        
        $labAccountName = Auth::user()['provider_id'];

        $processStatus = $this->findProcessStatusLaboratoryUseCase->execute(
            $labAccountName,
            $labName,
            $enviromentSettingsName
        );

        if (empty($processStatus)) {
            return $this->sendError('Error al consultar el estado del proceso de un labratorio');
        }

        return $processStatus;
    
    }
}

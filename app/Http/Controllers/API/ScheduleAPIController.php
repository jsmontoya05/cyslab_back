<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\GetSchedulesAPIRequest;
use App\Http\Requests\API\CreateScheduleAPIRequest;
use Response;
use App\UsesCase\Schedule\FindSchedulesForLaboratoryUseCase;
use App\UsesCase\Schedule\CreateScheduleForLaboratoryUseCase;
use App\UsesCase\Schedule\DeleteScheduleUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class StudentAPIController
 * @package App\Http\Controllers\API
 */

class ScheduleAPIController extends AppBaseController
{
    /** @var  FindSchedulesForLaboratoryUseCase */
    private FindSchedulesForLaboratoryUseCase $findSchedulesForLaboratoryUseCase;

    /** @var  CreateScheduleForLaboratoryUseCase */
    private CreateScheduleForLaboratoryUseCase $createScheduleForLaboratoryUseCase;

    /** @var  DeleteScheduleUseCase */
    private DeleteScheduleUseCase $deleteScheduleUseCase;

    public function __construct(
        FindSchedulesForLaboratoryUseCase $findSchedulesForLaboratoryUseCase,
        CreateScheduleForLaboratoryUseCase $createScheduleForLaboratoryUseCase,
        DeleteScheduleUseCase $deleteScheduleUseCase) {
        $this->findSchedulesForLaboratoryUseCase    = $findSchedulesForLaboratoryUseCase;
        $this->createScheduleForLaboratoryUseCase   = $createScheduleForLaboratoryUseCase;
        $this->deleteScheduleUseCase                = $deleteScheduleUseCase;
    }

    /**
     * Display a listing of the Laboratory.
     * GET|HEAD /laboratories
     *
     * @param GetSchedulesAPIRequest $request
     * @return Response
     */
    public function index(GetSchedulesAPIRequest $request)
    {
        $input                     = $request->all();
        $labName                   = $input['labName'];
        $labAccountName            = Auth::user()['provider_id'];
        $environmentSettingName    = "default";
        $environments              = $this->findSchedulesForLaboratoryUseCase->execute($labAccountName, $labName, $environmentSettingName);
        
        return datatables($environments)->toJson();
    }

    /**
     * Store a newly Schedule in storage.
     * POST /schedulñe
     *
     * @param CreateScheduleAPIRequest
     * @return Response
     */
    public function store(CreateScheduleAPIRequest $request)
    {
        $input          = $request->all();
        $labAccountName         = Auth::user()['provider_id'];
        $environmentSettingName = 'default';
        $response       = $this->createScheduleForLaboratoryUseCase->execute(
            $labAccountName, 
            $input['labName'], 
            $environmentSettingName,
            $input['name'],
            $input['start'],
            $input['end'],
            $input['notes'],
            $input['timeZoneId']
        );
        
        if (!isset($response['content']['id'])) {
            return $this->sendError('Evento no agregado al calendario!', $response['content']);
        }

        return $this->sendResponse($response, 'Evento agregado al calendario');
    } 

}

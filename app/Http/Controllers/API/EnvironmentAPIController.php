<?php

namespace App\Http\Controllers\API;
use App\Http\Requests\API\GetEnvionmentsAPIRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LaboratoryResource;
use App\UsesCase\Environment\FindEnvirometsUseCase;
use App\UsesCase\Environment\DeleteEnvirometsUseCase;
use App\UsesCase\Environment\DefineMaxUsersEnvironmentsUseCase;
use App\UsesCase\Environment\StartEnvironmentUseCase;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class EnvironmentAPIController
 * @package App\Http\Controllers\API
 */

class EnvironmentAPIController extends AppBaseController
{
    /** @var  FindEnvirometsUseCase */
    private FindEnvirometsUseCase $findEnvirometsUseCase;

    /** @var  DeleteEnvirometsUseCase */
    private DeleteEnvirometsUseCase $deleteEnvirometsUseCase;

    /** @var  DefineMaxUsersEnvironmentsUseCase */
    private DefineMaxUsersEnvironmentsUseCase $defineMaxUsersEnvironmentsUseCase;

    /** @var  StartEnvironmentUseCase */
    private StartEnvironmentUseCase $startEnvironmentUseCase;

    public function __construct(
        FindEnvirometsUseCase $findEnvirometsUseCase,
        DeleteEnvirometsUseCase $deleteEnvirometsUseCase,
        DefineMaxUsersEnvironmentsUseCase $defineMaxUsersEnvironmentsUseCase,
        StartEnvironmentUseCase $startEnvironmentUseCase
    )
    {
        $this->findEnvirometsUseCase             = $findEnvirometsUseCase;
        $this->deleteEnvirometsUseCase           = $deleteEnvirometsUseCase;
        $this->defineMaxUsersEnvironmentsUseCase = $defineMaxUsersEnvironmentsUseCase;
        $this->startEnvironmentUseCase           = $startEnvironmentUseCase;
    }

    /**
     * Display a listing of the Laboratory.
     * GET|HEAD /laboratories
     *
     * @param GetEnvionmentsAPIRequest $request
     * @return Response
     */
    public function index(GetEnvionmentsAPIRequest $request)
    {
        $input                                              = $request->all();
        $labName                                            = $input['labName'];
        $labAccountName                                     = Auth::user()['provider_id'];

        if(is_null($labName)){
            return $this->sendError('No haz enviado el nombre del laboratorio!');
        }

        $environmentSettingName                             = "default";
       
        $environments                                       = $this->findEnvirometsUseCase->execute($labAccountName,$labName,$environmentSettingName);

        return datatables($environments)->toJson();
    }

    /**
     * Store a newly created Laboratory in storage.
     * POST /laboratories
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input              = $request->all();
        $laboratory         = $this->createLaboratoryForAccountUseCase->execute($input);
        $labAccountName     = Auth::user()['provider_id'];

        $enviromentSettings = $this->createEnviromentSettingsForLaboratoryUseCase
        ->execute(
            $labAccountName,
            $input['name'],// labName
            'default',// enviromentSettingsName
            $input['template'], //resourceIdImageOfGallery
            $input['size'] //virtualMachineSize
        );
        
        return $this->sendResponse([
            'laboratory'            => $laboratory,
            'enviromentSettings'    => $enviromentSettings
        ], 'Laboratorio guardado con éxito');
    }

    /**
     * Display the specified Laboratory.
     * GET|HEAD /laboratories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified Laboratory in storage.
     * PUT/PATCH /laboratories/{id}
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        
    }

    /**
     * Remove the specified Laboratory from storage.
     * DELETE /laboratories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($laboratoryName,$environmentName)
    {   
        $labAccountName         = Auth::user()['provider_id'];
        $environmentSettingName = 'default';

        $environment            = $this->deleteEnvirometsUseCase->execute($labAccountName,$laboratoryName,$environmentSettingName,$environmentName);
    
        if (isset($environment['status']) && $environment['status'] !== 200) {
            return $this->sendError($environment['message'],[]);
        }

        return $this->sendSuccess('Laboratorio eliminado correctamente');
    }

     /**
     * Update the specified Laboratory.
     * PUT/PATCH /laboratories/{labName}
     *
     * @param string $labName
     * @param Request $request
     *
     * @return Response
     */
    public function defineMaxUsers($labName, $numberOfUsers)
    {   
        $labAccountName         = Auth::user()['provider_id'];
        $response = $this->defineMaxUsersEnvironmentsUseCase->execute($labAccountName, $labName, $numberOfUsers);

        if (isset($response['status']) && isset($response['status']) != 200) {
            return $this->sendError('No se pudo definir la capacidad!');
        }

        return $this->sendSuccess('Capacidad de maquinas definido!',$response);
    }


    /**
     * Start the specified virtual machine of laboratory.
     * PUT/PATCH /laboratories/{labName}
     *
     * @param string $labName
     * @param Request $request
     *
     * @return Response
     */
    public function startEnvironment(String $labName, String $environmentName)
    {   
        $labAccountName         = Auth::user()['provider_id'];
        $enviromentSettingsName = 'default';
        $response = $this->startEnvironmentUseCase->execute($labAccountName, $labName, $enviromentSettingsName, $environmentName);
   
        if (isset($response['status']) && isset($response['status']) != 200) {
            return $this->sendError('No se pudo iniciar la maquina virtual!');
        }

        return $this->sendSuccess('Se inició la maquina correctamente!',$response);
    }

    
}

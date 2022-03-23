<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLaboratoryAPIRequest;
use App\Http\Requests\API\UpdateLaboratoryAPIRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LaboratoryResource;
use Response;
use App\UsesCase\Laboratory\CreateLaboratoryWithAllForAccountUseCase;
use App\UsesCase\Laboratory\DeleteLaboratoryForAccountUseCase;
use App\UsesCase\Laboratory\FindLaboratoriesForAccountUseCase;
use App\UsesCase\Laboratory\FindLaboratoryForAccountUseCase;
use App\UsesCase\EnviromentSettings\CreateEnviromentSettingsForLaboratoryUseCase;
use Illuminate\Support\Facades\Auth;

/**
 * Class LaboratoryController
 * @package App\Http\Controllers\API
 */

class LaboratoryAPIController extends AppBaseController
{
    /** @var  CreateLaboratoryWithAllForAccountUseCase */
    private CreateLaboratoryWithAllForAccountUseCase $createLaboratoryWithAllForAccountUseCase;

    /** @var  DeleteLaboratoryForAccountUseCase */
    private DeleteLaboratoryForAccountUseCase $deleteLaboratoryForAccountUseCase;

    /** @var  FindLaboratoriesForAccountUseCase */
    private FindLaboratoriesForAccountUseCase $findLaboratoriesForAccountUseCase;

    /** @var  CreateEnviromentSettingsForLaboratoryUseCase */
    private CreateEnviromentSettingsForLaboratoryUseCase $createEnviromentSettingsForLaboratoryUseCase;

    /** @var  FindLaboratoryForAccountUseCase */
    private FindLaboratoryForAccountUseCase $findLaboratoryForAccountUseCase;
    
    public function __construct(
        FindLaboratoriesForAccountUseCase            $findLaboratoriesForAccountUseCase,
        CreateLaboratoryWithAllForAccountUseCase     $createLaboratoryWithAllForAccountUseCase,
        DeleteLaboratoryForAccountUseCase            $deleteLaboratoryForAccountUseCase,
        CreateEnviromentSettingsForLaboratoryUseCase $createEnviromentSettingsForLaboratoryUseCase,
        FindLaboratoryForAccountUseCase              $findLaboratoryForAccountUseCase
    ) {
        $this->findLaboratoriesForAccountUseCase            = $findLaboratoriesForAccountUseCase;
        $this->createLaboratoryWithAllForAccountUseCase     = $createLaboratoryWithAllForAccountUseCase;
        $this->deleteLaboratoryForAccountUseCase            = $deleteLaboratoryForAccountUseCase;
        $this->createEnviromentSettingsForLaboratoryUseCase = $createEnviromentSettingsForLaboratoryUseCase;
        $this->findLaboratoryForAccountUseCase              = $findLaboratoryForAccountUseCase;
    }

    /**
     * Display a listing of the Laboratory.
     * GET|HEAD /laboratories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {   
        $labAccountName = Auth::user()['provider_id'];
        $laboratories   = $this->findLaboratoriesForAccountUseCase->execute($labAccountName);
        return datatables($laboratories)->toJson();
    }

    /**
     * Store a newly created Laboratory in storage.
     * POST /laboratories
     *
     * @param CreateLaboratoryAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input          = $request->all();
        $user = Auth::user();

        $response = $this->createLaboratoryWithAllForAccountUseCase->execute(
            $user['provider_id'],
            $input['name'],
            $input['maxUsersInLab'],
            $input['usageQuota'],
            'default',
            $input['template'],
            $input['size'],
            $input['userName'],
            $input['password'],
        );

        if (isset($response['laboratory']['content']['error'])) {
            return $this->sendError('Laboratorio no creado', $response['laboratory']['content']);
        }
         
        if (isset($response['enviromentSettings']['content']['error'])) {
            return $this->sendError('Entorno plantilla no creado', $response['enviromentSettings']['content']);
        }

        return $this->sendResponse($response, 'Laboratorio guardado con éxito');
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
        $labAccountName = Auth::user()['provider_id'];
        $laboratory = $this->findLaboratoryForAccountUseCase->execute($labAccountName,$id);
           
        if (empty($laboratory) || isset($laboratory['error'])) {
            return $this->sendError('Laboratorio no encontrado!', $laboratory);
        }

        return $this->sendResponse($laboratory, 'Laboratory retrieved successfully');
    }

    /**
     * Update the specified Laboratory in storage.
     * PUT/PATCH /laboratories/{id}
     *
     * @param int $id
     * @param UpdateLaboratoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLaboratoryAPIRequest $request)
    {
        /* $input                                           = $request->all();
 */
 
       /*  $laboratory                                      = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            return $this->sendError('Laboratory not found');
        }

        $laboratory                                         = $this->laboratoryRepository->update($input, $id);

        return $this->sendResponse(new LaboratoryResource($laboratory), 'Laboratory updated successfully'); */
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
    public function destroy($laboratoryName)
    {    
        $labAccountName = Auth::user()['provider_id'];
        $laboratory                                         = $this->deleteLaboratoryForAccountUseCase->execute($labAccountName,$laboratoryName);
        
        if (isset($laboratory['status']) && $laboratory['status'] !== 202) {
            return $this->sendError($laboratory['message'],[]);
        }

        return $this->sendSuccess('Laboratorio eliminado correctamente');
    }
}

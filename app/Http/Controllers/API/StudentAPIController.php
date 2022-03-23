<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStudentsAPIRequest;
use App\Http\Requests\API\UpdateLaboratoryAPIRequest;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\GetStudentsAPIRequest;
use Response;
use App\UsesCase\Student\FindStudentsForLaboratoryUseCase;
use App\UsesCase\Student\CreateStudentsForLaboratoryUseCase;
use App\UsesCase\Student\DeleteStudentForLaboratoryUseCase;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\DeleteStudentAPIRequest;

/**
 * Class StudentAPIController
 * @package App\Http\Controllers\API
 */

class StudentAPIController extends AppBaseController
{
    /** @var  FindStudentsForLaboratoryUseCase */
    private FindStudentsForLaboratoryUseCase $findStudentsForLaboratoryUseCase;

    /** @var  CreateStudentsForLaboratoryUseCase */
    private CreateStudentsForLaboratoryUseCase $createStudentsForLaboratoryUseCase;

    /** @var  DeleteStudentForLaboratoryUseCase */
    private DeleteStudentForLaboratoryUseCase $deleteStudentForLaboratoryUseCase;

    public function __construct(
        FindStudentsForLaboratoryUseCase $findStudentsForLaboratoryUseCase,
        CreateStudentsForLaboratoryUseCase $createStudentsForLaboratoryUseCase,
        DeleteStudentForLaboratoryUseCase $deleteStudentForLaboratoryUseCase
    ) {
        $this->findStudentsForLaboratoryUseCase           = $findStudentsForLaboratoryUseCase;
        $this->createStudentsForLaboratoryUseCase         = $createStudentsForLaboratoryUseCase;
        $this->deleteStudentForLaboratoryUseCase         = $deleteStudentForLaboratoryUseCase;
    }

    /**
     * Display a listing of the Laboratory.
     * GET|HEAD /laboratories
     *
     * @param GetStudentsAPIRequest $request
     * @return Response
     */
    public function index(GetStudentsAPIRequest $request)
    {
        $input                                              = $request->all();
        $labName                                            = $input['labName'];
        $labAccountName                                     = Auth::user()['provider_id'];
        $environmentSettingName                             = "default";
        $environments                                       = $this->findStudentsForLaboratoryUseCase->execute($labAccountName, $labName);
        
        return datatables($environments)->toJson();
    }

    /**
     * Store a newly created Student in storage.
     * POST /students
     *
     * @param CreateStudentsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStudentsAPIRequest $request)
    {
        $input    = $request->all();
        $labAccountName                                     = Auth::user()['provider_id'];
        $response = $this->createStudentsForLaboratoryUseCase->execute($labAccountName, $input['labName'], $input['emails']);
        return $this->sendResponse($response, 'Estudiantes agregado con exito');
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
     * @param UpdateLaboratoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLaboratoryAPIRequest $request)
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
    public function destroy(String $labName,String $userName)
    {   
        $labAccountName = Auth::user()['provider_id'];
 
        $laboratory     = $this->deleteStudentForLaboratoryUseCase->execute(
            $labAccountName,
            $labName,
            $userName
        );
       
        if (empty($laboratory) || isset($laboratory['error'])) {
            return $this->sendError('Estudiante no encontrado!', $laboratory);
        }

        return $this->sendSuccess('Estudiante eliminado correctamente');
    }
}

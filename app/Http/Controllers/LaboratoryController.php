<?php

namespace App\Http\Controllers;

use App\DataTables\LaboratoryDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateLaboratoryRequest;
use App\Http\Requests\UpdateLaboratoryRequest;
use App\Repositories\LaboratoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Datatables;
use App\Services\LaboratoryService;
use GuzzleHttp\Client;

class LaboratoryController extends AppBaseController
{
    /** @var  LaboratoryRepository */
    private $laboratoryRepository;

    /** @var  LaboratoryService */
    private $laboratoryService;

    public function __construct(LaboratoryRepository $laboratoryRepo,LaboratoryService $laboratoryServ)
    {
        $this->laboratoryRepository = $laboratoryRepo;
        $this->laboratoryService    = $laboratoryServ;
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the Laboratory.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables($this->laboratoryService->obtainLaboratories(''))->toJson();
            //return Datatables::of((new LaboratoryDataTable())->get())->make(true);
        }
        return view('laboratories.index');
    }

    /**
     * Show the form for creating a new Laboratory.
     *
     * @return Response
     */
    public function create()
    {
        return view('laboratories.create');
    }

    /**
     * Store a newly created Laboratory in storage.
     *
     * @param CreateLaboratoryRequest $request
     *
     * @return Response
     */
    public function store(CreateLaboratoryRequest $request)
    {
        $input = $request->all();

        $laboratory = $this->laboratoryRepository->create($input);

        Flash::success('Laboratory saved successfully.');

        return redirect(route('laboratories.index'));
    }

    /**
     * Display the specified Laboratory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            Flash::error('Laboratory not found');

            return redirect(route('laboratories.index'));
        }

        return view('laboratories.show')->with('laboratory', $laboratory);
    }

    /**
     * Show the form for editing the specified Laboratory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            Flash::error('Laboratory not found');

            return redirect(route('laboratories.index'));
        }

        return view('laboratories.edit')->with('laboratory', $laboratory);
    }

    /**
     * Update the specified Laboratory in storage.
     *
     * @param  int              $id
     * @param UpdateLaboratoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLaboratoryRequest $request)
    {
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            Flash::error('Laboratory not found');

            return redirect(route('laboratories.index'));
        }

        $laboratory = $this->laboratoryRepository->update($request->all(), $id);

        Flash::success('Laboratory updated successfully.');

        return redirect(route('laboratories.index'));
    }

    /**
     * Remove the specified Laboratory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $laboratory = $this->laboratoryRepository->find($id);

        $laboratory->delete();

        return $this->sendSuccess('Laboratory deleted successfully.');
    }
}

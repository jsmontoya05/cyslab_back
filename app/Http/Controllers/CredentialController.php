<?php

namespace App\Http\Controllers;

use App\DataTables\CredentialDataTable;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCredentialRequest;
use App\Http\Requests\UpdateCredentialRequest;
use App\Repositories\CredentialRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Credential;
use Response;
use Datatables;

class CredentialController extends AppBaseController
{
    /** @var  CredentialRepository */
    private $credentialRepository;


    public function __construct(
        CredentialRepository $credentialRepo)
    {
        $this->credentialRepository = $credentialRepo;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Credential.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return Datatables::of((new CredentialDataTable())->get())->make(true);
        }

        return view('credentials.index');
    }

    /**
     * Show the form for creating a new Credential.
     *
     * @return Response
     */
    public function create()
    {
        return view('credentials.create');
    }

    /**
     * Store a newly created Credential in storage.
     *
     * @param CreateCredentialRequest $request
     *
     * @return Response
     */
    public function store(CreateCredentialRequest $request)
    {
        $input = $request->all();

        $credential = $this->credentialRepository->create($input);

        Flash::success('Credential saved successfully.');

        return redirect(route('credentials.index'));
    }

    /**
     * Display the specified Credential.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $credential = $this->credentialRepository->find($id);

        if (empty($credential)) {
            Flash::error('Credential not found');

            return redirect(route('credentials.index'));
        }

        return view('credentials.show')->with('credential', $credential);
    }

    /**
     * Show the form for editing the specified Credential.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $credential = $this->credentialRepository->find($id);

        if (empty($credential)) {
            Flash::error('Credential not found');

            return redirect(route('credentials.index'));
        }

        return view('credentials.edit')->with('credential', $credential);
    }

    /**
     * Update the specified Credential in storage.
     *
     * @param  int              $id
     * @param UpdateCredentialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCredentialRequest $request)
    {
        $credential = $this->credentialRepository->find($id);

        if (empty($credential)) {
            Flash::error('Credential not found');

            return redirect(route('credentials.index'));
        }

        $credential = $this->credentialRepository->update($request->all(), $id);

        if($credential->active === 1){
            Credential::where('active',1)->where('id','!=',$id)->update(['active' => 0]);            
        }

        Flash::success('Credential updated successfully.');

        return redirect(route('credentials.index'));
    }

    /**
     * Remove the specified Credential from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $credential = $this->credentialRepository->find($id);

        $credential->delete();

        return $this->sendSuccess('Credential deleted successfully.');
    }
}

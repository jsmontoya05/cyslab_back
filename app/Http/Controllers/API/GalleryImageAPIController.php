<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Services\GalleryImageService;
use Response;
use Illuminate\Support\Facades\Auth;

class GalleryImageAPIController extends AppBaseController
{

    /** @var  GalleryImageService */
    private $galleryImageService;

    public function __construct(GalleryImageService $galleryImgService)
    {
        $this->galleryImageService = $galleryImgService;
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
        $filter = '?$filter=(properties%2FisEnabled)';
        $labAccountName = Auth::user()['provider_id'];
        //$filter = '?$filter=name gt '."'".$request->get('name')."'";
        return datatables($this->galleryImageService->obtainGalleryimages($labAccountName,$filter))->toJson();
    }

   
}

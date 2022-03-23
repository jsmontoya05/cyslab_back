<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

final class GetSettingAPIController extends AppBaseController
{
    public function __invoke()
    {
       $setting =  \App\Models\Setting::where('active',1)->first();
       return [
        "main_color" => isset($setting['main_color']) ?  $setting['main_color'] : '#03345a',
        "text_color" => isset($setting['text_color']) ?  $setting['text_color'] : '#03345a',
        "logo"       => isset($setting['logo'])       ?  "data:image/png;base64,".$setting['logo'] : null, 
       ];
    }
   
}

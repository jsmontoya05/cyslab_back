<?php
declare(strict_types=1);

namespace App\Http\Controllers\API\Schedule;

use Illuminate\Support\Facades\Auth;
use App\Services\ScheduleService;
use App\Http\Controllers\AppBaseController;
use App\UsesCase\Schedule\DeleteScheduleUseCase;
use Illuminate\Support\Facades\Request;

final class DeleteScheduleAPIController extends AppBaseController
{   
        /** @var  DeleteScheduleUseCase */
        private DeleteScheduleUseCase $deleteScheduleUseCase;

    public function __construct(DeleteScheduleUseCase $deleteScheduleUseCase) {
       $this->deleteScheduleUseCase = $deleteScheduleUseCase;
    }

    public function __invoke(String $labName,String $scheduleName)
    {    
        $labAccountName            = Auth::user()['provider_id'];
        $environmentSettingName    = "default";
       
        $schedule  = $this->deleteScheduleUseCase->execute($labAccountName,$labName,$environmentSettingName,$scheduleName);
    
        if (isset($schedule['status']) && $schedule['status'] !== 200) {
            return $this->sendError($schedule['message'],[]);
        }

        return $this->sendSuccess('Schedule eliminado correctamente');
    }

   
}

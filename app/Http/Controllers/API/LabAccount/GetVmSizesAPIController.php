<?php
declare(strict_types=1);

namespace App\Http\Controllers\API\LabAccount;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use App\UsesCase\LabAccount\FindVmSizesLabAccountUseCase;

final class GetVmSizesAPIController extends AppBaseController
{   
        /** @var  FindVmSizesLabAccountUseCase */
        private FindVmSizesLabAccountUseCase $findVmSizesLabAccountUseCase;

    public function __construct(FindVmSizesLabAccountUseCase $findVmSizesLabAccountUseCase) {
       $this->findVmSizesLabAccountUseCase = $findVmSizesLabAccountUseCase;
    }

    public function __invoke()
    {    
        $labAccountName = Auth::user()['provider_id'];
        $schedule       = $this->findVmSizesLabAccountUseCase->execute($labAccountName);
        return $schedule;
    }

   
}

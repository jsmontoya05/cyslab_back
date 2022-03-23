<?php
declare(strict_types=1);

namespace App\Http\Controllers;
use App\Services\CredentialService;

final class LogoutController extends Controller
{

    public function __construct(CredentialService $credentialService) {
       $this->credentialService = $credentialService;
    }

    public function __invoke()
    {
        $setting = \App\Models\Setting::where('active',1)->first();
        return redirect($this->generateRouteForLogout($setting->route_spa_application));
    }

    private function generateRouteForLogout(String $routeSpaApplication){
        return "https://login.microsoftonline.com/common/oauth2/logout?post_logout_redirect_uri={$routeSpaApplication}&redirect_uri={$routeSpaApplication}";
    }
}

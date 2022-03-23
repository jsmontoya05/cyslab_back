<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\CredentialService;
use Illuminate\Support\Facades\Log;

final class RedirectController extends Controller
{

    public function __construct(CredentialService $credentialService) {
       $this->credentialService = $credentialService;
    }

    public function __invoke()
    {
        $credential = $this->credentialService->getCredential(); 
        config(['services.azure.client_id' => $credential->client_id]);
        config(['services.azure.client_secret' => $credential->client_secret]);
        config(['services.azure.redirect' => $credential->redirect_uri]);
        return Socialite::driver('azure')->redirect();
    }

   
}

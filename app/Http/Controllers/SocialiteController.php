<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\Provider;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\UsesCase\LabAccount\CreateLabAccountUseCase;
use App\Services\TokenService;
use App\Services\GraphService;
use App\Models\Credential;
use App\Services\CredentialService;

class SocialiteController extends Controller
{
    private CreateLabAccountUseCase $createLabAccountUseCase;
    private TokenService $tokenService;
    private GraphService $graphService;

    public function __construct(
        CreateLabAccountUseCase $createLabAccountUseCase,
        TokenService $tokenService,
        GraphService $graphService,
        CredentialService $credentialService
    ) {
        $this->createLabAccountUseCase = $createLabAccountUseCase;
        $this->tokenService            = $tokenService;
        $this->graphService            = $graphService;
        $this->credentialService       = $credentialService;
    }

    public function callback()
    {
        $credential = $this->credentialService->getCredential();
        config(['services.azure.client_id' => $credential->client_id]);
        config(['services.azure.client_secret' => $credential->client_secret]);
        config(['services.azure.redirect' => $credential->redirect_uri]);

        $this->validateIfExistError($_REQUEST);// esto está en debug
            
        $provider            = Socialite::driver('azure'); // set the data from oauth user
            $user                = $provider->user(); // set user data
            $refreshToken        = $user->refreshToken; // set refreshToken
            $expiresIn           = $user->expiresIn; // set expiresIn

            $userNative          = $this->createOrGetUser($user, 'azure'); // create or obtain user
            $tokenForAzureGraph  = $this->tokenService->obtainTokenForAzureGraph($user->getId(), $refreshToken);  // get token of user from api graph azure
            $setting             = \App\Models\Setting::where('active', 1)->first();

        if (is_null($setting)) {// validation if the setting is null
            \Illuminate\Support\Facades\Log::error("Route Spa Application Of Setting Is Null");
        }

        if (!$this->verifyRoleAdmin($tokenForAzureGraph)) {// validation if exist the user with role assigned from azuregroups
                return redirect($this->generateRouteForLogout($setting->route_spa_application)); //route for redirecto to logout
        }

        if (is_null($tokenForAzureGraph)) {// validation if the token for azure graph is null
            \Illuminate\Support\Facades\Log::error('Error From Callback Socitalize Azure - Not Found Token For Azure Graph', [
                    'GET'=>$_GET,
                    'POST'=>$_REQUEST
                  ]);
            return redirect($this->generateRouteForLogout($setting->route_spa_application));
        }
    
        $tokenNative        = $this->generateJWTtokenFromUser($userNative, $expiresIn);
        $sessionId          = $this->exposeTempTokenForSpa($userNative, $tokenNative);

        return redirect()->to($setting->route_spa_application.'?sessionId='.$sessionId);
    }

    private function createOrGetUser($userExternal, $providerName = 'azure')
    {
        if (is_null($userExternal)) {
            \Illuminate\Support\Facades\Log::error('Error From Callback Socitalite Azure', [
                'userExternal'=>$userExternal,
                'providerName'=>$providerName
              ]);
            return null;
        } else {
            $user = User::where(['provider_id' => $userExternal->getId()])->first();
   
            $this->createLabAccountUseCase->execute($userExternal->getId());
    
            if (!$user) {
                $user = User::create([
                    'name'          => $userExternal->getName(),
                    'email'         => $userExternal->getEmail(),
                    'image'         => $userExternal->getAvatar(),
                    'provider_id'   => $userExternal->getId(),
                    'provider'      => $providerName,
                ]);
            } else {
                $user->fill([
                    'name'          => $userExternal->getName(),
                    'email'         => $userExternal->getEmail(),
                    'image'         => $userExternal->getAvatar(),
                    'provider_id'   => $userExternal->getId(),
                    'provider'      => $providerName,
                ])->update();
            }
    
            return $user;
        }
    }

    private function validateIfExistError($request)
    {
        if (isset($request['error'])) {
            \Illuminate\Support\Facades\Log::error('Error From Callback Socitalize Azure', [
              'GET'=>$_GET,
              'POST'=>$_REQUEST,
              'ERROR'=>$request['error']
            ]);
        }
    }

    private function generateJWTtokenFromUser(User $user, $expireIn)
    {
        try {
            $ttlSeconds = 60;
            JWTAuth::factory()->setTTL($ttlSeconds);
            if (!$token = JWTAuth::fromUser($user)) {//recordar config
                return response()->json(['error'=>'invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error'=>'could_not_create_token'], 500);
        }
        return  $token;
    }

    private function exposeTempTokenForSpa(User $user, $token)
    {
        $sessionId = \Illuminate\Support\Str::random(10);
        Cache::put($sessionId, $token, 60);
        return $sessionId;
    }

    private function verifyRoleAdmin($accessToken)
    {
        $credential          = Credential::where('active', 1)->first();
        $groupsForAzureGraph = (array) $this->graphService->obtainMyGroups($accessToken);
        $isTeacher           = false;
        if ($groupsForAzureGraph && sizeof($groupsForAzureGraph['value']) > 0) {
            $arrayGroups = array_filter($groupsForAzureGraph['value'], function ($group) use ($credential) {return $group['displayName'] === $credential->role_group;});
            $isTeacher = sizeof($arrayGroups) > 0;
        }
        return $isTeacher;
    }

    private function generateRouteForLogout(String $routeSpaApplication)
    {
        return "https://login.microsoftonline.com/common/oauth2/logout?post_logout_redirect_uri={$routeSpaApplication}&redirect_uri={$routeSpaApplication}";
    }
}

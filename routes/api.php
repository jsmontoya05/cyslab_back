<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RoutpublishceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['jwt.auth'])->group(function () {
    /* Endopoints for Environments */
    Route::resource('environments', EnvironmentAPIController::class);
    Route::delete('environments/{labName}/{environmentName}', 'EnvironmentAPIController@destroy');
    Route::put('define-max-users/{labName}/{numbersOfUsers}', 'EnvironmentAPIController@defineMaxUsers');
    Route::post('start-environment/{labName}/{environmentName}', 'EnvironmentAPIController@startEnvironment');

    /* Endopoints for GalleryImages for environmentsSettings */
    Route::resource('galleryimages', GalleryImageAPIController::class);
    Route::get('get-vm-sizes',LabAccount\GetVmSizesAPIController::class);
    /* Endopoints for laboratories */
    Route::resource('laboratories', LaboratoryAPIController::class);
    Route::get('laboratories/process-status-Laboratory/{labName}', 'EnvironmentSettingsAPIController@processStatusOfLaboratory');

    /* Endopoints for Students */
    Route::resource('students', StudentAPIController::class);
    Route::delete('students/{labName}/{userName}', 'StudentAPIController@destroy');

    /* Endopoints for Schedules */
    Route::resource('schedules', ScheduleAPIController::class);
    Route::delete('schedules/{labName}/{scheduleName}', Schedule\DeleteScheduleAPIController::class);

    
    Route::post('logout', [AuthAPIController::class, 'deauthentication']);
    
    /* Endopoints for User */
    Route::get('show-me', 'UserAPIController@showMe');
 
   
});

Route::post('get-setting', GetSettingAPIController::class);
Route::post('get_token', 'AuthAPIController@getTokenWithSessionId');

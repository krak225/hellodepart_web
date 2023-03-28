<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\MobileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [MobileController::class,'register']);
Route::post('login', [MobileController::class,'login']);
Route::get('unauthorize', [MobileController::class,'unauthorize'])->name('401');


Route::group(['middleware' => 'auth:api'], function () {

    Route::get('logout', [MobileController::class,'logout']);
    Route::get('user', [MobileController::class,'user']);

    Route::post('update_profile', [MobileController::class,'update_profile']);

    //hello départ


	Route::get('compagnies', [MobileController::class,'compagnies']);
	Route::get('villes', [MobileController::class,'villes']);
	Route::get('gares', [MobileController::class,'gares']);

	Route::get('rechercher_departs/{v?}/{d?}/{dt?}', [MobileController::class,'rechercher_departs']);

	Route::post('payerticket', [MobileController::class,'payerticket']);

	Route::get('factures', [MobileController::class,'factures']);
	Route::get('clients', [MobileController::class,'clients']);


});

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});*/

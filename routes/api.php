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

Route::get('clients', [MobileController::class,'clients']);
Route::get('commandes', [MobileController::class,'commandes']);
Route::get('produits', [MobileController::class,'produits']);
Route::post('produit', [MobileController::class,'add_produit']);
Route::post('update_produit', [MobileController::class,'update_produit']);
Route::post('delete_photo', [MobileController::class,'delete_photo']);
Route::post('client', [MobileController::class,'add_client']);
Route::post('update_client', [MobileController::class,'update_client']);
Route::post('commande', [MobileController::class,'add_commande']);
Route::post('update_commande', [MobileController::class,'update_commande']);
Route::post('update_statut_commande', [MobileController::class,'update_statut_commande']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('logout', [MobileController::class,'logout']);
    Route::get('user', [MobileController::class,'user']);

    Route::post('update_profile', [MobileController::class,'update_profile']);

    //hello départ
    Route::get('compagnies', [MobileController::class,'compagnies']);
    Route::get('villes', [MobileController::class,'villes']);
    Route::get('gares', [MobileController::class,'gares']);

    Route::get('rechercher_departs/{v}/{d}/{dt}', [MobileController::class,'rechercher_departs']);

    Route::post('payertiket', [MobileController::class,'payertiket']);
    Route::get('tickets', [MobileController::class,'tickets']);


});

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});*/

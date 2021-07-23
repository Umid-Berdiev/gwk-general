<?php

use App\Http\Controllers\Api\GidrometApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::group(['middleware' => ['api_token']], function () {
  //Оператив Амударё
  Route::get('oper-amu', [GidrometApiController::class, 'operAmu']);
  //Оператив Сирдарё
  Route::get('oper-sird', [GidrometApiController::class, 'operSird']);
  //Режим гидропоста
  Route::get('hydropost-mode', [GidrometApiController::class, 'hydropostMode']);

  Route::get('instance-element-data', [GidrometApiController::class, 'getInstanceElementData']);
});

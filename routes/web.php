<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\General\MapController;
use App\Http\Controllers\General\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TermController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['localization']], function () {
  Auth::routes();
  Route::group(['middleware' => ['auth']], function () {
    Route::get('language/set', [LanguageController::class, 'setLang'])->name('lang.set');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'report'], function () {
      Route::get('/', 'App\Http\Controllers\General\WordExportController@index')->name('report.index');
      Route::post('/export', 'App\Http\Controllers\General\WordExportController@GenereteWord')->name('word.export');
    });

    Route::prefix('/units')->group(function () {
      Route::get('/', 'App\Http\Controllers\General\UnitsController@index')->name('units-index');
      Route::get('/destroy/{id}', 'App\Http\Controllers\General\UnitsController@destroy')->name('units-delete');
      Route::post('/store', 'App\Http\Controllers\General\UnitsController@store')->name('units-store');
      Route::post('/update', 'App\Http\Controllers\General\UnitsController@update')->name('units-update');
    });

    Route::group(['prefix' => 'resources'], function () {
      Route::get('/', 'App\Http\Controllers\General\ResourcesRegionsController@index')->name('resource');
      Route::get('type', 'App\Http\Controllers\General\ResourcesRegionsController@getTypeData')->name('resource.type');
      Route::get('/index_with', 'App\Http\Controllers\General\ResourcesRegionsController@indexWith')->name('resource.resource_regions_with');
      Route::post('/update', 'App\Http\Controllers\General\ResourcesRegionsController@update')->name('resource.resource_regions.update');
      Route::post('/accept', 'App\Http\Controllers\General\ResourcesRegionsController@accept')->name('resource.resource_regions.accept');

      Route::group(['prefix' => 'uw_reserfs'], function () {
        Route::get('/', 'App\Http\Controllers\General\UwReserfController@index')->name('resource.uw_reserf');
        Route::post('/update', 'App\Http\Controllers\General\UwReserfController@update')->name('resource.uw_reserf.update');
        Route::post('/accept', 'App\Http\Controllers\General\UwReserfController@accept')->name('resource.uw_reserf.accept');
      });

      Route::group(['prefix' => 'water_uses'], function () {
        Route::get('/', 'App\Http\Controllers\General\WaterUsesController@index')->name('resource.water_uses');
        Route::post('/update', 'App\Http\Controllers\General\WaterUsesController@update')->name('resource.water_uses.update');
        Route::post('/accept', 'App\Http\Controllers\General\WaterUsesController@accept')->name('resource.water_uses.accept');
      });

      Route::group(['prefix' => 'river_recources'], function () {
        Route::get('/', 'App\Http\Controllers\General\RiverFlowRecourcesController@index')->name('resource.river_recources');
        Route::post('/update', 'App\Http\Controllers\General\RiverFlowRecourcesController@update')->name('resource.river_recources.update');
        Route::post('/accept', 'App\Http\Controllers\General\RiverFlowRecourcesController@accept')->name('resource.river_recources.accept');
      });

      Route::group(['prefix' => 'ground_water'], function () {
        Route::get('/', 'App\Http\Controllers\General\GroundWaterController@index')->name('resource.ground_water');
        Route::post('/update', 'App\Http\Controllers\General\GroundWaterController@update')->name('resource.ground_water.update');
        Route::post('/accept', 'App\Http\Controllers\General\GroundWaterController@accept')->name('resource.ground_water.accept');
      });

      Route::group(['prefix' => 'ground_water_use'], function () {
        Route::get('/', 'App\Http\Controllers\General\GroundWaterUseController@index')->name('resource.ground_water_use');
        Route::post('/update', 'App\Http\Controllers\General\GroundWaterUseController@update')->name('resource.ground_water_use.update');
        Route::post('/accept', 'App\Http\Controllers\General\GroundWaterUseController@accept')->name('resource.ground_water_use.accept');
      });

      Route::group(['prefix' => 'water_use_various_needs'], function () {
        Route::get('/', 'App\Http\Controllers\General\WaterUseVariousController@index')->name('resource.water_use_various_needs');
        Route::post('/update', 'App\Http\Controllers\General\WaterUseVariousController@update')->name('resource.water_use_various_needs.update');
        Route::post('/accept', 'App\Http\Controllers\General\WaterUseVariousController@accept')->name('resource.water_use_various_needs.accept');
      });

      Route::group(['prefix' => 'information_large_canals_irigation_system'], function () {
        Route::get('/', 'App\Http\Controllers\General\InformationLargeCanalsIrigationSystem@index')->name('resource.information_large_canals_irigation_system');
        Route::post('/update', 'App\Http\Controllers\General\InformationLargeCanalsIrigationSystem@update')->name('resource.information_large_canals_irigation_system.update');
        Route::post('/accept', 'App\Http\Controllers\General\InformationLargeCanalsIrigationSystem@accept')->name('resource.information_large_canals_irigation_system.accept');
      });

      Route::group(['prefix' => 'change_water_reserves'], function () {
        Route::get('/', 'App\Http\Controllers\General\ChangeWaterReservesController@index')->name('resource.change_water_reserves');
        Route::post('/update', 'App\Http\Controllers\General\ChangeWaterReservesController@update')->name('resource.change_water_reserves.update');
        Route::post('/accept', 'App\Http\Controllers\General\ChangeWaterReservesController@accept')->name('resource.change_water_reserves.accept');
      });

      Route::group(['prefix' => 'characteristics_water'], function () {
        Route::get('/', 'App\Http\Controllers\General\CharacteristicsWatersController@index')->name('resource.characteristics_water');
        Route::post('/update', 'App\Http\Controllers\General\CharacteristicsWatersController@update')->name('resource.characteristics_water.update');
        Route::post('/store', 'App\Http\Controllers\General\CharacteristicsWatersController@store')->name('resource.characteristics_water.store');
        Route::post('/accept', 'App\Http\Controllers\General\CharacteristicsWatersController@accept')->name('resource.characteristics_water.accept');
      });
    });

    Route::group(['prefix' => 'data-exchange','middleware' => 'data_exchange'], function () {
      Route::get('/', 'App\Http\Controllers\General\DataExchangeController@index')->name('exchange-index');
      Route::get('/instance-element', 'App\Http\Controllers\General\DataExchangeController@getInstanceElements')->name('exchange.instance.elements');
      Route::get('/instance-element-data', 'App\Http\Controllers\General\DataExchangeController@getInstanceElementData')->name('exchange.instance.element.data');
      Route::post('/', 'App\Http\Controllers\General\DataExchangeController@index')->name('exchange-index-post');
      Route::get('/sird-form', 'App\Http\Controllers\General\DataExchangeController@SirdForm')->name('get-oper-form');
      Route::post('/delete-object-from-sird', 'App\Http\Controllers\General\DataExchangeController@deleteObjFromSird')->name('post-delete-object-from-sird');
      Route::post('/change-sird', 'App\Http\Controllers\General\DataExchangeController@AjaxChangeSird')->name('ajax-change-sird');
      Route::post('/select-element', 'App\Http\Controllers\General\DataExchangeController@AjaxSelectElement')->name('ajax-select-element');
      Route::get('/amu-form', 'App\Http\Controllers\General\DataExchangeController@AmuForm')->name('get-amu-form');
      Route::get('/reservoir-form', 'App\Http\Controllers\General\DataExchangeController@ReservoirForm')->name('get-reservoir-form');
      Route::post('/delete-object-from-res', 'App\Http\Controllers\General\DataExchangeController@deleteObjFromRes')->name('post-delete-object-from-res');
      Route::post('/delete-object-from-amu', 'App\Http\Controllers\General\DataExchangeController@deleteObjFromAmu')->name('post-delete-object-from-amu');
      Route::post('/add-object-res', 'App\Http\Controllers\General\DataExchangeController@AddObjectRes')->name('post-add-object-res');
      Route::get('/daily-form', 'App\Http\Controllers\General\DataExchangeController@DailyForm')->name('get-daily-form');
      Route::post('/delete-object-from-daily', 'App\Http\Controllers\General\DataExchangeController@deleteObjFromDaily')->name('post-delete-object-from-daily');
      Route::get('/add-value', 'App\Http\Controllers\General\DataExchangeController@AddValueAjax')->name('add-value-ajax');
      Route::post('/add-infoadd-object-info-ajax', 'App\Http\Controllers\General\DataExchangeController@AddInfoAjax')->name('add-object-info-ajax');
      Route::post('/save-data-historry', 'App\Http\Controllers\General\DataExchangeController@saveDataHistorty')->name('exchange.save-history-data');
      Route::get('/logs', 'App\Http\Controllers\General\DataExchangeController@getLogList')->name('exchange.data-logs');
    });


    Route::group(['prefix' => 'directories'], function () {
      Route::group(['prefix' => 'list_posts'], function () {
        Route::get('/', 'App\Http\Controllers\General\ListPostsController@index')->name('directories.list_posts');
        Route::get('/edit', 'App\Http\Controllers\General\ListPostsController@edit')->name('directories.list_posts.edit');
        Route::post('/update', 'App\Http\Controllers\General\ListPostsController@update')->name('directories.list_posts.update');
        Route::post('/store', 'App\Http\Controllers\General\ListPostsController@store')->name('directories.list_posts.store');
        Route::get('/destroy/{id}', 'App\Http\Controllers\General\ListPostsController@destroy')->name('directories.list_posts.destroy');
      });

      Route::group(['prefix' => 'chemicals'], function () {
        Route::get('/', 'App\Http\Controllers\General\ChemicalController@index')->name('directories.chemicals');
        Route::get('/edit', 'App\Http\Controllers\General\ChemicalController@edit')->name('directories.chemicals.edit');
        Route::post('/update', 'App\Http\Controllers\General\ChemicalController@update')->name('directories.chemicals.update');
        Route::post('/store', 'App\Http\Controllers\General\ChemicalController@store')->name('directories.chemicals.store');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\General\ChemicalController@destroy')->name('directories.chemicals.destroy');
      });
    });

    Route::group(['prefix' => 'data'], function () {
      Route::get('/information', 'App\Http\Controllers\General\DataController@index')->name('information');
      Route::get('/getInfo', 'App\Http\Controllers\General\DataController@getInfo')->name('getinfo');
      Route::get('/getview', 'App\Http\Controllers\General\DataController@getView')->name('getview');
      Route::get('/getview-post', 'App\Http\Controllers\General\DataController@getViewPost')->name('getviewpost');
    });

    Route::group(['prefix' => 'admin'], function () {
      Route::get('/', [HomeController::class, 'adminIndex'])->name('admin');
      Route::resource('languages', LanguageController::class);

      Route::resource('terms', TermController::class)->except(['create', 'edit', 'show']);

      Route::get('users/get-division', [UserController::class, 'selectPosition'])->name('admin.users.get_division');
      Route::get('users/edit', [UserController::class, 'editByAxios'])->name('users.edit_by_axios');
      Route::post('users/close-all-users', [UserController::class, 'closeAllUsers'])->name('close-all-users');
      Route::resource('users', UserController::class)->except(['edit', 'show']);

      Route::prefix('/object/information')->group(function () {
        //Route::get('/', 'ObjectInformationController@cleanDouble')->name('clean-double');
        //Route::get('/', 'ObjectInformationController@index')->name('object-information');
        //Route::post('/', 'ObjectInformationController@index')->name('object-information-post');
        //Route::post('/add-info', 'ObjectInformationController@AddInfoAjax')->name('add-object-info-ajax');
        //Route::post('/add-area', 'ObjectInformationController@AddAreaAjax')->name('add-area-ajax');
        //Route::post('/add-in-value', 'ObjectInformationController@AddInValueAjax')->name('add-in-value-ajax');
        //Route::post('/add-out-value', 'ObjectInformationController@AddOutValueAjax')->name('add-out-value-ajax');
        Route::post('/import', 'ObjectInformationController@excelImport')->name('object-excel-import');
        Route::get('/export-information', 'ObjectInformationController@excelExport')->name('gvk-export-information');
      });
    });

    Route::get('map', [MapController::class, 'index'])->name('map');
  });
});

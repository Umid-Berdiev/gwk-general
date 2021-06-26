<?php

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
    Route::get('/', function () {
      return view('general.pages.dashboard');
    })->name('dashboard');


    Route::group(['prefix' => 'report'], function () {
      Route::get('/', 'App\Http\Controllers\General\WordExportController@index')->name('report.index');
      Route::post('/export', 'App\Http\Controllers\General\WordExportController@GenereteWord')->name('word.export');
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

    Route::prefix('data-exchange')->group(function () {
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

    Route::group(['prefix' => 'map'], function () {
      Route::get('/', function () {
        return view('general.pages.map.index');
      })->name('map');
      // Route::get('/', 'App\Http\Controllers\General\MapController@index')->name('map');
      Route::post('/search', 'App\Http\Controllers\General\MapController@search')->name('map.search');

      Route::get('/getdistricts', 'App\Http\Controllers\General\WaterbodiesController@getdistricts')->name('wb.getdistricts');
    });

    Route::group(['prefix' => 'approval_plots'], function () {
      Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\ApprovalPlotController@edit')->name('gg.reestr.ap.edit');
      //Route::get('/', 'Gidrogeologiya\ApprovalPlotController@index')->name('gg.reestr.ap.index');
      /*Route::get('/add', 'Gidrogeologiya\ApprovalPlotController@create')->name('gg.reestr.ap.create');
          Route::post('/store', 'Gidrogeologiya\ApprovalPlotController@store')->name('gg.reestr.ap.store');
          Route::post('/update', 'Gidrogeologiya\ApprovalPlotController@update')->name('gg.reestr.ap.update');
          Route::get('/destroy/{id}', 'Gidrogeologiya\ApprovalPlotController@destroy')->name('gg.reestr.ap.destroy');
          Route::get('/getselectedregion', 'Gidrogeologiya\ApprovalPlotController@getSelectedRegions')->name('gg.reestr.ap.getselectedregion');
          Route::get('/export', 'Gidrogeologiya\ApprovalPlotController@Export')->name('gg.reestr.ap.export');
          Route::get('/export/template', 'Gidrogeologiya\ApprovalPlotController@ExportTemplate')->name('gg.reestr.ap.export.template');
          Route::post('/import', 'Gidrogeologiya\ApprovalPlotController@Import')->name('gg.reestr.ap.import');
          Route::get('/search', 'Gidrogeologiya\ApprovalPlotController@Search')->name('gg.reestr.ap.search');
          Route::post('/accept', 'Gidrogeologiya\ApprovalPlotController@accept')->name('gg.reestr.ap.accept');
          Route::get('/acceptall', 'Gidrogeologiya\ApprovalPlotController@AcceptAll')->name('gg.reestr.ap.accept.all');*/
    });

    Route::group(['prefix' => 'birth_regions'], function () {
      Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\PlaceBirthController@edit')->name('gg.reestr.bp.edit');
      /*Route::get('/', 'Gidrogeologiya\PlaceBirthController@index')->name('gg.reestr.bp.index');
          Route::get('/add', 'Gidrogeologiya\PlaceBirthController@create')->name('gg.reestr.bp.create');
          Route::post('/store', 'Gidrogeologiya\PlaceBirthController@store')->name('gg.reestr.bp.store');
          Route::post('/update', 'Gidrogeologiya\PlaceBirthController@update')->name('gg.reestr.bp.update');
          Route::get('/destroy/{id}', 'Gidrogeologiya\PlaceBirthController@destroy')->name('gg.reestr.bp.destroy');
          Route::get('/getselectedregion', 'Gidrogeologiya\PlaceBirthController@getSelectedRegions')->name('gg.reestr.bp.getselectedregion');
          Route::get('/export', 'Gidrogeologiya\PlaceBirthController@Export')->name('gg.reestr.bp.export');
          Route::get('/export/template', 'Gidrogeologiya\PlaceBirthController@ExportTemplate')->name('gg.reestr.bp.export.template');
          Route::post('/import', 'Gidrogeologiya\PlaceBirthController@Import')->name('gg.reestr.bp.import');
          Route::get('/search', 'Gidrogeologiya\PlaceBirthController@Search')->name('gg.reestr.bp.search');
          Route::post('/accept', 'Gidrogeologiya\PlaceBirthController@accept')->name('gg.reestr.bp.accept');
          Route::get('/acceptall', 'Gidrogeologiya\PlaceBirthController@AcceptAll')->name('gg.reestr.bp.accept.all');*/
    });

    Route::group(['prefix' => 'mountain_ranges'], function () {
      Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\MountainRangesController@edit')->name('gg.reestr.mr.edit');
      /*Route::get('/', 'Gidrogeologiya\MountainRangesController@index')->name('gg.reestr.mr.index');
          Route::get('/add', 'Gidrogeologiya\MountainRangesController@create')->name('gg.reestr.mr.create');
          Route::post('/store', 'Gidrogeologiya\MountainRangesController@store')->name('gg.reestr.mr.store');
          Route::post('/update', 'Gidrogeologiya\MountainRangesController@update')->name('gg.reestr.mr.update');
          Route::get('/destroy/{id}', 'Gidrogeologiya\MountainRangesController@destroy')->name('gg.reestr.mr.destroy');
          Route::get('/getselectedregion', 'Gidrogeologiya\MountainRangesController@getSelectedRegions')->name('gg.reestr.mr.getselectedregion');*/
    });

    Route::group(['prefix' => 'wells'], function () {
      Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\WellsController@edit')->name('gg.reestr.wells.edit');
      /*Route::get('/', 'Gidrogeologiya\WellsController@index')->name('gg.reestr.wells.index');
          Route::get('/add', 'Gidrogeologiya\WellsController@create')->name('gg.reestr.wells.create');
          Route::post('/store', 'Gidrogeologiya\WellsController@store')->name('gg.reestr.wells.store');
          Route::post('/update', 'Gidrogeologiya\WellsController@update')->name('gg.reestr.wells.update');
          Route::get('/destroy/{id}', 'Gidrogeologiya\WellsController@destroy')->name('gg.reestr.wells.destroy');
          Route::get('/getselectedregion', 'Gidrogeologiya\WellsController@getSelectedRegions')->name('gg.reestr.wells.getselectedregion');
          Route::get('/export', 'Gidrogeologiya\WellsController@Export')->name('gg.wells.export');
          Route::get('/export/template', 'Gidrogeologiya\WellsController@ExportTemplate')->name('gg.wells.export.template');
          Route::post('/import', 'Gidrogeologiya\WellsController@Import')->name('gg.wells.import');
          Route::get('/search', 'Gidrogeologiya\WellsController@Search')->name('gg.reestr.wells.search');
          Route::post('/accept', 'Gidrogeologiya\WellsController@accept')->name('gg.reestr.wells.accept');
          Route::get('/acceptall', 'Gidrogeologiya\WellsController@AcceptAll')->name('gg.reestr.wells.accept.all');*/
    });

    Route::group(['prefix' => 'canals'], function () {
      Route::get('/edit', 'App\Http\Controllers\CanalsController@edit')->name('c.edit');
      /*Route::match(['GET', 'POST'], '/', 'CanalsController@index')->name('c.index');
          Route::get('/add', 'CanalsController@create')->name('c.create');
          Route::get('/destroy/{id}', 'CanalsController@destroy')->name('c.delete');
          Route::get('/getselectedregion', 'CanalsController@getSelectedRegions')->name('c.getselectedregion');
          Route::post('/store', 'CanalsController@store')->name('c.store');
          Route::post('/update', 'CanalsController@update')->name('c.update');
          Route::get('/export/template', 'CanalsController@ExportTemplate')->name('c.export.template');
          Route::get('/export', 'CanalsController@Export')->name('c.export');
          Route::post('/import', 'CanalsController@Import')->name('c.import');
          Route::get('/search', 'CanalsController@Search')->name('c.search');
          Route::post('/multiselect', 'CanalsController@MultiSelect')->name('c.delete_all');
          Route::post('/accept', 'CanalsController@accept')->name('c.accept');*/
    });

    Route::group(['prefix' => 'water_collaction'], function () {
      Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\WaterCollactionController@edit')->name('gg.reestr.wc.edit');
      /*Route::get('/', 'Gidrogeologiya\WaterCollactionController@index')->name('gg.reestr.wc.index');
          Route::get('/add', 'Gidrogeologiya\WaterCollactionController@create')->name('gg.reestr.wc.create');
          Route::post('/store', 'Gidrogeologiya\WaterCollactionController@store')->name('gg.reestr.wc.store');
          Route::post('/update', 'Gidrogeologiya\WaterCollactionController@update')->name('gg.reestr.wc.update');
          Route::get('/destroy/{id}', 'Gidrogeologiya\WaterCollactionController@destroy')->name('gg.reestr.wc.destroy');
          Route::get('/getselectedregion', 'Gidrogeologiya\WaterCollactionController@getSelectedRegions')->name('gg.reestr.wc.getselectedregion');
          Route::get('/export', 'Gidrogeologiya\WaterCollactionController@Export')->name('gg.reestr.wc.export');
          Route::get('/export/template', 'Gidrogeologiya\WaterCollactionController@ExportTemplate')->name('gg.reestr.wc.export.template');
          Route::post('/import', 'Gidrogeologiya\WaterCollactionController@Import')->name('gg.reestr.wc.import');
          Route::get('/search', 'Gidrogeologiya\WaterCollactionController@Search')->name('gg.reestr.wc.search');
          Route::post('/accept', 'Gidrogeologiya\WaterCollactionController@accept')->name('gg.reestr.wc.accept');
          Route::get('/acceptall', 'Gidrogeologiya\WaterCollactionController@AcceptAll')->name('gg.reestr.wc.accept.all');*/
    });

    Route::group(['prefix' => 'pump_station'], function () {
      Route::get('/edit', 'App\Http\Controllers\PumpStationController@edit')->name('ps.edit');
      /*Route::match(['GET', 'POST'], '/', 'PumpStationController@index')->name('ps.index');
          Route::get('/add', 'PumpStationController@create')->name('ps.create');
          Route::get('/destroy/{id}', 'PumpStationController@destroy')->name('ps.delete');
          Route::post('/store', 'PumpStationController@store')->name('ps.store');
          Route::post('/update', 'PumpStationController@update')->name('ps.update');
          Route::get('/getselectedregion', 'PumpStationController@getSelectedRegions')->name('ps.getselectedregion');
          Route::get('/export/template', 'PumpStationController@ExportTemplate')->name('ps.export.template');
          Route::get('/export', 'PumpStationController@Export')->name('ps.export');
          Route::post('/import', 'PumpStationController@Import')->name('ps.import');
          Route::get('/search', 'PumpStationController@Search')->name('ps.search');
          Route::post('/multiselect', 'PumpStationController@MultiSelect')->name('ps.delete_all');
          Route::post('/accept', 'PumpStationController@accept')->name('ps.accept');*/
    });

    Route::group(['prefix' => 'reservoirs'], function () {
      Route::get('/edit', 'App\Http\Controllers\ReservoirsController@edit')->name('rv.edit');
      /*Route::match(array('GET', 'POST'), '/', 'ReservoirsController@index')->name('rv.index');
          Route::get('/year', 'ReservoirsController@index_year')->name('rv.year');
          Route::get('/add', 'ReservoirsController@create')->name('rv.create');
          Route::get('/delete/{id}', 'ReservoirsController@destroy')->name('rv.delete');
          Route::post('/store', 'ReservoirsController@store')->name('rv.store');
          Route::post('/update', 'ReservoirsController@update')->name('rv.update');
          Route::get('/getselectedregion', 'ReservoirsController@getSelectedRegions')->name('rv.getselectedregion');
          Route::get('/search', 'ReservoirsController@Search')->name('rv.search');
          Route::get('/export', 'ReservoirsController@Export')->name('rv.export');
          Route::post('/multiselect', 'ReservoirsController@MultiSelect')->name('rv.delete_all');
          Route::post('/accept', 'ReservoirsController@accept')->name('rv.accept');*/
    });

    Route::group(['prefix' => 'waterworks'], function () {
      Route::get('/edit', 'App\Http\Controllers\WaterWorksController@edit')->name('ww.edit');
      /*Route::match(['GET', 'POST'], '/', 'WaterWorksController@index')->name('ww.index');
          Route::get('/add', 'WaterWorksController@create')->name('ww.create');
          Route::get('/destroy/{id}', 'WaterWorksController@destroy')->name('ww.delete');
          Route::get('/getselectedregion', 'WaterWorksController@getSelectedRegions')->name('ww.getselectedregion');
          Route::post('/store', 'WaterWorksController@store')->name('ww.store');
          Route::post('/update', 'WaterWorksController@update')->name('ww.update');
          Route::get('/export/template', 'WaterWorksController@ExportTemplateWaterworks')->name('ww.export.template');
          Route::get('/export', 'WaterWorksController@Export')->name('ww.export');
          Route::get('/search', 'WaterWorksController@Search')->name('ww.search');
          Route::post('/import/', 'WaterWorksController@Import')->name('ww.import');
          Route::get('/search', 'WaterWorksController@Search')->name('ww.search');
          Route::post('/multiselect', 'WaterWorksController@MultiSelect')->name('ww.delete_all');
          Route::post('/accept', 'WaterWorksController@accept')->name('ww.accept');*/
    });

    Route::group(['prefix' => 'collectors'], function () {
      Route::get('/edit', 'App\Http\Controllers\CollectorsController@edit')->name('ct.edit');
      /*Route::match(['GET', 'POST'], '/', 'CollectorsController@index')->name('ct.index');
          Route::get('/add', 'CollectorsController@create')->name('ct.create');
          Route::get('/delete/{id}', 'CollectorsController@destroy')->name('ct.delete');
          Route::post('/store', 'CollectorsController@store')->name('ct.store');
          Route::post('/update', 'CollectorsController@update')->name('ct.update');
          Route::get('/getselectedregion', 'CollectorsController@getSelectedRegions')->name('ct.getselectedregion');
          Route::get('/export/template', 'CollectorsController@ExportTemplate')->name('ct.export.template');
          Route::get('/export', 'CollectorsController@Export')->name('ct.export');
          Route::post('/import', 'CollectorsController@Import')->name('ct.import');
          Route::get('/search', 'CollectorsController@Search')->name('ct.search');
          Route::post('/multiselect', 'CollectorsController@MultiSelect')->name('ct.delete_all');
          Route::post('/accept', 'CollectorsController@accept')->name('ct.accept');*/
    });
  });
});

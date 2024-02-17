<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'App\Http\Controllers\Users'], function () {
    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
    });
});

Route::group(['namespace' => 'App\Http\Controllers', 'prefix' => 'exports', 'as' => 'exports.'], function () {
    Route::post('plan', 'ExportController@plan')->name('plan');
    Route::get('getDataMapChart', 'ExportController@getDataMapChart')->name('getDataMapChart');
    Route::get('getTrendDataMapChart', 'ExportController@getTrendDataMapChart')->name('getTrendDataMapChart');
    Route::get('getDataAnnualMapChart', 'ExportController@getDataAnnualMapChart')->name('getDataAnnualMapChart');
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::post('/upload', 'UploadController@upload')->name('upload');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {
    #settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::post('uploadmap', 'SettingController@uploadmap')->name('uploadmap');
    });

    #tasks
    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
        Route::get('/getAll', 'TaskController@getAll')->name('getAll');
        Route::post('update', 'TaskController@update')->name('update');
        Route::get('/{id}/getById', 'TaskController@getById')->name('getById');
        Route::delete('/{id}/destroy', 'TaskController@destroy')->name('destroy');
    });

    #taskdetails
    Route::group(['prefix' => 'taskdetails', 'as' => 'taskdetails.'], function () {
        Route::post('create', 'TaskDetailController@store')->name('store');
        Route::post('update', 'TaskDetailController@update')->name('update');
        Route::get('/', 'TaskDetailController@index')->name('index');
        Route::get('/{id}/show', 'TaskDetailController@show')->name('show');
        Route::delete('/{id}/destroy', 'TaskDetailController@destroy')->name('destroy');
        Route::get('/{id}/getById', 'TaskDetailController@getById')->name('getById');
    });

    #taskmaps
    Route::group(['prefix' => 'taskmaps', 'as' => 'taskmaps.'], function () {
        Route::post('create', 'TaskMapController@store')->name('store');
        Route::post('update', 'TaskMapController@update')->name('update');
        Route::get('/', 'TaskMapController@index')->name('index');
        Route::get('/{id}/show', 'TaskMapController@show')->name('show');
        Route::delete('/{id}/destroy', 'TaskMapController@destroy')->name('destroy');
    });

    #taskstaff
    Route::group(['prefix' => 'taskstaff', 'as' => 'taskstaff.'], function () {
        Route::post('create', 'TaskStaffController@store')->name('store');
        Route::post('update', 'TaskStaffController@update')->name('update');
        Route::get('/', 'TaskStaffController@index')->name('index');
        Route::get('/{id}/show', 'TaskStaffController@show')->name('show');
        Route::delete('/{id}/destroy', 'TaskStaffController@destroy')->name('destroy');
    });

    #taskchemistries
    Route::group(['prefix' => 'taskchemistries', 'as' => 'taskchemistries.'], function () {
        Route::post('create', 'TaskChemistryController@store')->name('store');
        Route::post('update', 'TaskChemistryController@update')->name('update');
        Route::get('/', 'TaskChemistryController@index')->name('index');
        Route::get('/{id}/show', 'TaskChemistryController@show')->name('show');
        Route::delete('/{id}/destroy', 'TaskChemistryController@destroy')->name('destroy');
    });

    #taskitems
    Route::group(['prefix' => 'taskitems', 'as' => 'taskitems.'], function () {
        Route::post('create', 'TaskItemController@store')->name('store');
        Route::post('update', 'TaskItemController@update')->name('update');
        Route::get('/', 'TaskItemController@index')->name('index');
        Route::get('/{id}/show', 'TaskItemController@show')->name('show');
        Route::delete('/{id}/destroy', 'TaskItemController@destroy')->name('destroy');
    });

    #tasksolutions
    Route::group(['prefix' => 'tasksolutions', 'as' => 'tasksolutions.'], function () {
        Route::post('create', 'TaskSolutionController@store')->name('store');
        Route::post('update', 'TaskSolutionController@update')->name('update');
        Route::get('/', 'TaskSolutionController@index')->name('index');
        Route::get('/{id}/show', 'TaskSolutionController@show')->name('show');
        Route::delete('/{id}/destroy', 'TaskSolutionController@destroy')->name('destroy');
    });

    #accounts
    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
        Route::delete('/{id}/destroy', 'AccountController@destroy')->name('destroy');
    });

    #customers
    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::delete('/{id}/destroy', 'CustomerController@destroy')->name('destroy');
    });

    #types
    Route::group(['prefix' => 'types', 'as' => 'types.'], function () {
        Route::delete('/{id}/destroy', 'TypeController@destroy')->name('destroy');
        Route::get('/getTypeByParentId', 'TypeController@getTypeByParentId')->name('getTypeByParentId');
    });

    #contracts
    Route::group(['prefix' => 'contracts', 'as' => 'contracts.'], function () {
        Route::post('/create', 'ContractController@store')->name('store');
        Route::delete('/{id}/destroy', 'ContractController@destroy')->name('destroy');
        Route::get('/getTypeByContractId', 'ContractController@getTypeByContractId')->name('getTypeByContractId');
        Route::get('/getAll', 'ContractController@index')->name('getAll');
    });

    #branches
    Route::group(['prefix' => 'branches', 'as' => 'branches.'], function () {
        Route::delete('/{id}/destroy', 'BranchController@destroy')->name('destroy');
        Route::get('/getBranchById', 'BranchController@getBranchById')->name('getBranchById');
    });

    #maps
    Route::group(['prefix' => 'maps', 'as' => 'maps.'], function () {
        Route::delete('/{id}/destroy', 'MapController@destroy')->name('destroy');
    });

    #solutions
    Route::group(['prefix' => 'solutions', 'as' => 'solutions.'], function () {
        Route::delete('/{id}/destroy', 'SolutionController@destroy')->name('destroy');
    });

    #items
    Route::group(['prefix' => 'items', 'as' => 'items.'], function () {
        Route::delete('/{id}/destroy', 'ItemController@destroy')->name('destroy');
    });

    #chemistries
    Route::group(['prefix' => 'chemistries', 'as' => 'chemistries.'], function () {
        Route::delete('/{id}/destroy', 'ChemistryController@destroy')->name('destroy');
    });

    #staffs
    Route::group(['prefix' => 'staffs', 'as' => 'staffs.'], function () {
        Route::delete('/{id}/destroy', 'InfoUserController@destroy')->name('destroy');
    });
});

// Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
//     Route::delete('/{id}/destroy', [AccountController::class, 'destroy'])->name('destroy');
// });

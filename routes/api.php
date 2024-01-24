<?php

use App\Http\Controllers\Admin\Accounts\AccountController;
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
        Route::post('export', 'TaskController@export')->name('export');
    });
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::post('/upload', 'UploadController@upload')->name('upload');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {
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
    });

    #contracts
    Route::group(['prefix' => 'contracts', 'as' => 'contracts.'], function () {
        Route::post('/create', 'ContractController@store')->name('store');
        Route::delete('/{id}/destroy', 'ContractController@destroy')->name('destroy');
        Route::get('/getTypeByContractId', 'ContractController@getTypeByContractId')->name('getTypeByContractId');
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

    #frequencies
    Route::group(['prefix' => 'frequencies', 'as' => 'frequencies.'], function () {
        Route::delete('/{id}/destroy', 'FrequencyController@destroy')->name('destroy');
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

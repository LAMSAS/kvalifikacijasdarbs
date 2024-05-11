<?php

use Illuminate\Support\Facades\Route;
use Modules\EmployeeTeams\App\Http\Controllers\EmployeeTeamsController;

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

Route::middleware(['auth', 'verified'])->name('employeeteams')->group(function () {
    Route::get('/employees-teams', [EmployeeTeamsController::class, 'list']);
    Route::post('/employees-teams', [EmployeeTeamsController::class, 'ajax']);

    Route::get('/employees-teams/create', [EmployeeTeamsController::class, 'create']);
    Route::post('/employees-teams/create', [EmployeeTeamsController::class, 'ajax']);

    Route::get('/employees-teams/profile/{id}/{tab?}', [EmployeeTeamsController::class, 'profile']);
    Route::post('/employees-teams/profile/{id}/{tab?}', [EmployeeTeamsController::class, 'ajax']);

    

});

<?php

use Illuminate\Support\Facades\Route;
use Modules\Employees\App\Http\Controllers\EmployeesController;
use Modules\Employees\App\Models\Employee;

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

Route::middleware(['auth', 'verified'])->name('employees')->group(function () {
    Route::get('/employees', [EmployeesController::class, 'list']);
    Route::post('/employees', [EmployeesController::class, 'ajax']);

    Route::get('/employees/profile/{id}/{tab?}', [EmployeesController::class, 'profile']);
    Route::post('/employees/profile/{id}/{tab?}', [EmployeesController::class, 'ajax']);

    Route::get('/employee/profile/new', [EmployeesController::class, 'create']);
    Route::post('/employee/profile/new', [EmployeesController::class, 'ajax']);
});

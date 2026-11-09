<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\HardwareController;

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

Route::get('/', [FormsController::class, 'forms']);

Route::controller(FormsController::class)->group(function () {
    Route::get('/forms', 'forms')->name('forms');
    Route::post('/forms/vpn', 'store_vpn')->name('forms.vpn.store');
    Route::get('/forms/vpn-list', 'vpn_list')->name('forms.vpn.list');
    Route::get('/forms/vpn/{id}', 'show_vpn')->name('forms.vpn.show');
    Route::get('/forms/signature/{empNo}', 'signature')->name('forms.signature');
});

Route::controller(ApprovalController::class)->group(function () {
    Route::get('/approval', 'approval')->name('approval');
    Route::get('/approval/list', 'approval_list')->name('approval.list');
    Route::post('/approval/vpn', 'vpn_action')->name('approval.vpn.action');
});

Route::controller(EmployeeController::class)->group(function () {
   Route::get('/get_employee', 'get_employee_details')->name('employee.details');
});

Route::controller(HardwareController::class)->group(function () {
    Route::get('/hardware', 'hardware')->name('hardware');
    Route::get('/hardware/list', 'hardware_list')->name('hardware.list');
    Route::post('/hardware/vpn/{id}', 'hardware_update')->name('hardware.vpn.update');
});
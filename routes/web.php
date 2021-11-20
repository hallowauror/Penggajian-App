<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PresenceController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('setting', [DashboardController::class, 'setting']);
    Route::post('setting', [DashboardController::class, 'updateProfile'])->name('setting.updateProfile');

    // Route Position
    Route::get('/position/{position}/delete', [PositionController::class, 'delete']);
    Route::resource('position', PositionController::class)->only([
       'index', 'store', 'update', 'edit'
    ]);

    // Route Employee
    Route::get('/employee/{employee}/delete', [EmployeeController::class, 'delete']);
    Route::resource('employee', EmployeeController::class)->only([
        'index', 'store', 'update', 'edit', 'show'
     ]);

   // Route Presence
   Route::get('/presence/{presence}/delete', [PresenceController::class, 'delete']);
   Route::resource('presence', PresenceController::class)->only([
      'index', 'store', 'update', 'edit', 'show'
   ]);

   Route::get('/payroll', [PresenceController::class, 'payroll']);
   Route::get('/payroll/pdf/{presence}', [PresenceController::class, 'payrollPdf'])->name('payroll.gaji_pdf');
   
});




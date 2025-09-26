<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\DashboardLivewire;
use App\Livewire\DepartmentLivewire;
use App\Livewire\EmployeeLivewire;
use App\Livewire\PermissionLivewire;
use App\Livewire\PositionLivewire;
use App\Livewire\RoleLivewire;
use App\Livewire\RolePermissionLivewire;
use App\Models\Department;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('auth')->group(function () {
    Route::get('/', DashboardLivewire::class)->name('dashboard');

    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/', EmployeeLivewire::class)->name('employee');
        Route::get('/department', DepartmentLivewire::class)->name('department');
        Route::get('/position', PositionLivewire::class)->name('position');
    });
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/role', RoleLivewire::class)->name('role');
        Route::get('/permission', PermissionLivewire::class)->name('permission');
    });

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

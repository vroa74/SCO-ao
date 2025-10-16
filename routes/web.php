<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\UserGroupController;

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

Route::redirect('/', 'login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Components page
    Route::get('/components', function () {
        return view('pages/components');
    })->name('components');

    // QR Code page
    Route::get('/qr', [QrCodeController::class, 'index'])->name('qr');
    Route::post('/qr/generate', [QrCodeController::class, 'generate'])->name('qr.generate');

    // Admin - Usuarios CRUD
    Route::resource('usuarios', UsuarioController::class)->names('usuarios');

    // Agenda CRUD
    Route::resource('agenda', AgendaController::class)->names('agenda');

    // User Groups CRUD
    Route::resource('user-groups', UserGroupController::class)->names('user-groups');
    Route::post('user-groups/{userGroup}/add-member', [UserGroupController::class, 'addMember'])->name('user-groups.add-member');
    Route::delete('user-groups/{userGroup}/remove-member', [UserGroupController::class, 'removeMember'])->name('user-groups.remove-member');
    Route::patch('user-groups/{userGroup}/update-member-role', [UserGroupController::class, 'updateMemberRole'])->name('user-groups.update-member-role');

    // 404 fallback
    Route::fallback(function() {
        return view('pages/utility/404');
    });    
});

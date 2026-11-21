
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BidController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Authentication untuk pengguna yang belum login
Route::middleware('guest')->group(function () {

    // Registrasi
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Daftar proyek untuk klien dan developer
Route::middleware(['auth', 'role:klien,developer'])->group(function () {

    Route::get('/projects', [ProjectController::class, 'index'])
        ->name('projects.index');

    Route::get('/projects/{project}', [ProjectController::class, 'show'])
        ->whereNumber('project')
        ->name('projects.show');
});

// Pengelolaan proyek khusus klien
Route::middleware(['auth', 'role:klien'])->group(function () {

    Route::get('/projects/create', [ProjectController::class, 'create'])
        ->name('projects.create');

    Route::post('/projects', [ProjectController::class, 'store'])
        ->name('projects.store');

    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])
        ->whereNumber('project')
        ->name('projects.edit');

    Route::put('/projects/{project}', [ProjectController::class, 'update'])
        ->whereNumber('project')
        ->name('projects.update');

    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
        ->whereNumber('project')
        ->name('projects.destroy');
});

// Sistem bidding khusus developer
Route::middleware(['auth', 'role:developer'])->group(function () {

    // Melihat daftar penawaran milik developer
    Route::get('/my-bids', [BidController::class, 'index'])
        ->name('bids.index');

    // Mengajukan penawaran pada proyek
    Route::post('/projects/{project}/bids', [BidController::class, 'store'])
        ->whereNumber('project')
        ->name('bids.store');
});

// Pemilihan pemenang khusus klien
Route::middleware(['auth', 'role:klien'])->group(function () {

    Route::post(
        '/projects/{project}/bids/{bid}/winner',
        [BidController::class, 'selectWinner']
    )
        ->whereNumber('project')
        ->whereNumber('bid')
        ->name('bids.winner');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

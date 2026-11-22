
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;

// Halaman utama
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Authentication
Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

// Dashboard pengguna
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Dashboard dan pengelolaan khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'users'])
        ->name('admin.users');

    Route::get('/admin/projects', [AdminController::class, 'projects'])
        ->name('admin.projects');
    Route::get('/admin/bids', [AdminController::class, 'bids'])
        ->name('admin.bids');
});

// Daftar dan detail proyek
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

// Bidding khusus developer
Route::middleware(['auth', 'role:developer'])->group(function () {

    Route::get('/my-bids', [BidController::class, 'index'])
        ->name('bids.index');

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

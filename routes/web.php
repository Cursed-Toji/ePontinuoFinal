<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PipedriveController;
use App\Http\Controllers\PontuacaoController;
use App\Http\Controllers\TestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/pipedrive', [PipedriveController::class, 'index']);
Route::post('/pipedrive', [PipedriveController::class, 'index']);

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('pontuacao', [PontuacaoController::class, 'geral'])->name('pontuacao.geral');
    Route::post('pontuacao', [PontuacaoController::class, 'atualizar']);
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

});



require __DIR__ . '/auth.php';

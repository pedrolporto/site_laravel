<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sobre', function () {
    return view('sobre');
});

Route::get('/contato', 'App\Http\Controllers\ContatoController@index');
Route::post('/contato/enviar', 'App\Http\Controllers\ContatoController@enviar');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/produtos','App\Http\Controllers\ProdutosController'); #->middleware(['auth']);

Route::post('produtos/busca','App\Http\Controllers\ProdutosController@busca');
Route::post('produtos/ordem','App\Http\Controllers\ProdutosController@ordem');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

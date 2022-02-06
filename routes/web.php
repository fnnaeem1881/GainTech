<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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



// Crud Route

Route::get('/', [UserController::class, 'index'])->name('user_list');


Route::get('/profile_view/{$id}', [UserController::class, 'show'])->name('profile_view');
Route::post('/profile_update', [UserController::class, 'profile_update'])->name('profile_update');
Route::post('/user_store', [UserController::class, 'store'])->name('user_store');
Route::get('/destory/{$id}','App\Http\Controllers\UserController@dehstroy')->name('destroy');


// Route::get('/destroy/{$id}', function ($id) {
//     return 'User '.$id;
// })->middleware(['auth'])->name('destroy');



Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth'])->name('profile');

require __DIR__.'/auth.php';

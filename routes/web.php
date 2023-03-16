<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
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



Route::get('/',[PostController::class,'index'])->name('index');

Route::get('/create',function(){
    return view('create');
});

Route::post('/post',[PostController::class,'store'])->name('store');
Route::delete('/delete/{id}',[PostController::class,'delete'])->name('delete');
Route::get('/edit/{id}',[PostController::class,'edit'])->name('edit');


Route::delete('/deleteimage/{id}',[PostController::class,'deleteImage'])->name('delete.image');
Route::delete('/deletecover/{id}',[PostController::class,'deleteCover'])->name('delete.cover');


Route::put('/update/{id}',[PostController::class,'update'])->name('update');

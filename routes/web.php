<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/note/restore/{id}', [NoteController::class, 'restore'])->name('restore');
Route::get('/note/restore-all', [NoteController::class, 'restoreAll'])->name('restoreAll');
Route::get('/note/deletedNote', [NoteController::class, 'deletedNote'])->name('deletedNote');
Route::resource('/note', NoteController::class);

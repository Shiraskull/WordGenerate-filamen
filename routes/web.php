<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('word', WordController::class);
Route::get('/download/{record}',[DownloadController::class,'docx'])->name('download.docx');

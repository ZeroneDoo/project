<?php

use App\Http\Controllers\{
    KkjController,
    RoleController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource("role", RoleController::class);
Route::resource("kkj", KkjController::class);
Route::prefix("kkj")->name("kkj.")->group(function(){
    Route::get("/anak/{id}", [KkjController::class, "destroyAnak"])->name('destroy.anak');
    Route::get("/keluarga/{id}", [KkjController::class, "destroyKeluarga"])->name('destroy.keluarga');
});

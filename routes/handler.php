<?php

use App\Http\Controllers\HandlerController;
use Illuminate\Support\Facades\Route;

Route::prefix("handler")->name("handler.")->group(function(){
    Route::get("/baptis", [HandlerController::class, "formBaptis"])->name('baptis.show');
    Route::get("/baptis", [HandlerController::class, "baptis"]);
});
<?php

use App\Http\Controllers\{
    BaptisController,
    HandlerController,
    KkjController,
    PendetaController,
    PenyerahanBaptisController,
    PenyerahanController,
    PernikahanController,
    RoleController,
    UserController,
    HomeController,
    CabangController
};
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/', [HomeController::class, 'index']);


Route::middleware("auth")->group(function(){
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name("dashboard");

    Route::resource("pendeta", PendetaController::class);
    Route::resource('user', UserController::class);

    Route::resource('baptis', BaptisController::class);
    Route::resource('penyerahan', PenyerahanController::class);

    Route::resource('penyerahan-baptis', PenyerahanBaptisController::class);
    Route::prefix('penyerahan-baptis')->name('penyerahan-baptis.')->group(function(){
        Route::post('/searchkkj', [PenyerahanBaptisController::class, 'searchKkj'])->name('searchkkj');
        Route::post('/getkandidat', [PenyerahanBaptisController::class, 'getKandidat'])->name('getKandidat');
    });

    Route::resource('pernikahan', PernikahanController::class);
    Route::prefix('pernikahan')->name('pernikahan.')->group(function(){
        Route::post('/searchkkj', [PernikahanController::class, 'searchKkj'])->name('searchkkj');
        Route::post('/getkandidat', [PernikahanController::class, 'getKandidat'])->name('getKandidat');
    });

    Route::resource("role", RoleController::class);
    Route::resource("kkj", KkjController::class);
    Route::prefix("kkj")->name("kkj.")->group(function(){
        Route::get("/anak/{id}", [KkjController::class, "destroyAnak"])->name('destroy.anak');
        Route::get("/keluarga/{id}", [KkjController::class, "destroyKeluarga"])->name('destroy.keluarga');
    });

    Route::resource("cabang", CabangController::class);
    Route::prefix("cabang")->name("cabang.")->group(function(){
        Route::get("/pendeta/{id}", [CabangController::class, "destroyPendeta"])->name("destroy.pendeta");
        Route::get("/ibadah/{id}", [CabangController::class, "destroyJadwalIbadah"])->name("destroy.ibadah");
        Route::get("/kegiatan/{id}", [CabangController::class, "destroyListKegiatan"])->name("destroy.kegiatan");
    });

    // handler
    Route::prefix("handler")->name("handler.")->group(function(){
        // kkj
        Route::get("/kkj/{id}", [HandlerController::class, "formKkj"])->name('kkj.show');
        Route::patch("/kkj/{id}", [HandlerController::class, "requestKkj"])->name('kkj.update');
        
        // baptis
        Route::get("/baptis/{id}", [HandlerController::class, "formBaptis"])->name('baptis.show');
        Route::patch("/baptis/{id}", [HandlerController::class, "requestBaptis"])->name('baptis.update');
        
        // penyerahan
        Route::get("/penyerahan/{id}", [HandlerController::class, "formPenyerahan"])->name('penyerahan.show');
        Route::patch("/penyerahan/{id}", [HandlerController::class, "requestPenyerahan"])->name('penyerahan.update');
    
        // pernikahan
        Route::get("/pernikahan/{id}", [HandlerController::class, "formpernikahan"])->name('pernikahan.show');
        Route::patch("/pernikahan/{id}", [HandlerController::class, "requestpernikahan"])->name('pernikahan.update');
    });
});


require __DIR__."/auth.php";
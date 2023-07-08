<?php

use App\Http\Controllers\{
    BaptisController,
    KkjController,
    PenyerahanBaptisController,
    PenyerahanController,
    PernikahanController,
    RoleController,
    UserController,
};
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/test', function(){
    return view('tes');
    // generateCode();

    // $options = new Options();
    // $options->set('defaultFont', 'sans-serif');
    // $dompdf = new Dompdf($options);
    // $dompdf->setPaper('A3', 'landscape');
    
    // // Load the HTML template and generate the PDF
    // $html = View::make('pdf.kkj.kkj');
    // $dompdf->loadHtml($html);
    // $dompdf->render();
    
    // // Output the PDF to the browser
    // return $dompdf->stream('output.pdf');
});

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, "login"])->name('auth.login');
    Route::post('/login', [AuthController::class, "storeLogin"])->name('auth.store.login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");

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

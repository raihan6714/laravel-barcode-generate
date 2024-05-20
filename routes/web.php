<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('barcode', function () {
    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
    $image = $generatorPNG->getBarcode('01834526714', $generatorPNG::TYPE_CODE_128);

    return response($image)->header('Content-type','image/png');
});

Route::get('barcode-save', function () {
    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
    $image = $generatorPNG->getBarcode('01834526714', $generatorPNG::TYPE_CODE_128);

    \Illuminate\Support\Facades\Storage::put('barcodes/demo.png', $image);

    return response($image)->header('Content-type','image/png');
});

Route::get('barcode-blade', function () {
    $generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
    $barcode = $generatorHTML->getBarcode('01834526714', $generatorHTML::TYPE_CODE_128);

    return view('barcode', compact('barcode'));
});

require __DIR__.'/auth.php';

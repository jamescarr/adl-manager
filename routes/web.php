<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resources([
        'patients' => PatientController::class,
        'adl-types' => AdlTypeController::class,
        'adl-records' => AdlRecordController::class,
    ]);
});

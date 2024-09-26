<?php

use Illuminate\Support\Facades\Route;



Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);
Route::group(['middleware' => ['auth']], function() {
Route::get('/', function () {
    return view('process_data');
});
Route::get('/process', [App\Http\Controllers\LoanEmiController::class, 'showProcessPage'])->name('process_data');
Route::post('/process-data', [App\Http\Controllers\LoanEmiController::class, 'processLoanEmi'])->name('process.data');
});

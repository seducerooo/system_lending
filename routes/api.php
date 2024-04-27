<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ContractController;
use \App\Http\Controllers\LoanApplicationController;

// ContractController routes
Route::put('/contracts/{contract}/terminate', [ContractController::class, 'terminate']);
Route::post('/contracts', [ContractController::class, 'store']);

// LoanApplicationController routes
Route::post('/loan-applications', [LoanApplicationController::class, 'store']);
Route::put('/loan-applications/{application}/decide', [LoanApplicationController::class, 'decideApplication']);

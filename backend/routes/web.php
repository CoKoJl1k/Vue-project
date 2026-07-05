<?php

use App\Http\Controllers\CurrencyAlertController;
use Illuminate\Support\Facades\Route;

Route::post('/api/alert', [CurrencyAlertController::class, 'save']);


Route::view('/', 'welcome');

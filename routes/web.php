<?php

use App\Http\Controllers\WalletActivityController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/wallet-activity', [WalletActivityController::class, 'index']);

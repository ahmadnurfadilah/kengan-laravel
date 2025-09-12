<?php

use App\Http\Controllers\API\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/plans', [SubscriptionController::class, 'getPlans']);
Route::get('/subscription/{userId}', [SubscriptionController::class, 'getSubscription']);

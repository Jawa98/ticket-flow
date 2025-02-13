<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::post('/events/{event}/purchase-tickets', [EventController::class, 'purchaseTickets']);
    Route::apiResource('events', EventController::class); 
});

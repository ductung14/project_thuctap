<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventRegistrationController;
use Illuminate\Support\Facades\Log;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', EventController::class);
    Route::get('events/{event}/registrations', [EventRegistrationController::class, 'index']);
    Route::post('events/{event}/register', [EventRegistrationController::class, 'register']);
    Route::delete('events/{event}/unregister', [EventRegistrationController::class, 'unregister']);
    Route::put('/events/{event}', [EventController::class, 'update']);
});

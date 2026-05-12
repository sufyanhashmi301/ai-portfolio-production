<?php

// Reserved for future Laravel route definitions in next phases.
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HealthController;

Route::get('/health', HealthController::class);

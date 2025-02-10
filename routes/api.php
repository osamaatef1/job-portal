<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Protected Routes
    Route::middleware('auth:api')->group(function () {

        Route::post('auth', [AuthController::class, '__invoke']);
        Route::post('login', [LoginController::class, '__invoke']);
        // Verification Routes
        Route::post('verify/send', [VerificationController::class, 'send']);
        Route::post('verify/confirm', [VerificationController::class, 'verify']);

        // Job Routes
        Route::get('jobs', [JobController::class, 'index']);
        Route::get('jobs/{job}', [JobController::class, 'show']);

        // Admin Job Management Routes
        Route::middleware('can:manage-jobs')->group(function () {
            Route::post('jobs', [JobController::class, 'store']);
            Route::put('jobs/{job}', [JobController::class, 'update']);
            Route::delete('jobs/{job}', [JobController::class, 'destroy']);
        });

        // Job Application Routes
        Route::post('jobs/{job}/apply', [JobApplicationController::class, 'apply'])
            ->middleware('can:apply,job');

        // File Management Routes
        Route::delete('files/{file}', [FileController::class, 'delete'])
            ->middleware('can:delete,file');
    });
});
<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\ReplySupportController;
use App\Http\Controllers\Api\SupportController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/{id}', [CourseController::class, 'show']);
        Route::get('/{id}/modules', [ModuleController::class, 'index']);
    });

    Route::controller(LessonController::class)->prefix('modules')->group(function () {
        Route::get('/{id}/lessons', 'index');
    });

    Route::controller(LessonController::class)->prefix('lessons')->group(function () {
        Route::get('/{id}', 'show');
    });

    Route::controller(SupportController::class)->prefix('supports')->group(function () {
        Route::get('/', 'index');
        Route::get('/my', 'mySupports');
        Route::post('/', 'store');
        Route::post('/{id}/replies', 'createReply');
    });

    Route::controller(ReplySupportController::class)->prefix('replies')->group(function () {
        Route::post('/', 'createReply');
    });
});

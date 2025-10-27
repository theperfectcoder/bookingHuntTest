<?php
declare(strict_types=1);

use App\Http\Controllers\Hunting\BookingController;
use App\Http\Controllers\Hunting\GuideController;
use Illuminate\Support\Facades\Route;

Route::get('/guides', [GuideController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);

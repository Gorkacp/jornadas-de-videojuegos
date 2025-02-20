<?php

use App\Http\Controllers\Api\EventApiController;
use Illuminate\Support\Facades\Route;

Route::get('events/{id}', [EventApiController::class, 'show']);
<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Ruta para el dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroyProfile'])->name('profile.destroy');
});

// Rutas para eventos
Route::resource('events', EventController::class);

// Rutas para ponentes
Route::resource('speakers', SpeakerController::class);

// Rutas para asistentes
Route::resource('assistants', AssistantController::class);
Route::get('assistants/{id}/payment', [AssistantController::class, 'payment'])->name('assistants.payment');
Route::post('assistants/{id}/complete-payment', [AssistantController::class, 'completePayment'])->name('assistants.completePayment');

// Rutas para PayPal
Route::post('/paypal/create-payment', [PayPalController::class, 'createPayment'])->name('paypal.createPayment');
Route::get('/paypal/execute-payment', [PayPalController::class, 'executePayment'])->name('paypal.executePayment');
Route::get('/paypal/cancel-payment', [PayPalController::class, 'cancelPayment'])->name('paypal.cancelPayment');

// Rutas para el registro de usuarios
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

// Rutas para la gestión de usuarios
Route::resource('usuario', UserController::class)->middleware('auth');

require __DIR__.'/auth.php';
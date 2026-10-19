<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CalculoController;
use App\Http\Middleware\CheckSubscription;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página inicial – lista de planos
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Página de pagamento (seleção de plano)
Route::get('/payment/{plan}', [PaymentController::class, 'showPaymentForm'])
    ->name('payment.show');

// Processar pagamento (PIX / Boleto)
Route::post('/payment/process', [PaymentController::class, 'processPayment'])
    ->name('payment.process');

// Cancelar pagamento
Route::post('/payment/cancel', [PaymentController::class, 'cancelPayment'])
    ->name('payment.cancel');

// Registro após pagamento
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])
    ->name('register.show');

Route::post('/register', [RegistrationController::class, 'processRegistration'])
    ->name('register.process');


/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS (USUÁRIO LOGADO)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Página para renovar assinatura
    Route::get('/renovar', [ContentController::class, 'showRenewForm'])
        ->name('renew.show');

    /*
    |--------------------------------------------------------------------------
    | ROTAS PROTEGIDAS POR ASSINATURA ATIVA
    |--------------------------------------------------------------------------
    */
    Route::middleware([CheckSubscription::class])->group(function () {

        // Dashboard
        Route::get('/dashboard', [ContentController::class, 'dashboard'])
            ->name('dashboard');

        // Cálculo de preço
        Route::post('/calcular', [CalculoController::class, 'create'])
            ->name('calcular');
    });
});

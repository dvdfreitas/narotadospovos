<?php

use App\Http\Controllers\MbWayNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Notificação da ifthenpay sobre o estado final de um pagamento MB Way.
//
// {payment:reference} resolve o pagamento pela coluna reference — a nossa,
// que enviámos no notificationUrl. O corpo da notificação só traz o
// RequestId, que num timeout podemos nunca ter recebido.
//
// Aberta a toda a internet, sem sessão nem CSRF: a ifthenpay não tem cookies
// nossos. Quem autentica é a assinatura HMAC, validada no controlador.
Route::post('/mbway/notify/{payment:reference}', MbWayNotificationController::class)
    ->name('mbway.notify');

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Models\Assistant;
use App\Notifications\PaymentReceipt;

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $paypalConfig = config('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );

        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    public function createPayment(Request $request)
{
    // Validar que el id del asistente sea válido
    $request->validate([
        'assistant_id' => 'required|exists:assistants,id',  // Usamos el campo 'id' de la tabla assistants
    ]);

    $assistant = Assistant::findOrFail($request->assistant_id); // Buscar el asistente por el id

    // Definir la cantidad a pagar
    $amount = new Amount();
    $amount->setCurrency('USD')->setTotal(10.00); // Cambia el total a lo que corresponda

    // Crear la transacción
    $transaction = new Transaction();
    $transaction->setAmount($amount)
                ->setDescription('Pago para evento: ' . $assistant->event->title);

    // Payer (quien hace el pago)
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    // Direcciones de redirección
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl(route('paypal.executePayment', ['assistant_id' => $assistant->id]))  // Usamos el id del asistente en la ruta
                 ->setCancelUrl(route('paypal.cancelPayment'));

    // Crear el pago
    $payment = new Payment();
    $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

    try {
        $payment->create($this->apiContext);  // Usar el apiContext configurado

        return redirect()->away($payment->getApprovalLink()); // Redirigir a PayPal para autorizar el pago
    } catch (\Exception $ex) {
        return back()->withErrors(['error' => 'Hubo un error al crear el pago. ' . $ex->getMessage()]);
    }
}


public function executePayment(Request $request)
{
    // Verificamos que el id del asistente esté presente
    $request->validate([
        'assistant_id' => 'required|exists:assistants,id',  // Validar que el id existe en la tabla
    ]);

    $paymentId = $request->paymentId;
    $payerId = $request->PayerID;
    $assistantId = $request->assistant_id;  // Usamos el id del asistente aquí

    $payment = Payment::get($paymentId, $this->apiContext);

    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    try {
        $result = $payment->execute($execution, $this->apiContext);

        // Marcar el pago como completado en tu base de datos
        $assistant = Assistant::findOrFail($assistantId); // Buscamos el asistente por el id
        $assistant->payment_status = 'completed';
        $assistant->save();

        // Enviar notificación de comprobante de pago
        $assistant->notify(new PaymentReceipt($assistant));

        return redirect()->route('assistants.index')->with('success', 'Pago completado exitosamente.');
    } catch (\Exception $ex) {
        return back()->withErrors(['error' => 'Hubo un error al procesar el pago: ' . $ex->getMessage()]);
    }
   } 
}
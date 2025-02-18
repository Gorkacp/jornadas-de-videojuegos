<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Notifications\PaymentReceipt;
use App\Models\Assistant;

class PayPalController extends Controller
{
    public function createPayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "100.00" // Aquí puedes ajustar el valor según sea necesario
                    ]
                ]
            ]
        ]);

        if (isset($response['id'])) {
            // Redirigir al usuario a la URL de aprobación de PayPal
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
        } else {
            return redirect()->route('assistants.index')->withErrors(['error' => 'Error al crear el pago de PayPal.']);
        }
    }

    public function capturePayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Actualizar el estado del pago en la base de datos
            $assistant = Assistant::find($request->assistant_id);
            $assistant->payment_status = 'completed';
            $assistant->save();

            // Enviar notificación de comprobante de pago
            $assistant->notify(new PaymentReceipt($assistant));

            return redirect()->route('assistants.index')->with('success', 'Pago completado exitosamente.');
        } else {
            return redirect()->route('assistants.index')->withErrors(['error' => 'Error al capturar el pago de PayPal.']);
        }
    }
}
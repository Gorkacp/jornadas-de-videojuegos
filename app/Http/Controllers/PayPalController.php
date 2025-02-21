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
use PayPal\Exception\PayPalConnectionException;

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );

        $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function createPayment(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:0.01',
        ]);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal(number_format($request->total, 2, '.', ''));
        $amount->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Payment description');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.executePayment'))
                     ->setCancelUrl(route('paypal.cancelPayment'));

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            return redirect()->route('events.index')->with('error', 'Some error occurred, please try again later.');
        }
    }

    public function executePayment(Request $request)
    {
        $paymentId = $request->paymentId;
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        try {
            $result = $payment->execute($execution, $this->apiContext);
            return redirect()->route('events.index')->with('success', 'Payment successful');
        } catch (PayPalConnectionException $ex) {
            return redirect()->route('events.index')->with('error', 'Payment failed');
        }
    }

    public function cancelPayment()
    {
        return redirect()->route('events.index')->with('error', 'Payment cancelled');
    }
}
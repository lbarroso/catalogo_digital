<?php

namespace App\Service;

use Illuminate\Http\Request;

class MercadoPagoService{

    function __construct()
    {
        \MercadoPago\SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

    }

    public function payment(Request $request, float $amount){

        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = (float) $amount;
        $payment->token = $request->token;
        $payment->description = $request->description;
        $payment->installments = (int) $request->installments;
        $payment->payment_method_id = $request->paymentMethodId;
        $payment->issuer_id = (int) $request->issuer;

        $payer = new \MercadoPago\Payer();
        $payer->email = auth()->user()->email;

        $payment->payer = $payer;

        $payment->save();

        $response = array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );

        return $response;
    }
}
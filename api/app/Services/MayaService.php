<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MayaService
{
    public function createCheckout(
        string $transactionNumber,
        array $items,
        float $amount,
        string $firstName,
        string $lastName
    ): array {
        $response = Http::withBasicAuth(
            config('services.maya.public_key'),
            config('services.maya.secret_key')
        )->post(
            config('services.maya.base_url') . '/checkout/v1/checkouts',
            [
                'totalAmount' => [
                    'value' => $amount,
                    'currency' => 'PHP',
                ],

                'buyer' => [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                ],

                'items' => $items,

                'requestReferenceNumber' => $transactionNumber,

                'redirectUrl' => [
                    'success' => config('app.url') . '/api/v1/payment/success?requestReferenceNumber=' . $transactionNumber ,
                    'failure' => config('app.frontend_url') . '/payment/failed',
                    'cancel'  => config('app.frontend_url') . '/payment/cancel',
                ],
            ]
        );

        $response->throw();

        return $response->json();
    }
}
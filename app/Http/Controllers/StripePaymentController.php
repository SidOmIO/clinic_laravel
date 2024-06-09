<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $stripeSecretKey = env('STRIPE_SECRET_KEY');
        Stripe::setApiKey($stripeSecretKey);

        if ($request->isMethod('post')) {
            $items = $request->input('items');

            $lineItems = [];
            foreach ($items as $item) {
                $unitAmount = (int)($item['price'] * 100);

                $lineItems[] = [
                    'quantity' => $item['quantity'],
                    'price_data' => [
                        'currency' => 'myr',
                        'unit_amount' => $unitAmount,
                        'product_data' => [
                            'name' => $item['name']
                        ]
                    ]
                ];
            }

            $checkoutSession = Session::create([
                'mode' => 'payment',
                'success_url' => route('consultations.details', ['id' => $request->input('id'), 'session_id' => '{CHECKOUT_SESSION_ID}']),
                'cancel_url' => route('consultations.details', ['id' => $request->input('id')]),
                'locale' => 'auto',
                'line_items' => $lineItems
            ]);

            return redirect($checkoutSession->url);
        }
    }
}

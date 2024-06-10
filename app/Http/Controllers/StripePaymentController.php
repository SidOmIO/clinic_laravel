<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Payment;
use App\Models\Consultation;
use App\Models\AdminLog;
use App\Services\EmailService;

class StripePaymentController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

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
                'success_url' => route('payment.completed', ['id' => $request->input('id')]) . '&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('consultations.details', ['id' => $request->input('id')]),
                'locale' => 'auto',
                'line_items' => $lineItems
            ]);

            return redirect($checkoutSession->url);
        }
    }

    public function completed(Request $request)
{
    if ($request->has('session_id')) {
        $sessionId = $request->input('session_id');

        $stripeSecretKey = env('STRIPE_SECRET_KEY');
        Stripe::setApiKey($stripeSecretKey);
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        $consultationId = $request->input('id');

        if ($session->payment_status == 'paid') {
            $paymentExists = Payment::where('consultation_id', $consultationId)->exists();

            if (!$paymentExists) {
                $payment = new Payment();
                $payment->consultation_id = $consultationId;
                $payment->stripe_id = $sessionId;
                $payment->email = Auth::user()->email;
                $payment->save();

                $consultation = Consultation::find($consultationId);
                $consultation->payment_id = $payment->id;
                $consultation->save();

                AdminLog::create([
                    'action_type' => 'user_payment',
                    'email' => Auth::user()->email,
                    'timestamp' => now(),
                ]);
    
                $this->emailService->sendEmail(Auth::user()->email, 'email.payment_title', 'email.payment_body');

                return redirect()->route('consultations.details', ['id' => $consultationId, 'email' => Auth::user()->email])->with('success', 'Payment Successful!');
            } else {
                return redirect()->route('consultations.details', ['id' => $consultationId, 'email' => Auth::user()->email])->with('error', 'Payment for this consultation already exists.');
            }
        } else {
            return redirect()->route('consultations.details', ['id' => $consultationId, 'email' => Auth::user()->email])->with('error', 'Payment status is not paid');
        }
    } 
}
}

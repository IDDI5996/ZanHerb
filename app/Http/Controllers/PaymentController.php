<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
     public function form()
    {
        return view('payment.form');
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:500',
            'provider' => 'required|in:mpesa,tigopesa',
        ]);

        // Create payment record
        $payment = Payment::create([
            'provider' => $request->provider,
            'phone' => $request->phone,
            'amount' => $request->amount,
        ]);

        // Simulate or call real payment API here
        $payment->update([
            'status' => 'success',
            'transaction_id' => 'SIMULATED123',
            'response' => 'Simulated payment successful.',
        ]);

        return redirect()->back()->with('success', 'Payment simulated successfully. Transaction ID: ' . $payment->transaction_id);
    }

}

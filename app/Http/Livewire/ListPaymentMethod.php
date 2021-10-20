<?php

namespace App\Http\Livewire;

use App\Models\PaymentMethod;
use Livewire\Component;

class ListPaymentMethod extends Component
{
    public function render()
    {
        $paymentmethods = PaymentMethod::all();
        return view('livewire.list-payment-method', compact('paymentmethods'));
    }
}

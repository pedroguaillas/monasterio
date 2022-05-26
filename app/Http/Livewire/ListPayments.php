<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Payment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ListPayments extends Component
{
    public $customer_id;

    public function render()
    {
        $customer = Customer::find($this->customer_id);
        $payments = Payment::select(DB::raw("amount, description, DATE_FORMAT(start_period, '%d-%m-%Y') AS start_period, DATE_FORMAT(end_period, '%d-%m-%Y') AS end_period, to_pay"))
            ->join('payment_items', 'payment_id', 'payments.id')
            ->where('customer_id', $this->customer_id)
            ->orderBy('start_period', 'DESC')
            ->get();

        return view('livewire.list-payments', compact('payments', 'customer'));
    }
}

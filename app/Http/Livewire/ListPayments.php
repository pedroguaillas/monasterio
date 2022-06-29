<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentItem;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ListPayments extends Component
{
    public $customer_id;

    protected $listeners = ['delete'];

    public function render()
    {
        $customer = Customer::find($this->customer_id);
        $payments = Payment::select(DB::raw("payments.id, SUM(amount) AS amount, DATE_FORMAT(start_period, '%d-%m-%Y') AS start_period, DATE_FORMAT(end_period, '%d-%m-%Y') AS end_period, to_pay"))
            ->join('payment_items', 'payment_id', 'payments.id')
            ->where('customer_id', $this->customer_id)
            ->orderBy('start_period', 'DESC')
            ->groupBy('id', "start_period", "end_period", "to_pay")
            ->get();

        return view('livewire.list-payments', compact('payments', 'customer'));
    }

    // Delete payment
    public function delete(Payment $payment)
    {
        PaymentItem::where("payment_id", $payment->id)->delete();
        $payment->delete();
    }
}

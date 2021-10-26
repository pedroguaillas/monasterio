<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class SearchSmartCustomers extends Component
{
    public $search, $customer, $payment, $paymentmethod;
    public $date_next_month;
    public $amount;

    // payments
    public $payments;

    protected $rules = [
        'payment.date' => 'required',
        'payment.amount' => 'required',
    ];

    public function mount()
    {
        $this->payment = null;
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +1 month'));
    }

    public function updatingPaymentDate($value)
    {
        $this->date_next_month = date('d/m/Y', strtotime($value . ' +' . $this->paymentmethod->months . ' month'));
    }

    public function updatingAmount($value)
    {
        $this->paymentmethod = PaymentMethod::find($value);

        $this->payment->amount = $this->paymentmethod->amount;
        $this->date_next_month = date('d/m/Y', strtotime($this->payment->date . ' +' . $this->paymentmethod->months . ' month'));
    }

    public function render()
    {
        $customers = null;

        if ($this->search !== null && $this->search !== '') {
            $customers = Customer::where('identification', 'like', '%' . $this->search . '%')
                ->orWhere('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                ->paginate(5);
        }
        $paymentmethods = PaymentMethod::all();

        return view('livewire.search-smart-customers', compact('customers', 'paymentmethods'));
    }

    public function storePayment()
    {
        $auth = Auth::user();

        $payment = $this->customer->payments()->create([
            'branch_id' => 1,
            'user_id' => $auth->id,
            'date' => $this->payment->date,
            'amount' => $this->payment->amount,
            'type' => 'mensual',
        ]);

        if ($payment) {
            $this->emit('closeModal');
        }
    }

    public function edit(Customer $customer)
    {
        $this->customer = $customer;

        $this->paymentmethod = PaymentMethod::first();

        $this->payment = new Payment;
        $this->payment->date = date('Y-m-d');
        $this->payment->amount = $this->paymentmethod->amount;
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +' . $this->paymentmethod->months . ' month'));

        $this->emit('showModal');
    }

    public function listpayments(Customer $customer)
    {
        $this->payments = Payment::where('customer_id', $customer->id)
            ->get();

        $this->emit('showModalpayments');
    }
}

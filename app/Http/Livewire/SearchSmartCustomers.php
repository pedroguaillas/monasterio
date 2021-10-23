<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class SearchSmartCustomers extends Component
{
    public $search, $customer, $payment, $paymentmethods;
    public $amount;
    public $date_next_month;

    protected $rules = [
        'payment.date' => 'required',
        'payment.amount' => 'required',
    ];

    public function mount()
    {
        $this->paymentmethods = PaymentMethod::all();
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +1 month'));
    }

    public function updatingAmount($value)
    {
        $pay = PaymentMethod::find($value);

        $this->payment->amount = $pay->amount;
        $this->date_next_month = date('d/m/Y', strtotime($this->payment->date . " +$pay->months month"));
    }

    public function updatingMonth($value)
    {
        $this->payment->amount = 20 * $value;
    }

    public function updatingPaymentDate($value)
    {
        $this->date_next_month = date('d/m/Y', strtotime($value . ' +1 month'));
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

        return view('livewire.search-smart-customers', compact('customers'));
    }

    public function storePayment()
    {
        $auth = Auth::user();

        $payment = $this->customer->payments()->create([
            'branch_id' => 1,
            'user_id' => $auth->id,
            'date' => $this->payment->date,
            'amount' => $this->payment->amount,
        ]);

        if ($payment) {
            $this->emit('closeModal');
        }
    }

    public function edit(Customer $customer)
    {
        $this->customer = $customer;

        $this->payment = new Payment;
        $this->payment->date = date('Y-m-d');
        $this->payment->amount = 20;
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +1 month'));

        $this->emit('showModal');
    }
}

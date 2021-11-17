<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchSmartCustomers extends Component
{
    public $search, $customer, $payment, $service;
    public $date_next_month;
    public $amount;

    // payments
    public $payments;

    protected $rules = [
        'payment.service_id' => 'required',
        'payment.date' => 'required',
        'payment.amount' => 'required',
    ];

    public function mount()
    {
        $this->payment = null;
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +1 month'));
    }

    public function updatingPaymentServiceId($value)
    {
        $this->service = PaymentMethod::find($value);
        $this->payment->amount = $this->service->amount;
        $this->date_next_month = date('d/m/Y', strtotime($this->payment->date . " +" . $this->service->months . " month"));
    }

    public function updatingPaymentDate($value)
    {
        $this->date_next_month = date('d/m/Y', strtotime($value . ' +' . $this->service->months . ' month'));
    }

    public function updatingAmount($value)
    {
        $this->service = PaymentMethod::find($value);

        $this->payment->amount = $this->service->amount;
        $this->date_next_month = date('d/m/Y', strtotime($this->payment->date . ' +' . $this->service->months . ' month'));
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

    public function createPayment(Customer $customer)
    {
        $this->customer = $customer;
        $this->service = PaymentMethod::first();

        $this->payment = new Payment;
        $this->payment->date = date('Y-m-d');
        $this->payment->amount = $this->service->amount;
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +' . $this->service->months . ' month'));

        $this->emit('showModal');
    }

    public function storePayment()
    {
        $payment = $this->customer->payments()->create([
            'branch_id' => 1,
            'to_pay' => $this->service->amount,
            'type' => $this->service->description,
            'start_period' => $this->payment->date,
            'end_period' => date('Y-m-d', strtotime($this->payment->date . ' +' . $this->service->months . ' month')),
        ]);

        $paymentItem = $payment->paymentitems()->create([
            'branch_id' => 1,
            'amount' => $this->payment->amount
        ]);

        if ($paymentItem) {
            $this->emit('closeModal');
        }
    }

    public function listPayments(Customer $customer)
    {
        $this->payments = DB::table('payments')->select(DB::raw('sum(amount) as amount, payments.id, type, start_period, end_period, to_pay'))
            ->where('customer_id', $customer->id)
            ->join('payment_items AS pi', 'pi.payment_id', 'payments.id')
            ->groupBy('id', 'type', 'start_period', 'end_period', 'to_pay')
            ->get();

        $this->emit('showModalpayments');
    }

    public function complete(Payment $payment)
    {
        $item = $payment->paymentitems()->first();

        $paymentItem = $payment->paymentitems()->create([
            'branch_id' => 1,
            'amount' => $payment->to_pay - $item->amount
        ]);
    }
}

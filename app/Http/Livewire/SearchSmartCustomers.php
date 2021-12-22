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
            // $customers = Customer::where('identification', 'like', '%' . $this->search . '%')
            //     ->orWhere('first_name', 'like', '%' . $this->search . '%')
            //     ->orWhere('last_name', 'like', '%' . $this->search . '%')
            //     ->paginate(5);

            // tener en cuenta que aqui se pasa el id del cliente
            // $customers = DB::table('customers')->select(DB::raw('sum(amount) as amount, customers.id, identification, first_name, last_name, sum(to_pay) as to_pay'))
            //     ->leftJoin('payments AS p', 'customer_id', 'customers.id')
            //     ->leftJoin('payment_items AS pi', 'payment_id', 'p.id')
            //     ->groupBy('id', 'identification', 'first_name', 'last_name')
            //     ->where('identification', 'like', '%' . $this->search . '%')
            //     ->orWhere('first_name', 'like', '%' . $this->search . '%')
            //     ->orWhere('last_name', 'like', '%' . $this->search . '%')
            //     ->paginate(5);
            
            $customers = DB::select("select (SELECT SUM(to_pay) FROM `payments` WHERE `customer_id` = c.id) as to_pay, (SELECT SUM(amount) FROM `payments` AS p INNER JOIN payment_items AS pi ON p.id=pi.payment_id WHERE `customer_id` = c.id) as amount, id, identification, first_name, last_name from `customers` AS c where `identification` like '%$this->search%' or `first_name` like '%$this->search%' or `last_name` like '%p$this->search%'");
            
            // $customers = DB::select("select (SELECT SUM(to_pay) FROM `payments` WHERE `customer_id` = c.id) as to_pay, (SELECT SUM(amount) FROM `payments` AS p INNER JOIN payment_items AS pi ON p.id=pi.payment_id WHERE `customer_id` = c.id) as amount, id, identification, first_name, last_name from `customers` AS c where `identification` like '%p%' or `first_name` like '%p%' or `last_name` like '%p%'");
            $customers = json_decode(json_encode($customers), false);
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
            'start_period' => $this->payment->date,
            'end_period' => date('Y-m-d', strtotime($this->payment->date . ' +' . $this->service->months . ' month')),
        ]);

        $paymentItem = $payment->paymentitems()->create([
            'branch_id' => 1,
            'description' => $this->service->description,
            'amount' => $this->payment->amount
        ]);

        if ($paymentItem) {
            $this->emit('closeModal');
        }
    }

    public function listPayments(Customer $customer)
    {
        $this->payments = Payment::select('amount', 'description', 'start_period', 'end_period', 'to_pay')
            ->join('payment_items AS pi', 'pi.payment_id', 'payments.id')
            ->where('payments.customer_id', $customer->id)
            ->get();

        // $this->payments = DB::table('payments1')->select(DB::raw('sum(amount) as amount, payments.id, description, start_period, end_period, to_pay'))
        //     ->where('customer_id', $customer->id)
        //     ->join('payment_items AS pi', 'pi.payment_id', 'payments.id')
        //     ->groupBy('id', 'description', 'start_period', 'end_period', 'to_pay')
        //     ->get();

        $this->emit('showModalpayments');
    }

    public function complete(Customer $customer)
    {
        // no se completa al primer pago
        // se completa al pago que falta
        // 1. identificar el pago que falta

        $paymentsByCustom = DB::table('payments')->select(DB::raw('sum(to_pay1) - sum(amount) AS diff, payments.id'))
            ->leftJoin('payment_items', 'payment_id', 'payments.id')
            ->groupBy('id')
            ->where('customer_id', $customer->id)
            ->havingRaw('diff > 0')
            ->first();

        $payment = Payment::find($paymentsByCustom->id);

        // ajustar el pago
        $paymentItem = $payment->paymentitems()->create([
            'branch_id' => 1,
            'description' => 'Ajuste ' . $payment->paymentitems()->first()->description,
            'amount' => $paymentsByCustom->diff
        ]);


        $this->render();
    }
}

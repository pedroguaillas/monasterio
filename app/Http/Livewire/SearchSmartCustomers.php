<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Customer;
use Livewire\Component;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchSmartCustomers extends Component
{
    public $search, $customer, $payment, $service, $branch;
    public $date_next_month;
    public $amount;

    // payments
    public $payments;

    protected $rules = [
        'payment.branch_id' => 'required',
        'payment.service_id' => 'required',
        'payment.date' => 'required',
        'payment.amount' => 'required',
    ];

    public function mount()
    {
        $this->payment = null;
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +1 month'));

        $auth = Auth::user();
        if ($auth->hasRole('Jefe')) {
            $this->branch = Branch::first();
        } else {
            $this->branch = Branch::find($auth->branch_id);
        }
    }

    public function updatingPaymentBranchId($value)
    {
        $this->branch = Branch::find($value);
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

            // tener en cuenta que aqui se pasa el id del cliente
            // $customers = DB::table('customers')->select(DB::raw('sum(amount) as amount, customers.id, identification, first_name, last_name, sum(to_pay) as to_pay'))
            //     ->leftJoin('payments AS p', 'customer_id', 'customers.id')
            //     ->leftJoin('payment_items AS pi', 'payment_id', 'p.id')
            //     ->groupBy('id', 'identification', 'first_name', 'last_name')
            //     ->where('identification', 'like', '%' . $this->search . '%')
            //     ->orWhere('first_name', 'like', '%' . $this->search . '%')
            //     ->orWhere('last_name', 'like', '%' . $this->search . '%')
            //     ->paginate(5);

            $customers = DB::select("select (SELECT SUM(to_pay) FROM `payments` WHERE `customer_id` = c.id) as to_pay, (SELECT SUM(amount) FROM `payments` AS p INNER JOIN payment_items AS pi ON p.id=pi.payment_id WHERE `customer_id` = c.id) as amount, id, identification, first_name, last_name from `customers` AS c where `identification` like '%$this->search%' or `first_name` like '%$this->search%' or `last_name` like '%$this->search%' LIMIT 10");

            $customers = json_decode(json_encode($customers), false);
        }

        $paymentmethods = PaymentMethod::all();
        $branchs = Branch::all();

        return view('livewire.search-smart-customers', compact('customers', 'paymentmethods', 'branchs'));
    }

    public function createPayment(Customer $customer)
    {
        $this->customer = $customer;
        $this->service = PaymentMethod::first();

        $auth = Auth::user();

        if ($auth->hasRole('Jefe')) {
            $this->branch = Branch::first();
        } else {
            $this->branch = Branch::find($auth->branch_id);
        }

        $this->payment = new Payment;
        $this->payment->date = date('Y-m-d');
        $this->payment->amount = $this->service->amount;
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +' . $this->service->months . ' month'));

        $this->emit('showModal');
    }

    //Registro de nuevo pago
    public function storePayment()
    {
        $payment = $this->customer->payments()->create([
            'branch_id' => $this->branch->id,
            'to_pay' => $this->service->amount,
            'start_period' => $this->payment->date,
            'end_period' => date('Y-m-d', strtotime($this->payment->date . ' +' . $this->service->months . ' month')),
        ]);

        $paymentItem = $payment->paymentitems()->create([
            'branch_id' => $this->branch->id,
            'description' => $this->service->description,
            'amount' => $this->payment->amount
        ]);

        if ($paymentItem) {
            $this->emit('closeModal');
        }
    }

    public function listPayments(Customer $customer)
    {
        $this->payments = Payment::select(DB::raw("amount, description, DATE_FORMAT(start_period, '%d-%m-%Y') AS start_period, DATE_FORMAT(end_period, '%d-%m-%Y') AS end_period, to_pay"))
            ->join('payment_items', 'payment_id', 'payments.id')
            ->where('payments.customer_id', $customer->id)
            ->get();

        $this->emit('showModalpayments');
    }

    //Registro de saldo de pago
    public function complete(Customer $customer)
    {
        // no se completa al primer pago
        // se completa al pago que falta

        // 1. Identificar el pago que falta
        $paymentsByCustom = DB::select("SELECT id, (to_pay - (SELECT SUM(amount) FROM payment_items WHERE p.id = payment_id)) as diff FROM payments AS p WHERE p.customer_id = $customer->id HAVING diff > 0");
        $paymentsByCustom = $paymentsByCustom[0];
        $payment = Payment::find($paymentsByCustom->id);

        // 2. Ajustar el pago
        $paymentItem = $payment->paymentitems()->create([
            // EL branch_id SE CAPTURARA DE MANERA AUTOMÁTICA
            'branch_id' => $this->branch->id,
            'description' => 'Ajuste ' . $payment->paymentitems()->first()->description,
            'amount' => $paymentsByCustom->diff
        ]);

        $this->render();
    }

    // Mostrar modal para completar el pago
    function showComplete(Customer $customer)
    {
        $this->customer = $customer;
        $this->service = PaymentMethod::first();

        $this->payment = new Payment;

        $auth = Auth::user();

        if ($auth->hasRole('Jefe')) {
            $this->payment->branch_id = Branch::first()->id;
        } else {
            $this->payment->branch_id = Branch::find($auth->branch_id)->id;
        }

        $this->emit('showModalComplete');
    }

    //Registro de saldo de pago
    public function complete1()
    {
        // no se completa al primer pago
        // se completa al pago que falta

        $customer_id = $this->customer->id;

        // 1. Identificar el pago que falta
        $paymentsByCustom = DB::select("SELECT id, (to_pay - (SELECT SUM(amount) FROM payment_items WHERE p.id = payment_id)) as diff FROM payments AS p WHERE p.customer_id = $customer_id HAVING diff > 0");
        $paymentsByCustom = $paymentsByCustom[0];
        $payment = Payment::find($paymentsByCustom->id);

        // 2. Ajustar el pago
        $paymentItem = $payment->paymentitems()->create([
            // POR EL branch_id SE CREA ESTE NUEVO METODO
            'branch_id' => $this->branch->id,
            'description' => 'Ajuste ' . $payment->paymentitems()->first()->description,
            'amount' => $paymentsByCustom->diff
        ]);

        $this->render();

        $this->emit('hideModalComplete');
    }
}

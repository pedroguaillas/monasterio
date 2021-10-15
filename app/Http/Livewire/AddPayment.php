<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddPayment extends Component
{
    public $customer;
    public $date;
    public $amount;
    public $month;
    public $date_next_month;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $this->date = date('Y-m-d');
        $this->amount = 20;
        $this->month = 1;
        $this->date_next_month = date('d/m/Y', strtotime(date('Y-m-d') . ' +1 month'));
    }

    public function store()
    {
        $auth = Auth::user();
        $payment = $this->customer->payments()->create([
            'branch_id' => 1,
            'user_id' => $auth->id,
            'date' => $this->date,
            'amount' => $this->amount
        ]);
    }

    public function render()
    {
        return view('livewire.add-payment');
    }
}

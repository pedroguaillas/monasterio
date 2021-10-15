<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;

class AddPayment extends Component
{
    public $customer;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function render()
    {
        return view('livewire.add-payment');
    }
}

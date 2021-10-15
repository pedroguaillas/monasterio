<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;

class SearchSmartCustomers extends Component
{
    public $search;

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
}

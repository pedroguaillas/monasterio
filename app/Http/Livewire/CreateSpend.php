<?php

namespace App\Http\Livewire;

use App\Models\Spend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateSpend extends Component
{
    public $description, $amount;

    protected $rules=[
        'description'=>'required',
        'amount'=>'required',
    ];

    public function mount()
    {
        $this->description='pago';
        $this->amount=5;
    }

    public function render()
    {
        return view('livewire.create-spend');
    }

    public function store()
    {
        $date=Carbon::now();
        $spend = Spend::create([
            'branch_id' => 1,
            'description' => $this->description,
            'amount' => $this->amount,
            'date' => $date->format('Y-m-d')
        ]);

        if ($spend) {
            $this->emit('render');
            $this->emit('closeModal');
        }
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Closure;
use App\Models\Payment;
use App\Models\Spend;
use Carbon\Carbon;
use Livewire\Component;

class DiaryBook extends Component
{

    public $sum_entry;
    public $sum_egress;

    protected $listeners = ['render' => 'render'];

    public function mount()
    {
        $this->sum_entry = 0;
        $this->sum_egress = 0;
    }

    public function render()
    {
        $date = Carbon::now();

        // pilas aqui estan los ingresos
        $payments = Payment::select('c.first_name', 'c.last_name', 'payments.amount')
            ->join('customers AS c', 'c.id', 'payments.customer_id')
            ->where('date', $date->format('Y-m-d'))
            ->get();

        // estos son los gastos
        $spends = Spend::where('date', $date->format('Y-m-d'))
            ->get();

        $this->sum_entry = 0;
        $this->sum_egress = 0;

        foreach ($payments as $item) {
            $this->sum_entry += $item->amount;
        }

        foreach ($spends as $item) {
            $this->sum_egress += $item->amount;
        }

        return view('livewire.diary-book', compact('payments', 'spends'));
    }

    public function store()
    {
        // cada dia toca hacer el cierre de caja de la empresa
        // entonces eso voy hacer aqui
        // para entonces toca guardar los ingresos y egresos en una tabla
        // primero le voy a reestructurar la tabla

        $date = Carbon::now();
        $closing = Closure::create([
            'branch_id' => 1,
            'type' => 'diario',
            'date' => $date->format('Y-m-d'),
            'description' => 'Cierre ' . $date->format('Y-m-d'),
            'debit' => $this->sum_entry,
            'have' => $this->sum_egress,
            'amount' => $this->sum_entry - $this->sum_egress,
        ]);
    }
}

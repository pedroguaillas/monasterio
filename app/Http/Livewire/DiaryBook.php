<?php

namespace App\Http\Livewire;

use App\Models\Closure;
use App\Models\Customer;
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
        // Ingresos

        // Nota no se agrupa el monto de los items de pago,
        // por que los items de pago se hacen en diferentes fechas
        // y en el libro diario solo se debe mostrar de la fecha actual

        $payments = Customer::select('amount', 'type', 'first_name', 'last_name')
            ->join('payments AS p', 'p.customer_id', 'customers.id')
            ->join('payment_items AS pi', 'pi.payment_id', 'p.id')
            ->whereDate('pi.created_at', Carbon::today())->get();

        // Egresos
        $spends = Spend::whereDate('date', Carbon::today())
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
            // 'description' => 'Cierre ' . $date->format('Y-m-d'),
            'entry' => $this->sum_entry,
            'egress' => $this->sum_egress,
        ]);
    }
}

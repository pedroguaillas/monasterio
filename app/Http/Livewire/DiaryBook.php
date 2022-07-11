<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Diary;
use App\Models\Spend;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiaryBook extends Component
{
    public $sum_entry;
    public $sum_egress;
    public $types = [];
    public $date;

    protected $listeners = ['render' => 'render'];

    public function mount()
    {
        $this->sum_entry = 0;
        $this->sum_egress = 0;

        $auth = Auth::user();
        if ($auth->hasRole('Jefe')) {
            $this->types = ['1', '2'];
        } else {
            $this->types = [$auth->branch_id];
        }

        $this->date = substr(Carbon::today()->toISOString(), 0, 10);
    }

    public function render()
    {
        // Ingresos

        // Nota no se agrupa el monto de los items de pago,
        // por que los items de pago se hacen en diferentes fechas
        // y en el libro diario solo se debe mostrar de una fecha especifica

        $payments = Customer::select('amount', 'description', 'first_name', 'last_name')
            ->join('payments', 'customer_id', 'customers.id')
            ->join('payment_items AS pi', 'payment_id', 'payments.id')
            ->whereIn('pi.branch_id', $this->types)
            ->whereDate('pi.created_at', $this->date)->get();

        // Diarios
        $diary = Diary::select(DB::raw('SUM(amount) AS amount'))
            ->whereDate('date', $this->date)
            ->whereIn('branch_id', $this->types)
            ->first();

        // Egresos
        $spends = Spend::whereDate('date', $this->date)
            ->whereIn('branch_id', $this->types)
            ->get();

        $this->sum_entry = 0;
        $this->sum_egress = 0;

        foreach ($payments as $item) {
            $this->sum_entry += $item->amount;
        }

        $this->sum_entry += $diary->amount ?: 0;

        foreach ($spends as $item) {
            $this->sum_egress += $item->amount;
        }

        return view('livewire.diary-book', compact('payments', 'spends', 'diary'));
    }
}

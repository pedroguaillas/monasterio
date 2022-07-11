<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\ConstDiary;
use App\Models\Diary;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DiaryRegister extends Component
{
    public $branch_id;
    public $types = [];
    public $date;
    public $total;
    public $amount;

    public function mount()
    {
        $auth = Auth::user();

        if ($auth->hasRole('Jefe')) {
            $this->branch_id = Branch::first()->id;
            $this->types = ['1', '2'];
        } else {
            $this->branch_id = Branch::find($auth->branch_id)->id;
            $this->types = [$auth->branch_id];
        }

        $this->date = substr(Carbon::today()->toISOString(), 0, 10);
        $this->amount = ConstDiary::first()->amount;

        $diary = Diary::select(DB::raw('SUM(amount) AS amount'))
            ->whereDate('date', $this->date)
            ->whereIn('branch_id', $this->types)->first();

        $this->total = $diary->amount ?: 0;
    }

    public function render()
    {
        $branchs = Branch::all();
        return view('livewire.diary-register', compact('branchs'));
    }

    public function register()
    {
        $diary = Diary::where('branch_id', $this->branch_id)
            ->whereDate('date', $this->date)
            ->get();

        if (count($diary)) {
            $diary = $diary->first();
            $diary->update(['amount' => $this->amount + $diary->amount]);
        } else {
            Diary::create([
                'branch_id' => $this->branch_id,
                'date' => $this->date,
                'amount' => $this->amount
            ]);
        }

        $this->total += $this->amount;
    }

    //Registro de saldo de pago
    public function registerModal()
    {
        $this->register();

        $this->emit('hideModal');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Diary;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DiaryRegister extends Component
{
    public $branch_id;
    public $date;
    public $amount;
    public $total = 0;

    public function mount()
    {
        $auth = Auth::user();
        if ($auth->hasRole('Jefe')) {
            $this->branch_id = Branch::first()->id;
        } else {
            $this->branch_id = Branch::find($auth->branch_id)->id;
        }

        $this->date = Carbon::now()->toDateString();
        $this->amount = 2;
        $diary = Diary::where(
            ['branch_id' => $this->branch_id, 'date' => $this->date]
        )->get();

        if (count($diary)) {
            $diary = $diary->first();
            $this->total = $diary->amount;
        }
    }

    public function render()
    {
        $branchs = Branch::all();
        return view('livewire.diary-register', compact('branchs'));
    }

    public function register()
    {
        $this->total += $this->amount;

        Diary::updateOrCreate(
            ['branch_id' => $this->branch_id, 'date' => $this->date],
            ['amount' => $this->total]
        );
    }

    // Mostrar modal para completar el pago
    function showComplete()
    {
        $this->emit('showModalComplete');
    }

    //Registro de saldo de pago
    public function complete1()
    {
        $this->register();

        $this->emit('hideModalComplete');
    }
}

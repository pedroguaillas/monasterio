<?php

namespace App\Http\Livewire;

use App\Models\Spend;
use Carbon\Carbon;
use Livewire\Component;

class CreateSpend extends Component
{
    // estos son los atributos del componente
    public $description, $amount;

    // las reglas para que se visualice en el blade
    protected $rules = [
        'description' => 'required',
        'amount' => 'required',
    ];

    // esto es mas o menos como el constructor del componente
    public function mount()
    {
        // si ves esto es como que inicia las variables
        $this->description = '';
        $this->amount = 0;
    }

    // cada componente debe renderizar su vista
    public function render()
    {
        return view('livewire.create-spend');
    }

    public function store()
    {
        $date = Carbon::now();
        $spend = Spend::create([
            'branch_id' => 1,
            'description' => $this->description,
            'amount' => $this->amount,
            'date' => $date->format('Y-m-d')
        ]);

        $this->reset(['description', 'amount']);

        // si se guarda correctamente
        if ($spend) {
            // decimos a su componente padre que actualice su lista en este caso al metodo render
            $this->emit('render');
            // decimos al livewire que cierre el modal
            $this->emit('closeModal');
        }
    }
}

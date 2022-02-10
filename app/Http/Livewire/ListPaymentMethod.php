<?php

namespace App\Http\Livewire;

use App\Models\PaymentMethod;
use Livewire\Component;

class ListPaymentMethod extends Component
{
    public $description, $amount, $months, $pay_id;

    protected $rules = [
        'description' => 'required',
        'amount' => 'required',
        'months' => 'required',
    ];

    public function render()
    {
        $paymentmethods = PaymentMethod::all();
        return view('livewire.list-payment-method', compact('paymentmethods'));
    }

    public function create()
    {
        if ($this->pay_id !== null) {
            $this->reset(['description', 'amount', 'months']);
            $this->pay_id = null;
        }

        $this->emit("showModal");
    }

    // Aqui este metodo cuando le pansan un id el
    // automaticamente le puede convertir en un modelo
    public function editar(PaymentMethod $paymentMethod)
    {
        $this->pay_id = $paymentMethod->id;
        $this->description = $paymentMethod->description;
        $this->amount = $paymentMethod->amount;
        $this->months = $paymentMethod->months;

        // Aqui solo falta emitir un evento a Livewire para que abra el modal
        $this->emit("showModal");
    }

    public function update()
    {
        $pay = null;
        if ($this->pay_id == null) {
            $pay = new PaymentMethod;
        } else {
            $pay = PaymentMethod::find($this->pay_id);
        }
        $pay->description = $this->description;
        $pay->amount = $this->amount;
        $pay->months = $this->months;
        $pay->save();

        $this->reset(['description', 'amount', 'months']);

        // Una vez guardado le renderizamos la lista de registro y cerramos el modal
        $this->render();
        $this->emit("closeModal");
    }
}

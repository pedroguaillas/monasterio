<?php

namespace App\Http\Livewire;

use App\Models\PaymentMethod;
use Livewire\Component;

class ListPaymentMethod extends Component
{
    // Simon este es una variable que se comunica con la vista ok
    public $paymentMethod = null, $pay_id = null;

    protected $rules = [
        'paymentMethod.description' => 'required',
        'paymentMethod.amount' => 'required',
        'paymentMethod.months' => 'required',
    ];

    public function render()
    {
        $paymentmethods = PaymentMethod::all();
        return view('livewire.list-payment-method', compact('paymentmethods'));
    }

    public function create()
    {
        $this->pay_id = null;

        if ($this->paymentMethod) {
            $this->paymentMethod->reset();
        }

        $this->emit("showModal");
    }

    // Aqui este metodo cuando le pansan un id el
    // automaticamente le puede convertir en un modelo
    public function editar(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        // Aqui solo falta emitir un evento a Livewire para que abra el modal
        $this->emit("showModal");
    }

    public function update()
    {
        $this->paymentMethod->save();
        // Una vez guardado le cerramos el modal
        $this->emit("closeModal");
    }
}

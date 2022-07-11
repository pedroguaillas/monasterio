<?php

namespace App\Http\Livewire;

use App\Models\ConstDiary;
use Livewire\Component;

class UpdateDiary extends Component
{
    public $amount;

    public function mount()
    {
        $this->amount = ConstDiary::first()->amount;
    }

    public function render()
    {
        return view('livewire.update-diary');
    }

    public function save()
    {
        $const = ConstDiary::first();
        $const->update(['amount' => $this->amount]);
    }
}

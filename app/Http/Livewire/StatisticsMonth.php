<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StatisticsMonth extends Component
{
    public $date = 0, $entry = 0, $egress = 0;

    public function mount($closure)
    {
        $this->date = $closure->date;
        $this->entry = $closure->entry;
        $this->egress = $closure->egress;
    }

    public function render()
    {
        $closuresmoth = null;

        if ($this->year !== null) {
            $closuresmoth = DB::select('SELECT SUM(entry) AS entry, SUM(egress) AS egress, MONTH(date) AS date FROM `closures` GROUP BY MONTH(date)');
            $closuresmoth = json_decode(json_encode($closuresmoth, true));
        }

        return view('livewire.statistics-month', compact('closuresmoth'));
    }
}

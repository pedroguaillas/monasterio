<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StatisticsMonth extends Component
{
    public $year;

    public function mount()
    {
        $this->year = null;
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

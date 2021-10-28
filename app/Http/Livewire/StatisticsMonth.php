<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StatisticsMonth extends Component
{
    public $date, $entry, $egress;
    public $active = false;

    public function mount($date, $entry, $egress)
    {
        $this->date = $date;
        $this->entry = $entry;
        $this->egress = $egress;
    }

    public function collapseddddd($si)
    {
        $this->active = !$this->active;
    }

    public function render()
    {
        $closuresmoth = null;

        if ($this->active) {
            $closuresmoth = DB::select("SELECT SUM(entry) AS entry, SUM(egress) AS egress, MONTH(date) AS month FROM closures GROUP BY MONTH(date) WHERE YEAR(date) = $this->year");
            $closuresmoth = json_decode(json_encode($closuresmoth, true));
        }

        return view('livewire.statistics-month', ['closuresmoth' => $closuresmoth]);
    }
}

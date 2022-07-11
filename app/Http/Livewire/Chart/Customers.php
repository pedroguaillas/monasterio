<?php

namespace App\Http\Livewire\Chart;

use App\Models\Customer;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Component;

class Customers extends Component
{
    public $genders = ['masculino', 'femenino'];
    public $branches = ['Zeus', 'Monasterio'];
    public $types = ['1', '2'];
    public $gender_colors = [
        'masculino' => '#ffc107',
        'femenino' => '#17a2b8',
    ];

    public $firstRun;

    protected $listeners = [
        'onSliceClick' => 'handleOnSliceClick'
    ];

    public function mount()
    {
        $this->firstRun = true;
    }

    public function handleOnSliceClick($column)
    {
        dd($column);
    }

    public function render()
    {
        $customers = Customer::whereIn('branch_id', $this->types)
            ->get();

        $columnChartModelCustomers = $customers->groupBy('gender')
            ->reduce(
                function (PieChartModel $pieChartModel, $data) {
                    $gender = $data->first()->gender;
                    $value = $data->count();
                    return $pieChartModel->addSlice(ucfirst($gender), $value, $this->gender_colors[$gender]);
                },
                (new PieChartModel())
                    // ->setTitle('Usuarios')
                    ->setOpacity(.9)
                    ->setAnimated($this->firstRun)
                    ->withOnSliceClickEvent('onSliceClick')
            );

        return view('livewire.chart.customers', [
            'columnChartModelCustomers' => $columnChartModelCustomers
        ])
            ->layout('layouts.adminlte')
            ->layoutData(['title' => 'Gráfico de Clientes']);
    }
}

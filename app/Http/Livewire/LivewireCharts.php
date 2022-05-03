<?php

namespace App\Http\Livewire;

use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\PaymentItem;
use DateTime;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LivewireCharts extends Component
{
    public $genders = ['masculino', 'femenino'];
    public $branches = ['Zeus', 'Monasterio'];
    public $types = ['1', '2'];
    public $gender_colors = [
        'masculino' => '#ffc107',
        'femenino' => '#17a2b8',
    ];
    public $branch_colors = [
        'Zeus' => '#28a745',
        'Monasterio' => '#dc3545',
    ];
    public $firstRun = true;

    protected $listeners = [
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
        'onColumnClick2' => 'handleOnColumnClick2',
    ];

    public function handleOnSliceClick($column)
    {
        dd($column);
    }

    public function handleOnColumnClick($column)
    {
        dd($column);
    }

    public function handleOnColumnClick2($column)
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

        $payments = PaymentItem::select(DB::raw('SUM(amount) AS amount'), 'name')
            ->join('branches', 'branch_id', 'branches.id')
            ->groupBy('name')
            ->get();

        $columnChartModelGenere = $payments->groupBy('name')
            ->reduce(
                function (ColumnChartModel $columnChartModel, $data) {
                    $name = $data->first()->name;
                    $value = $data->first()->amount;
                    return $columnChartModel->addColumn(ucfirst($name), $value, $this->branch_colors[$name]);
                },
                (new ColumnChartModel())
                    // ->setTitle('Genero')
                    ->setOpacity(.9)
                    ->setAnimated($this->firstRun)
                    ->withOnColumnClickEventName('onColumnClick')
            );

        $ages = [];
        $now = new DateTime();

        foreach ($customers as $customer) {
            $start = new DateTime($customer->date_of_birth);
            $interval = $start->diff($now);
            $ages[] = $interval->format('%y');
        }

        $collection = collect($ages);
        $collection = $collection->sort();
        $collection = $collection->countBy();

        $columnChartModelDates = $collection
            ->reduce(
                function (ColumnChartModel $columnChartModel, $key, $value) {
                    return $columnChartModel->addColumn($value, $key, '#17a2b8');
                },
                (new ColumnChartModel())
                    // ->setTitle('Genero')
                    ->setOpacity(.9)
                    ->setAnimated($this->firstRun)
                    ->withOnColumnClickEventName('onColumnClick2')
            );

        return view('livewire.livewire-charts')
            ->with([
                'columnChartModelCustomers' => $columnChartModelCustomers,
                'columnChartModelGenere' => $columnChartModelGenere,
                'columnChartModelDates' => $columnChartModelDates,
            ]);
    }
}

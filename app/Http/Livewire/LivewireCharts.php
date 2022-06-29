<?php

namespace App\Http\Livewire;

use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\PaymentItem;
use App\Models\Spend;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
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
    public $date_start;
    public $date_end;

    protected $listeners = [
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
        'onColumnClick2' => 'handleOnColumnClick2',
    ];

    public function mount()
    {
        $date = substr(Carbon::today()->toISOString(), 0, 10);
        $this->date_start = $date;
        $this->date_end = $date;
    }

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

        // Reporte por rango de fecha
        $entries = PaymentItem::select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') AS date, SUM(amount) AS amount"))
            ->where([
                ["created_at", ">=", $this->date_start],
                ["created_at", "<", date('Y-m-d', strtotime($this->date_end . ' +1 day'))]
            ])
            ->whereIn('branch_id', $this->types)
            ->groupBy("date")->get();

        // $egress = Spend::select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') AS date, SUM(amount) AS amount"))
        //     ->where([
        //         ["created_at", ">=", $this->date_start],
        //         ["created_at", "<", date('Y-m-d', strtotime($this->date_end . ' +1 day'))]
        //     ])
        //     ->groupBy("date")->get();

        // $interval = DateInterval::createFromDateString('1 day');
        // $period = new DatePeriod(date_create($this->date_start), $interval, date_create(date('Y-m-d', strtotime($this->date_end . ' +1 day'))));

        // $closures = [];

        // foreach ($period as $dt) {
        //     $newdt = $dt->format("d-m-Y");
        //     $entry = count($entries) > 0 ? $this->findObjectByDate($newdt, $entries) : false;
        //     $egre = count($egress) > 0 ? $this->findObjectByDate($newdt, $egress) : false;
        //     var_dump($newdt);
        //     if ($entry !== false || $egre !== false) {
        //         array_push($closures, [
        //             'date' =>  $newdt,
        //             'entry' => $entry !== false ? $entry['amount'] : 0,
        //             'egress' =>  $egre !== false ? $egre['amount'] : 0
        //         ]);
        //     }
        // }

        return view('livewire.livewire-charts')
            ->with([
                'columnChartModelCustomers' => $columnChartModelCustomers,
                'columnChartModelGenere' => $columnChartModelGenere,
                'columnChartModelDates' => $columnChartModelDates,
                'closures' => $entries,
            ]);
    }

    function findObjectByDate($date, $array)
    {
        foreach ($array as $element) {
            if ($date == $element->date) {
                return $element;
            }
        }

        return false;
    }
}

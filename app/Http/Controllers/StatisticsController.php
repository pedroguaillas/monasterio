<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PaymentItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;

class StatisticsController extends Controller
{
    public function index()
    {
        $payment_items = DB::table('payment_items')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') AS year, SUM(amount) amount"))
            ->groupBy('year')
            ->get();


        $diaries = DB::table('diaries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') AS year, SUM(amount) amount"))
            ->groupBy('year')
            ->get();

        $spends = DB::table('spends')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') AS year, SUM(amount) amount"))
            ->groupBy('year')
            ->get();

        // hacer un for desde el dia uno hasta el dia ultimo del mes
        $closures = [];
        for ($year = 2021; $year <= (int)date('Y'); $year++) {
            // Recorrer cada dia y buscar si existe un objeto en ese dia o sino poner 0
            $payment_item = $this->searchByYear($year, $payment_items);
            $diary = $this->searchByYear($year, $diaries);
            $spend = $this->searchByYear($year, $spends);

            if ($payment_item || $diary || $spend) {
                $closures[] = [
                    "year" => $year,
                    "entry" => $payment_item + $diary,
                    "egress" => $spend,
                ];
            }
        }

        $closures = json_decode(json_encode($closures, true));

        return view('statistics.index', compact('closures'));
    }

    function searchByYear(string $year, $array)
    {
        foreach ($array as $element) {
            if ($year === $element->year) {
                return $element->amount;
            }
        }

        return 0;
    }

    // PDF General
    public function general()
    {
        $payment_items = DB::table('payment_items')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') AS year, SUM(amount) amount"))
            ->groupBy('year')
            ->get();


        $diaries = DB::table('diaries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') AS year, SUM(amount) amount"))
            ->groupBy('year')
            ->get();

        $spends = DB::table('spends')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y') AS year, SUM(amount) amount"))
            ->groupBy('year')
            ->get();

        // hacer un for desde el dia uno hasta el dia ultimo del mes
        $closures = [];
        for ($year = 2021; $year <= (int)date('Y'); $year++) {
            // Recorrer cada dia y buscar si existe un objeto en ese dia o sino poner 0
            $payment_item = $this->searchByYear($year, $payment_items);
            $diary = $this->searchByYear($year, $diaries);
            $spend = $this->searchByYear($year, $spends);

            if ($payment_item || $diary || $spend) {
                $closures[] = [
                    "year" => $year,
                    "entry" => $payment_item + $diary,
                    "egress" => $spend,
                ];
            }
        }

        $closures = json_decode(json_encode($closures, true));

        $pdf = PDF::loadView('statistics.years-report', compact('closures'));

        return $pdf->stream('statistics.years-report.pdf');
    }

    // Pantalla incial reporte por meses
    public function byMonth(string $year)
    {
        $payment_items = DB::table('payment_items')
            ->select(DB::raw("DATE_FORMAT(created_at, '%m') AS month, SUM(amount) amount"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();

        $diaries = DB::table('diaries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%m') AS month, SUM(amount) amount"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();


        $spends = DB::table('spends')
            ->select(DB::raw("DATE_FORMAT(created_at, '%m') AS month, SUM(amount) amount"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();

        // hacer un for desde el dia uno hasta el dia ultimo del mes

        $last_month = 12;
        if ($year === date('Y')) {
            $last_month = (int)date('m');
        }

        $closuresmoth = [];
        for ($month = 1; $month <= $last_month; $month++) {
            // Recorrer cada dia y buscar si existe un objeto en ese dia o sino poner 0
            $payment_item = $this->searchByMonth($month, $payment_items);
            $diary = $this->searchByMonth($month, $diaries);
            $spend = $this->searchByMonth($month, $spends);

            if ($payment_item || $diary || $spend) {
                $closuresmoth[] = [
                    "month" => $month,
                    "entry" => $payment_item + $diary,
                    "egress" => $spend,
                ];
            }
        }

        $closuresmoth = json_decode(json_encode($closuresmoth, true));

        return response()->json(['closuresmoth' => $closuresmoth]);
    }

    function searchByMonth(string $month, $array)
    {
        foreach ($array as $element) {
            if ($month == $element->month) {
                return $element->amount;
            }
        }

        return 0;
    }

    // PDF reporte por meses
    public function months(string $year)
    {
        $payment_items = DB::table('payment_items')
            ->select(DB::raw("DATE_FORMAT(created_at, '%m') AS month, SUM(amount) amount"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();

        $diaries = DB::table('diaries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%m') AS month, SUM(amount) amount"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();


        $spends = DB::table('spends')
            ->select(DB::raw("DATE_FORMAT(created_at, '%m') AS month, SUM(amount) amount"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();

        // hacer un for desde el dia uno hasta el dia ultimo del mes

        $last_month = 12;
        if ($year === date('Y')) {
            $last_month = (int)date('m');
        }

        $closuresmoth = [];
        for ($month = 1; $month <= $last_month; $month++) {
            // Recorrer cada dia y buscar si existe un objeto en ese dia o sino poner 0
            $payment_item = $this->searchByMonth($month, $payment_items);
            $diary = $this->searchByMonth($month, $diaries);
            $spend = $this->searchByMonth($month, $spends);

            if ($payment_item || $diary || $spend) {
                $closuresmoth[] = [
                    "month" => $month,
                    "entry" => $payment_item + $diary,
                    "egress" => $spend,
                ];
            }
        }

        $closuresmoth = json_decode(json_encode($closuresmoth, true));

        $pdf = PDF::loadView('statistics.months-report', compact('closuresmoth', 'year'));
        return $pdf->stream('statistics.months-report.pdf');
    }

    // Pantalla incial reporte por mes y año
    public function byWeek(int $month, int $year)
    {
        $month = str_pad((string)$month, 2, '0', STR_PAD_LEFT);

        // SOLUCION

        // Consultas por separadas

        $payment_items = DB::table('payment_items')
            ->select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') AS date, SUM(amount) amount"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->get();

        $diaries = DB::table('diaries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') AS date, SUM(amount) amount"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->get();

        $spends = DB::table('spends')
            ->select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') AS date, SUM(amount) amount"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->get();

        // hacer un for desde el dia uno hasta el dia ultimo del mes

        $year_month = "$year-$month";
        $aux = date('Y-m-d', strtotime("{$year_month} + 1 month"));
        $last_day = (int)date('d', strtotime("{$aux} - 1 day"));

        $closuresweek = [];
        for ($i = 1; $i < $last_day; $i++) {
            $day = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $date = "$day-$month-$year";

            // Recorrer cada dia y buscar si existe un objeto en ese dia o sino poner 0
            $payment_item = $this->search($date, $payment_items);
            $diary = $this->search($date, $diaries);
            $spend = $this->search($date, $spends);

            if ($payment_item || $diary || $spend) {
                $closuresweek[] = [
                    "date" => $date,
                    "entry" => $payment_item + $diary,
                    "egress" => $spend,
                ];
            }
        }

        return response()->json(['closuresweek' => $closuresweek]);
    }

    // Pantalla incial reporte por mes y año
    public function byWeekPdf(int $month, int $year)
    {
        $month = str_pad((string)$month, 2, '0', STR_PAD_LEFT);

        // SOLUCION

        // Consultas por separadas

        $payment_items = DB::table('payment_items')
            ->select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') AS date, SUM(amount) amount"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->get();

        $diaries = DB::table('diaries')
            ->select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') AS date, SUM(amount) amount"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->get();

        $spends = DB::table('spends')
            ->select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') AS date, SUM(amount) amount"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->get();

        // hacer un for desde el dia uno hasta el dia ultimo del mes

        $year_month = "$year-$month";
        $aux = date('Y-m-d', strtotime("{$year_month} + 1 month"));
        $last_day = (int)date('d', strtotime("{$aux} - 1 day"));

        $closuresweek = [];
        for ($i = 1; $i < $last_day; $i++) {
            $day = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $date = "$day-$month-$year";

            // Recorrer cada dia y buscar si existe un objeto en ese dia o sino poner 0
            $payment_item = $this->search($date, $payment_items);
            $diary = $this->search($date, $diaries);
            $spend = $this->search($date, $spends);

            if ($payment_item || $diary || $spend) {
                $closuresweek[] = [
                    "date" => $date,
                    "entry" => $payment_item + $diary,
                    "egress" => $spend,
                ];
            }
        }

        $closuresweek = json_decode(json_encode($closuresweek, true));

        $pdf = PDF::loadView('statistics.months-report', compact('closuresmoth', 'month', 'year'));
        return $pdf->stream('statistics.months-report.pdf');
    }

    function search($date, $array)
    {
        foreach ($array as $element) {
            if ($date == $element->date) {
                return $element->amount;
            }
        }

        return 0;
    }

    // PDF reporte por mes y año
    public function chars()
    {
        $genders = DB::table('customers')
            ->select(DB::raw('COUNT(gender) as count'), 'gender')
            ->groupBy('gender')
            ->get();

        $genders_data = [];
        $genders_ticks = [];
        $index = 1;
        $genders_data[] = [$index, 0];
        $genders_ticks[] = [$index++, ''];

        foreach ($genders as $gender) {
            $genders_data[] = [$index, $gender->count];
            $genders_ticks[] = [$index, $gender->gender];
            $index++;
        }
        $genders_data[] = [$index, 0];
        $genders_ticks[] = [$index, ''];

        $dates = Customer::all('date_of_birth');

        $ages = [];
        $now = new DateTime();

        foreach ($dates as $date) {
            $start = new DateTime($date->date_of_birth);
            $interval = $start->diff($now);
            $ages[] = $interval->format('%y');
        }

        $collection = collect($ages);
        $collection = $collection->sort();
        $collection = $collection->countBy();

        $ages_data = [];
        $ages_ticks = [];
        $index = 1;

        foreach ($collection as $key => $value) {
            $ages_data[] = [$index, $value];
            $ages_ticks[] = [$index, '' . $key];
            $index++;
        }

        $payments = PaymentItem::select(DB::raw('SUM(amount) AS amount'), 'name')
            ->join('branches', 'branch_id', 'branches.id')
            ->groupBy('name')
            ->get();

        $payment_data = [];
        $payment_ticks = [];
        $index = 1;

        $payment_data[] = [$index, 0];
        $payment_ticks[] = [$index++, ''];

        foreach ($payments as $payment) {
            $payment_data[] = [$index, $payment->amount];
            $payment_ticks[] = [$index, $payment->name];
            $index++;
        }
        $payment_data[] = [$index, 0];
        $payment_ticks[] = [$index++, ''];

        return response()->json([
            'genders' => ['data' => $genders_data, 'ticks' => $genders_ticks],
            'ages' => ['data' => $ages_data, 'ticks' => $ages_ticks],
            'branches' => ['data' => $payment_data, 'ticks' => $payment_ticks],
        ]);
    }
}

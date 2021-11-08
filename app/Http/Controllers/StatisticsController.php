<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;

class StatisticsController extends Controller
{
    public function index()
    {
        $closures = DB::select('SELECT SUM(entry) AS entry, SUM(egress) AS egress, YEAR(date) AS date FROM `closures` GROUP BY YEAR(date)');

        $customers = Customer::all();
        $countcustomers = $customers->count();

        $dates = Customer::all('date_of_birth');

        $years = [];
        $now = new DateTime();

        foreach ($dates as $date) {
            $start = new DateTime($date->date_of_birth);
            $interval = $start->diff($now);
            $years[] = $interval->format('%y');
        }

        $sum = 0;
        $cont = 0;

        foreach ($years as $year) {
            $cont++;
            $sum += $year;
        }

        $averange = $sum / $cont;

        // $closures = DB::table('closures')
        //     ->select(DB::raw('sum(amount) AS amount, MONTH(date) AS date'))
        //     ->groupBy('date')
        //     ->get();

        $closures = json_decode(json_encode($closures, true));

        return view('statistics.index', compact('closures', 'countcustomers', 'averange'));
    }

    public function statisticsReport()
    {
        $closures = DB::select('SELECT SUM(entry) AS entry, SUM(egress) AS egress, YEAR(date) AS date FROM `closures` GROUP BY YEAR(date)');
        $closures = json_decode(json_encode($closures, true));
        
        $pdf = PDF::loadView('statistics.statisticsReport', compact('closures'));
       //El codigo siguiente es el que no ejecuta,  si comentas las 4 lineas, funciona normal el reporte. 
        $pdf->setOptions('enable-javascript', true);
        $pdf->setOptions('javascript-delay', 1000);
        $pdf->setOptions('no-stop-slow-scripts', true);
        $pdf->setOptions('enable-smart-shrinking', true);

        return $pdf->stream('statistics.statisticsReport.pdf');
    }

    public function byMonth(int $year)
    {
        $closuresmoth = DB::select("SELECT SUM(entry) AS entry, SUM(egress) AS egress, MONTH(date) AS month FROM closures WHERE YEAR(date) = $year GROUP BY MONTH(date)");
        $closuresmoth = json_decode(json_encode($closuresmoth, true));

        return response()->json(['closuresmoth' => $closuresmoth]);
    }

    public function edit($year)
    {
        $closuresmoth = DB::select("SELECT SUM(entry) AS entry, SUM(egress) AS egress, MONTH(date) AS month FROM closures WHERE YEAR(date) = $year GROUP BY MONTH(date)");
        $closuresmoth = json_decode(json_encode($closuresmoth, true));

        $pdf = PDF::loadView('statistics.monthReport', compact('closuresmoth', 'year'));
        return $pdf->stream('statistics.monthReport.pdf');
    }

    public function byWeek(int $month, int $year)
    {
        $closuresweek = DB::select("SELECT SUM(entry) AS entry, SUM(egress) AS egress, date FROM closures WHERE YEAR(date) = $year AND MONTH(date) = $month GROUP BY date");
        $closuresweek = json_decode(json_encode($closuresweek, true));

        return response()->json(['closuresweek' => $closuresweek]);
    }

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

        return response()->json([
            'genders' => ['data' => $genders_data, 'ticks' => $genders_ticks],
            'ages' => ['data' => $ages_data, 'ticks' => $ages_ticks],
        ]);
    }
}

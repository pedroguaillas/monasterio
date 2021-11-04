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
            $years[] = $interval->format('%a');
        }

        // $closures = DB::table('closures')
        //     ->select(DB::raw('sum(amount) AS amount, MONTH(date) AS date'))
        //     ->groupBy('date')
        //     ->get();

        $closures = json_decode(json_encode($closures, true));

        return view('statistics.index', compact('closures', 'countcustomers'));
    }

    public function statisticsReport()
    {
        $closures = DB::select('SELECT SUM(entry) AS entry, SUM(egress) AS egress, YEAR(date) AS date FROM `closures` GROUP BY YEAR(date)');
        $closures = json_decode(json_encode($closures, true));

        $pdf = PDF::loadView('statistics.statisticsReport', compact('closures'));
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
}

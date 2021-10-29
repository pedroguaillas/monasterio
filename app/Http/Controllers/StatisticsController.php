<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class StatisticsController extends Controller
{
    public function index()
    {
        $closures = DB::select('SELECT SUM(entry) AS entry, SUM(egress) AS egress, YEAR(date) AS date FROM `closures` GROUP BY YEAR(date)');

        // $closures = DB::table('closures')
        //     ->select(DB::raw('sum(amount) AS amount, MONTH(date) AS date'))
        //     ->groupBy('date')
        //     ->get();

        $closures = json_decode(json_encode($closures, true));

        return view('statistics.index', compact('closures'));
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
}

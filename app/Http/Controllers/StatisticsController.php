<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;

class StatisticsController extends Controller
{
    // PDF General
    public function general()
    {
        $closures = DB::table('payments')
            ->select(
                DB::raw("YEAR(start_period) AS year"),
                DB::raw("(SELECT SUM(amount) FROM payment_items AS pi WHERE YEAR(pi.created_at) = year GROUP BY YEAR(pi.created_at)) AS entry"),
                DB::raw("(SELECT SUM(amount) FROM spends AS s WHERE YEAR(s.created_at) = year GROUP BY YEAR(s.created_at)) AS egress"),
            )
            ->groupBy("year")->get();
        // $closures = DB::select('SELECT SUM(entry) AS entry, SUM(egress) AS egress, YEAR(date) AS year FROM `closures` GROUP BY YEAR(date)');
        $closures = json_decode(json_encode($closures, true));

        $pdf = PDF::loadView('statistics.years-report', compact('closures'));

        return $pdf->stream('statistics.years-report.pdf');
    }

    // Pantalla incial reporte por meses
    public function byMonth(int $year)
    {
        $closuresmoth = DB::table('payments')
            ->select(
                DB::raw("MONTH(start_period) AS month"),
                DB::raw("(SELECT SUM(amount) FROM payment_items AS pi WHERE MONTH(pi.created_at) = month AND YEAR(pi.created_at) = $year GROUP BY MONTH(pi.created_at)) AS entry"),
                DB::raw("(SELECT SUM(amount) FROM spends AS s WHERE MONTH(s.created_at) = month AND YEAR(s.created_at) = $year GROUP BY MONTH(s.created_at)) AS egress"),
            )
            ->groupBy("month")->get();
        // $closuresmoth = DB::select("SELECT SUM(entry) AS entry, SUM(egress) AS egress, MONTH(date) AS month FROM closures WHERE YEAR(date) = $year GROUP BY MONTH(date)");
        $closuresmoth = json_decode(json_encode($closuresmoth, true));

        return response()->json(['closuresmoth' => $closuresmoth]);
    }

    // PDF reporte por meses
    public function months($year)
    {
        $closuresmoth = DB::table('payments')
            ->select(
                DB::raw("MONTH(start_period) AS month"),
                DB::raw("(SELECT SUM(amount) FROM payment_items AS pi WHERE MONTH(pi.created_at) = month AND YEAR(pi.created_at) = $year GROUP BY MONTH(pi.created_at)) AS entry"),
                DB::raw("(SELECT SUM(amount) FROM spends AS s WHERE MONTH(s.created_at) = month AND YEAR(s.created_at) = $year GROUP BY MONTH(s.created_at)) AS egress"),
            )
            ->groupBy("month")->get();

        $closuresmoth = json_decode(json_encode($closuresmoth, true));

        $pdf = PDF::loadView('statistics.months-report', compact('closuresmoth', 'year'));
        return $pdf->stream('statistics.months-report.pdf');
    }

    // Pantalla incial reporte por mes y año
    public function byWeek(int $month, int $year)
    {
        $date = str_pad((string)$month, 2, '0', STR_PAD_LEFT) . '-' . $year;

        $closuresweek = DB::table('payments')
            ->select(
                DB::raw("DATE_FORMAT(start_period, '%d-%m-%Y') AS date"),
                DB::raw("(SELECT SUM(amount) FROM payment_items AS pi WHERE MONTH(pi.created_at) = date AND DATE_FORMAT(pi.created_at, '%m-%Y') = $date GROUP BY DATE_FORMAT(pi.created_at, '%m-%Y')) AS entry"),
                DB::raw("(SELECT SUM(amount) FROM spends AS s WHERE MONTH(s.created_at) = date AND DATE_FORMAT(s.created_at, '%m-%Y') = $date GROUP BY DATE_FORMAT(s.created_at, '%m-%Y')) AS egress"),
            )
            ->where("DATE_FORMAT(start_period, '%m-%Y')", $date)
            ->groupBy("date")->get();

        // $closuresweek = DB::select("SELECT SUM(entry) AS entry, SUM(egress) AS egress, DATE_FORMAT(date, '%d-%m-%Y') AS date FROM closures WHERE '$date' = DATE_FORMAT(date, '%m-%Y') GROUP BY date");
        $closuresweek = json_decode(json_encode($closuresweek, true));

        return response()->json(['closuresweek' => $closuresweek]);
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

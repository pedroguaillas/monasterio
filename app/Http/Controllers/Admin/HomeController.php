<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use DateTime;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     $closures = DB::table('payments')
    //         ->select(
    //             DB::raw("YEAR(payments.start_period) AS year"),
    //             DB::raw("(SELECT SUM(amount) FROM payment_items AS pi WHERE DATE_FORMAT(pi.created_at, '%Y') = DATE_FORMAT(start_period, '%Y') GROUP BY DATE_FORMAT(pi.created_at, '%Y')) AS entry"),
    //             DB::raw("(SELECT SUM(amount) FROM spends AS s WHERE DATE_FORMAT(s.created_at, '%Y') = DATE_FORMAT(start_period, '%Y') GROUP BY DATE_FORMAT(s.created_at, '%Y')) AS egress"),
    //         )
    //         ->groupBy("DATE_FORMAT(start_period, '%Y')")->get();

    //     $closures = json_decode(json_encode($closures), false);

    //     $customers = Customer::all();
    //     $countcustomers = $customers->count();

    //     $dates = Customer::all('date_of_birth');

    //     $years = [];
    //     $now = new DateTime();

    //     foreach ($dates as $date) {
    //         $start = new DateTime($date->date_of_birth);
    //         $interval = $start->diff($now);
    //         $years[] = $interval->format('%y');
    //     }

    //     $sum = 0;
    //     $cont = 0;

    //     foreach ($years as $year) {
    //         $cont++;
    //         $sum += $year;
    //     }

    //     $averange = $cont > 0 ? $sum / $cont : 0;

    //     $closures = json_decode(json_encode($closures, true));

    //     return view('admin.index', compact('closures', 'countcustomers', 'averange'));
    // }

    public function index()
    {
        $closures = DB::select('SELECT SUM(entry) AS entry, SUM(egress) AS egress, YEAR(date) AS year FROM `closures` GROUP BY YEAR(date)');

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

        $averange = $cont > 0 ? $sum / $cont : 0;

        // $closures = DB::table('closures')
        //     ->select(DB::raw('sum(amount) AS amount, MONTH(date) AS date'))
        //     ->groupBy('date')
        //     ->get();

        $closures = json_decode(json_encode($closures, true));

        return view('admin.index', compact('closures', 'countcustomers', 'averange'));
    }
}

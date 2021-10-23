<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $reportbymoths = DB::table('payments')
            ->select(DB::raw('sum(amount) as amount, date'))
            ->groupBy('date')
            ->get();

        $reportbymoths = json_decode(json_encode($reportbymoths, true));

        return view('admin.index', compact('reportbymoths'));
    }
}

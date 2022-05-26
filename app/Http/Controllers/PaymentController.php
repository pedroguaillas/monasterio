<?php

namespace App\Http\Controllers;

class PaymentController extends Controller
{
    public function index($customer_id)
    {
        return view('payments.index', compact('customer_id'));
    }
}

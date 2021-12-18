<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AuthFingerController extends Controller
{
    public function index()
    {
        return view('customers.auth_finger');
    }

    public function fingers()
    {
        $customers = Customer::all('id', 'finger');
        return response()->json(['customers' => $customers]);
    }

    public function showCustomer(Customer $customer)
    {
        return response()->json(['customer' => $customer]);
    }
}

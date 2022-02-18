<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function index()
    {
        return view('customers.index');
    }

    public function create()
    {
        $paymentmethods = PaymentMethod::all();
        $branchs = Branch::all();

        return view('customers.create', compact('paymentmethods', 'branchs'));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();

        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'payment_method_id' => 'required',
                'amount' => 'required',
            ],
            [
                'first_name.required' => 'El campo "Nombres" es requerido.',
                'last_name.required' => 'El campo "Apellidos" es requerido.',
                'gender.required' => 'Debe seleccionar el genero.',
                'payment_method_id.required' => 'Debe seleccionar un "Servicio".',
                'amount.required' => 'El campo "Valor a pagar" es requerido.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $file = NULL;
        if ($request->photo) {
            $image_parts = explode(";base64,", $request->photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = 'photos/' . ($request->identification ?: uniqid()) . '.' . $image_type;

            Storage::put($file, $image_base64);
        }

        $customer = Customer::create([
            'branch_id' => $request->brach_id,
            'identification' => $request->identification,
            'user_id' => $auth->id,
            'photo' => $file,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'alias' => $request->alias,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'finger' => $request->finger
        ]);

        $service = PaymentMethod::find($request->payment_method_id);

        $payment = $customer->payments()->create([
            'branch_id' => $request->brach_id,
            'to_pay' => $service->amount,
            'start_period' => $request->date,
            'end_period' => date('Y-m-d', strtotime($request->date . ' +' . $service->months . ' month')),
        ]);

        $paymentItem = $payment->paymentitems()->create([
            'branch_id' => $request->brach_id,
            'description' => $service->description,
            'amount' => $request->amount

        ]);

        return redirect()->route('customers.index');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->identification = $request->identification;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->alias = $request->alias;
        $customer->gender = $request->gender;
        $customer->date_of_birth = $request->date_of_birth;
        $customer->phone = $request->phone;

        $customer->save();

        return redirect()->route('customers.index');
    }
}

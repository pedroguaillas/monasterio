<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paymentmethods = PaymentMethod::all();

        return view('customers.create', compact('paymentmethods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = Auth::user();

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'first_name' => 'required',
        //         'last_name' => 'required',
        //         'gender' => 'required|integer',
        //         'photo' => 'required',
        //         'payment_method_id' => 'required',
        //         'date' => 'required',
        //         'amount' => 'required',
        //     ],
        //     [
        //         'first_name.required' => 'El campo "Nombres" es requerido.',
        //         'last_name.required' => 'El campo "Apellidos" es requerido.',
        //         'gender.integer' => 'Debe seleccionar un "Genero".',
        //         'photo.required' => 'Debe tomarse la foto.',
        //         'payment_method_id.required' => 'Debe seleccionar un "Servicio".',
        //         'date.required' => 'El campo "Fecha de inscripción" es requerido.',
        //         'amount.required' => 'El campo "Valor a pagar" es requerido.',
        //     ]
        // );

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }
        $file = NULL;
        if ($request->photo) {
            $image_parts = explode(";base64,", $request->photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = 'photos/' . uniqid() . '.' . $image_type;

            Storage::put($file, $image_base64);
        }

        $customer = Customer::create([
            'branch_id' => 1,
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
            'branch_id' => 1,
            'to_pay' => $service->amount,
            'start_period' => $request->date,
            'end_period' => date('Y-m-d', strtotime($request->date . ' +' . $service->months . ' month')),
        ]);
        
        $paymentItem = $payment->paymentitems()->create([
            'branch_id' => 1,
            'description' => $service->description,
            'amount' => $request->amount

        ]);

        return view('admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

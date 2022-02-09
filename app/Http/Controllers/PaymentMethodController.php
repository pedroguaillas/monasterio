<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{

    public function index()
    {
        // Este metodo muestra una pagina estatica
        // Solo utilizo esto para mostrar una vista
        // que dentro va estar un componente
        // Este controllador no va hacer nada mas s
        // entonces todos estos metodos estan degana aqui simom
        return view('paymentmethods.index');
    }

    public function show(int $id)
    {
        $paymentMethod = PaymentMethod::find($id);
        return response()->json(['paymentMethod' => $paymentMethod]);
    }

    public function destroy($id)
    {
        PaymentMethod::destroy($id);
    }
}

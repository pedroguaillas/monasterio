@extends('adminlte::page')

@section('title', 'Métodos de pagos')

@section('css')
@livewireStyles
@endsection

@section('content')
<br />
<div class="card">
    @livewire('list-payments', ['customer_id' => $customer_id])
</div>
@endsection

@livewireScripts
@extends('adminlte::page')

@section('title', 'Métodos de pagos')

@section('css')
@livewireStyles
@endsection

@section('content')
<br />
<div class="card">
    @livewire('list-payment-method')
</div>
@endsection

@section('js')
@livewireScripts

<script>
    // Livewire.on('showModal', function() {
    //     $('#modalwindow').modal('show')
    // })

    // Livewire.on('keyboardModal', function() {
    //     $('#modalwindow').modal('show')
    // })

    // Livewire.on('closeModal', function() {
    //     $('#modalwindow').modal('hide')
    // })
</script>
@endsection
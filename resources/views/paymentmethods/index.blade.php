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
    // Esta parte es para mostrar el modal cuando
    Livewire.on('showModal', function() {
        $('#modalwindow').modal('show')
    })

    // Esta parte es para cerrar el modal cuando
    Livewire.on('closeModal', function() {
        $('#modalwindow').modal('hide')
    })
</script>
@endsection
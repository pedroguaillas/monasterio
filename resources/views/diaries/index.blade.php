@extends('adminlte::page')

@section('title', 'Registro Diario')

@section('css')
@livewireStyles
@endsection

@section('content')
<br />
<div class="card text-center align-items-center">
    <div class="card-body">
        @livewire('diary-register')
    </div>
</div>

@endsection

@section('js')
@livewireScripts

<script>
    // Modal completar pago
    Livewire.on('showModalComplete', function() {
        $('#modalcomplete').modal('show')
    })

    Livewire.on('hideModalComplete', function() {
        $('#modalcomplete').modal('hide')
    })
</script>

@endsection
@extends('adminlte::page')

@section('title', 'Lista de usuarios')

@section('css')
@livewireStyles
@endsection

@section('content')
<br />
<div class="card">
    @livewire('search-smart-customers')
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

    // Modal registro nuevo pago
    Livewire.on('showModal', function() {
        $('#modalwindow').modal('show')
    })

    Livewire.on('closeModal', function() {
        $('#modalwindow').modal('hide')
    })

    // otro
    Livewire.on('showModalpayments', function() {
        $('#modalwindowpayments').modal('show')
    })
</script>
@endsection
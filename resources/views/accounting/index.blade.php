@extends('adminlte::page')

@section('title', 'Libro Diario')

@section('css')
@livewireStyles
@endsection

@section('content')
<br />
@livewire('diary-book')

@endsection

@section('js')
@livewireScripts

<script>
    // Alerta del cierre de caja
    Livewire.on('showAlert', function() {
        alert('Se ha echo el cierre de caja')
    })

    // Modal registro de gasto
    Livewire.on('showModal', function() {
        $('#modalwindow').modal('show')
    })

    Livewire.on('closeModal', function() {
        $('#modalwindow').modal('hide')
    })

    // Modal Form new User
    Livewire.on('showModalNew', function() {
        $('#modalwindownew').modal('show')
    })

    Livewire.on('closeModalNew', function() {
        $('#modalwindownew').modal('hide')
    })
</script>
@endsection
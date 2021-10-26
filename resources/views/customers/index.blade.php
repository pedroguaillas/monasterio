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
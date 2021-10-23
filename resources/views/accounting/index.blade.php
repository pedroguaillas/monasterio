@extends('adminlte::page')

@section('title', 'Libro Diario')

@section('css')
@livewireStyles
@endsection

@section('content')
<br />
<div class="card">
    @livewire('diary-book')
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
</script>
@endsection
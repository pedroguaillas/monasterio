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
@endsection
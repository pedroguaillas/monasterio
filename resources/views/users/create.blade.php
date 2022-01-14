@extends('adminlte::page')

@section('title', 'Libro Diario')

@section('css')
@livewireStyles
@endsection

@section('content')
<br />
<div class="card">

    <div class="card-header">
        <h3 class="card-title">Nuevo usuario</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('usuarios.store') }}" method="POST" role="form">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" aria-describedby="Nombre" required>
            </div>

            <div class="form-group">
                <label for="user">Usuario</label>
                <input type="text" class="form-control" name="user" aria-describedby="Usuario" required>
            </div>

            <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" class="form-control" name="email" aria-describedby="Correo" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="form-group">
                <label for="role">Rol</label>
                <select class="form-control" name="role">
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
@endsection

@section('js')
@livewireScripts

@endsection
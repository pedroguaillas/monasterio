@extends('adminlte::page')

@section('title', 'Lista de usuarios')

@section('css')
@livewireStyles
@endsection

@section('content')
<br />

@if('session'('info'))
<div class="col-12">
    <div class="alert alert-info">
        {{session('info')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
    </div>
</div>
@endif

<div class="card">
    @livewire('user-list')
</div>
@endsection

@section('js')
@livewireScripts

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    Livewire.on('showModal', function() {
        $('#modalwindow').modal('show')
    })

    Livewire.on('closeModal', function() {
        $('#modalwindow').modal('hide')
    })

    function userDelete(id) {
        swal({
                title: "¿Esta seguro?",
                text: "Eliminar usuario",
                icon: "warning",
                buttons: ["Cancelar", "Eliminar"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: "{{url('admin/usuarios/destroy')}}/" + id,
                        data: {
                            "_token": $('meta[name="csrf-token"]').content,
                            "_method": "DELETE"
                        },
                        success: () => {
                            swal({
                                    text: "Se elimino un usuario",
                                    icon: "success"
                                })
                                .then((result) => {
                                    location.reload()
                                })
                        }
                    })
                }
            })
    }
</script>
@endsection
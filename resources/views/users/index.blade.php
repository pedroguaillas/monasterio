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


    window.addEventListener('swal:confirm', event => {
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
                        url: "{{url('admin/usuarios/destroy')}}/" + event.detail.id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            // "_token": $('meta[name="csrf-token"]').content,
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


        // swal({
        //         title: event.detail.title,
        //         text: event.detail.text,
        //         icon: event.detail.type,
        //         buttons: ["Cancelar", "Eliminar"],
        //         dangerMode: true
        //     })
        //     .then((willDelete) => {
        //         if (willDelete) {
        //             window.livewire.emit('delete', event.detail.id)
        //         }
        //     })
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
                        url: "{{url('admin/usuarios')}}/" + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
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
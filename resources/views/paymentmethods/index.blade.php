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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    // Esta parte es para mostrar el modal cuando
    Livewire.on('showModal', function() {
        $('#modalwindow').modal('show')
    })

    // Esta parte es para cerrar el modal cuando
    Livewire.on('closeModal', function() {
        $('#modalwindow').modal('hide')
    })

    function payDelete(id) {
        swal({
                title: "¿Esta seguro?",
                text: "Eliminar servicio",
                icon: "warning",
                buttons: ["Cancelar", "Eliminar"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: "{{url('admin/servicios')}}/" + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "DELETE"
                        },
                        success: () => {
                            swal({
                                    text: "Se elimino un servicio",
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
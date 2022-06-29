<div>
    <div class="card-header">
        <h3 class="card-title">{{ "$customer->first_name $customer->last_name" }}</h3>
    </div>

    <div class="card-body">
        <table class="table table-sm mb-0">
            <thead>
                <tr style="text-align: center;">
                    <th>#</th>
                    <th>Periodo</th>
                    <th>Valor</th>
                    <th>Saldo</th>
                    <th></th>
                </tr>
            </thead>
            @if($payments !== null && $payments->count())
            @php
            $i=0;
            @endphp
            <tbody>
                @foreach($payments as $item)
                @php
                $i++;
                @endphp
                <tr style="text-align: right;">
                    <td style="text-align: center;">{{$i}}</td>
                    <td style="text-align: center;">{{"Desde $item->start_period hasta $item->end_period"}}</td>
                    <td>{{$item->to_pay}}</td>
                    <td>{{$item->amount}}</td>
                    <td>
                        <button wire:click="$emit('deleteDialog', {{$item->id}})" title="Eliminar" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @php
                @endphp
                @endforeach
            </tbody>
            @endif
        </table>
    </div>

    @push("js")
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('deleteDialog', payment_id => {
            Swal.fire({
                title: '¿Esta seguro?',
                text: "No podrás revertir esto.!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('list-payments', 'delete', payment_id)
                    Swal.fire(
                        'Eliminado!',
                        'Su pago ha sido eliminado.',
                        'success'
                    )
                }
            })
        })
    </script>
    @endpush
</div>
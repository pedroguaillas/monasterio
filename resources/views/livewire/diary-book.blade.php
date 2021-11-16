<div>
    <div class="card-header">
        <h3 class="text-center">Libro Diario</h3>
    </div>

    <div class="card-body">
        @if(($payments !== null && count($payments)) || ($spends !== null && $spends->count()))
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Ingreso</th>
                    <th>Egreso</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $item)
                <tr>
                    <td>{{ "Cobro mensual $item->first_name $item->last_name" }}</td>
                    <td>{{number_format($item->amount,2, ',', '.')}}</td>
                    <td></td>
                    <td>
                    </td>
                </tr>
                @endforeach
                @foreach($spends as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td></td>
                    <td>{{number_format($item->amount, 2, ',', '.')}}</td>
                    <td>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{{ number_format($sum_entry, 2, ',', '.') }}</th>
                    <th>{{ number_format($sum_egress, 2, ',', '.') }}</th>
                    <th>{{ number_format($sum_entry - $sum_egress, 2, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        @endif
    </div>
    <div class="row">
        <div class="col-sm-10"></div>
        <div class="col-sm-2">
            <!-- create-spend este componente se encarga de registrar el gasto -->
            @livewire('create-spend')
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10"></div>
        <div class="col-sm-2">
            <!-- peste componente no es neceario crear porque solo toca guardar un valor -->
            <!-- mejor voy a pasar el boton aqui -->
            <button wire:click="store" class="btn btn-success mb-3">Cerrar caja</button>
        </div>
    </div>
</div>
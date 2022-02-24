<div>

    <div class="row mb-2">
        <div class="col-1"></div>
        <div class="col-1">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" wire:model="types" />
                <label class="form-check-label" for="Zeus">
                    Zeus
                </label>
            </div>
        </div>
        <div class="col-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="2" wire:model="types" />
                <label class="form-check-label" for="Monasterio">
                    Monasterio
                </label>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group row">
                <label class="control-label col-sm-2">Fecha</label>
                <div class="col-sm-5">
                    <input type="date" max="{{ date('Y-m-d') }}" class="form-control form-control-sm" wire:model="date" required />
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-book"></i>
                Libro Diario
            </h3>
            <div class="card-tools">
                <div class="dt-buttons btn-group flex-wrap">
                    @livewire('create-spend')
                </div>
            </div>
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
                        <td>{{ "$item->first_name $item->last_name" }}</td>
                        <td>{{number_format($item->amount, 2, ',', '.')}}</td>
                        <td></td>
                        <td>
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spends as $item)
                    <tr>
                        <td>&nbsp&nbsp&nbsp&nbsp&nbsp{{ $item->description }}</td>
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
    </div>

</div>
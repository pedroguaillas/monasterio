<div>
    <div class="card-header">
        <h3 class="text-center">Métodos de Pago</h3>
    </div>

    <div class="card-body">
        @if($paymentmethods !== null && $paymentmethods->count())
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Monto</th>
                    <th style="width: 40px">Editar</th>
                </tr>
            </thead>
            @php
            $i=0;
            @endphp
            <tbody>
                @foreach($paymentmethods as $item)
                <tr>
                    @php
                    $i++;
                    @endphp
                    <td>{{$i}}</td>
                    <td>
                        <input type="text" value="{{$item->description}}">
                    </td>
                    <td>
                        <input type="text" wire:model="$item->amount" class="custom-control-input">
                    </td>
                    <td hidden>{{$item->description}}</td>
                    <td hidden>{{$item->amount}}</td>
                    <td>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$i}}">
                                <label class="custom-control-label" for="customSwitch{{$i}}"></label>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
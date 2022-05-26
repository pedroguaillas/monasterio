<div>
    <div class="card-header">
        <h3 class="card-title">{{ "$customer->first_name $customer->last_name" }}</h3>
    </div>

    <div class="card-body">
        @if($payments !== null && $payments->count())
        <table class="table table-sm mb-0">
            <thead>
                <tr style="text-align: center;">
                    <th>#</th>
                    <th>Periodo</th>
                    <th>Servicio</th>
                    <th>Valor</th>
                    <th>Saldo</th>
                    <th></th>
                </tr>
            </thead>
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
                    <td style="text-align: left;">{{$item->description}}</td>
                    <td>{{$item->to_pay}}</td>
                    <td>{{$item->amount}}</td>
                    <td>
                        <div class="btn-group">
                            <a title="Editar" class="btn btn-success btn-sm">
                                <i class="far fa-money-bill-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @php
                @endphp
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
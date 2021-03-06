<div>
    <div class="card-header">
        <h3 class="text-center">Usuarios</h3>
        <div>
            <div class="input-group input-group">
                <input type="text" wire:model="search" class="form-control float-right" placeholder="Buscar">
            </div>
        </div>
    </div>

    <div class="card-body">
        @if($customers !== null && count($customers))
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th></th>
                    <th style="width: 1em"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{$customer->identification}}</td>
                    <td>{{$customer->first_name}}</td>
                    <td>{{$customer->last_name}}</td>
                    <td>
                        @if($customer->to_pay - $customer->amount)
                        @hasrole('Jefe')
                        <button class="btn btn-secondary" wire:click="showComplete({{$customer->id}})">
                            $ {{ $customer->to_pay - $customer->amount}} Pagar
                        </button>
                        @else
                        <button class="btn btn-secondary" wire:click="complete({{$customer->id}})">
                            $ {{ $customer->to_pay - $customer->amount}} Pagar
                        </button>
                        @endhasrole
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a title="Pagar" wire:click="createPayment({{$customer->id}})" class="btn btn-success btn-sm">
                                <i class="far fa-money-bill-alt"></i>
                            </a>
                            @hasrole('Jefe')
                            <a title="Historial de pagos" href="{{ route('admin.pagos', $customer->id) }}" class="btn btn-secondary btn-sm ml-1">
                                <i class="far fa-list-alt"></i>
                            </a>
                            @else
                            <a title="Historial de pagos" wire:click="listPayments({{$customer->id}})" class="btn btn-secondary btn-sm ml-1">
                                <i class="far fa-list-alt"></i>
                            </a>
                            @endhasrole

                            <!-- <a title="Historial de pagos" wire:click="listPayments({{$customer->id}})" class="btn btn-secondary btn-sm ml-1">
                                <i class="far fa-list-alt"></i>
                            </a> -->
                            <a title="Editar usuario" href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary btn-sm ml-1">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- modal para completar el pago --}}
    <x-adminlte-modal id="modalcomplete" wire:ignore title="Pagar" theme="lightblue" icon="fas fa-money-bill-wave" v-centered scrollable>

        <div class="form-group row">
            <label class="control-label col-sm-5" for="branch_id">Sede</label>
            <div class="col-sm-5">
                <select class="custom-select form-control form-control-sm" wire:model="payment.branch_id" required>
                    @foreach($branchs as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button style="height: 3em;" wire:click="complete1" class="bg-lightblue" icon="fas fa-lg fa-save" />
        </x-slot>
    </x-adminlte-modal>

    {{-- modal para registrar nuevo pago --}}
    <x-adminlte-modal id="modalwindow" wire:ignore title="Pagos" theme="lightblue" icon="fas fa-money-bill-wave" v-centered scrollable>

        <div class="form-group row">
            <label class="control-label col-sm-5">Fecha de pago</label>
            <div class="col-sm-5">
                <input type="date" wire:model="payment.date" class="form-control form-control-sm" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-5" for="amount">Servicio</label>
            <div class="col-sm-5">
                <select class="custom-select form-control form-control-sm" wire:model="payment.service_id" required>
                    <option value="">Seleccione</option>
                    @foreach($paymentmethods as $item)
                    <option value="{{$item->id}}">{{$item->amount . ' ' .$item->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-5">Fecha próximo pago</label>
            <div class="col-sm-5">
                <input type="text" wire:model="date_next_month" class="form-control form-control-sm" disabled>
            </div>
        </div>

        @hasrole('Jefe')
        <div class="form-group row">
            <label class="control-label col-sm-5" for="branch_id">Sede</label>
            <div class="col-sm-5">
                <select class="custom-select form-control form-control-sm" wire:model="payment.branch_id" required>
                    @foreach($branchs as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endhasrole

        <div class="form-group row mb-0">
            <label class="control-label col-sm-5">Valor a pagar ($)</label>
            <div class="col-sm-2">
                <input type="number" wire:model="payment.amount" min="10" max="payment.amount" class="form-control form-control-sm" required>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button style="height: 3em;" wire:click="storePayment" class="bg-lightblue" icon="fas fa-lg fa-save" />
        </x-slot>
    </x-adminlte-modal>

    {{-- modal para mostrar la lista de pagos --}}
    <x-adminlte-modal id="modalwindowpayments" title="Pagos" theme="lightblue" icon="fas fa-money-bill-wave" v-centered size="lg" scrollable>

        @if($payments !== null && $payments->count())
        <table class="table table-sm mb-0">
            <thead>
                <tr style="text-align: center;">
                    <th>#</th>
                    <th>Periodo</th>
                    <th>Servicio</th>
                    <th>Valor</th>
                    <th>Pagado</th>
                    <th>Saldo</th>
                    @hasrole('Jefe')
                    <th>
                    </th>
                    @endhasrole
                </tr>
            </thead>
            @php
            $i=0;
            $residue=0;
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
                    <td>{{number_format($item->to_pay - ($item->amount + $residue), 2, '.', ',')}}</td>
                    @hasrole('Jefe')
                    <th>
                        <button class="btn btn-danger" wire:click="delete({{$item->id}})">
                            Eliminar
                        </button>
                    </th>
                    @endhasrole
                </tr>
                @php
                $residue = ($item->to_pay - $item->amount) > 0 && ($item->to_pay - ($item->amount + $residue)) > 0 ? $item->amount : 0;
                @endphp
                @endforeach
            </tbody>
        </table>
        @endif
    </x-adminlte-modal>
</div>
<div>
    <div class="card-header">
        <h3 class="text-center">Usuarios</h3>
        <div>
            <div class="input-group input-group">
                <input type="text" wire:model="search" name="table_search" class="form-control float-right" placeholder="Buscar">
            </div>
        </div>
    </div>

    <div class="card-body">
        @if($customers !== null && $customers->count())
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th style="width: 40px">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{$customer->identification}}</td>
                    <td>{{$customer->first_name}}</td>
                    <td>{{$customer->last_name}}</td>
                    <td>
                        <a wire:click="edit({{$customer->id}})" class="btn btn-success">Pagar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- modal --}}
    <x-adminlte-modal id="modalwindow" wire:ignore title="Pagos" theme="green" icon="fas fa-money-bill-wave" v-centered scrollable>
        <div class="form-group row">
            <label class="control-label col-sm-5">Fecha de pago</label>
            <div class="col-sm-5">
                <input type="date" wire:model="payment.date" class="form-control form-control-sm" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-5" for="amount">Metodos de pago</label>
            <div class="col-sm-5">
                <select class="custom-select form-control form-control-sm" id="amount" wire:model="amount" required>
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

        <div class="form-group row">
            <label class="control-label col-sm-5">Valor a pagar ($)</label>
            <div class="col-sm-2">
                <input type="number" wire:model="payment.amount" min="10" class="form-control form-control-sm" required>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button style="height: 3em;" wire:click="storePayment" theme="success" icon="fas fa-lg fa-save" />
        </x-slot>
    </x-adminlte-modal>
</div>
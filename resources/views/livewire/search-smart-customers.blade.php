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
    {{-- Custom --}}
    <x-adminlte-modal id="modalwindow" title="Pagos" theme="teal"
        icon="fas fa-bell" v-centered static-backdrop scrollable>
                        <div class="form-group row">
                            <label class="control-label col-sm-4">Fecha de inscripción</label>
                            <div class="col-sm-4">
                                <input type="date" wire:model="payment.date" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        {{-- With append slot, number type and sm size --}}
                        <x-adminlte-input name="month" label="Mes (es)" placeholder="number" type="number"
                            igroup-size="sm" min=1 max=10>
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-dark">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <!-- <div class="form-group row">
                            <label class="control-label col-sm-4">Mes (es)</label>
                            <div class="col-sm-2">
                                <input type="number" wire:model="month" min="1" class="form-control form-control-sm" required>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="control-label col-sm-4">Fecha mes próximo</label>
                            <span class="control-label col-sm-8">{{$date_next_month}}</span>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4">Valor a pagar ($)</label>
                            <div class="col-sm-2">
                                <input type="number" wire:model="payment.amount" min="10" class="form-control form-control-sm" required>
                            </div>
                        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept"/>
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal"/>
        </x-slot>
    </x-adminlte-modal>
    <!-- <div class="modal fade" id="modalwindow" tabindex="-1" role="dialog" aria-labelledby="modalwindow-title" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                    <div class="modal-header">
                        <h4 class="modal-title">Pagos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="control-label col-sm-4">Fecha de inscripción</label>
                            <div class="col-sm-4">
                                <input type="date" wire:model="payment.date" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4">Mes (es)</label>
                            <div class="col-sm-2">
                                <input type="number" wire:model="month" min="1" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4">Fecha mes próximo</label>
                            <span class="control-label col-sm-8">{{$date_next_month}}</span>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4">Valor a pagar ($)</label>
                            <div class="col-sm-2">
                                <input type="number" wire:model="payment.amount" min="10" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="storePayment" class="btn btn-primary">Guardar</button>
                    </div>
            </div>
        </div>
    </div> -->
</div>
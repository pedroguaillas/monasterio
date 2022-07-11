<div>
    <!-- Esta vista es un componente controlado por ListPaymentMethod -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Servicios</h3>
            <div class="card-tools">
                <div class="dt-buttons btn-group flex-wrap">
                    <a title="Agregar servicio" type="button" class="btn btn-success btn-sm" wire:click="create()">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($paymentmethods !== null && $paymentmethods->count())
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Monto</th>
                        <th>Mes</th>
                        <th style="width: 1.5em;">Accion</th>
                    </tr>
                </thead>
                @php
                $i=0;
                @endphp
                <tbody>
                    @foreach($paymentmethods as $item)
                    <tr wire:key="unico{{$i}}">
                        @php
                        $i++;
                        @endphp
                        <td>{{$i}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->amount}}</td>
                        <td>{{$item->months}}</td>
                        <td>

                            <!-- SECCION DEL BOTON EDITAR QUE DESPLEGA EL MODAL  -->
                            <div class="btn-group">
                                <button class="btn btn-primary btn-sm" wire:click="editar({{ $item->id }})">
                                    <i class="far fa-edit"></i>
                                </button>

                                <button title="Eliminar" class="btn btn-danger btn-sm ml-1" onClick='payDelete("{{ $item->id }}")'>
                                    <i class="far fa-trash-alt"></i>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <livewire:update-diary />

    {{-- modal --}}
    <x-adminlte-modal id="modalwindow" wire:ignore title="Formulario servicio" theme="green" icon="fas fa-money-bill-wave" v-centered scrollable>

        <div class="form-group row">
            <label class="control-label col-sm-3">Descripción</label>
            <div class="col-sm-6">
                <input type="text" wire:model="description" class="form-control form-control-sm" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-3">Precio ($)</label>
            <div class="col-sm-2">
                <input type="text" wire:model="amount" class="form-control form-control-sm" required>
            </div>
        </div>

        <div class="form-group row mb-0">
            <label class="control-label col-sm-3">Meses</label>
            <div class="col-sm-2">
                <input type="text" wire:model="months" class="form-control form-control-sm" required>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button style="height: 3em;" wire:click="update" theme="success" icon="fas fa-lg fa-save" />
        </x-slot>
    </x-adminlte-modal>
</div>
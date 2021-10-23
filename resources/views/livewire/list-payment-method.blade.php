<div>
    <!-- Esta vista es un componente controlado por ListPaymentMethod -->
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
                    <th style="width: 40px">Accion</th>
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
                    <td>

                        <!-- SECCION DEL BOTON EDITAR QUE DESPLEGA EL MODAL  -->

                        <div class="form-group">
                            <button wire:click="editar({{$item->id}})">Editar</button>


                            <!-- <div class="custom-control custom-switch">
                                <input type="checkbox" wire:model="selected" value="{{$item->id}}" class="custom-control-input" id="customSwitch{{$i}}">
                                <label class="custom-control-label" for="customSwitch{{$i}}"></label>
                            eso ya mi propi tutorial ggggg bn bn
                            </div> -->
                        </div>
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
            <label class="control-label col-sm-4">Descripcion</label>
            <div class="col-sm-8">
                <input type="text" wire:model="paymentMethod.description" class="form-control form-control-sm" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-4">Precio</label>
            <div class="col-sm-8">
                <input type="text" wire:model="paymentMethod.amount" class="form-control form-control-sm" required>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button style="height: 6em;" wire:click="update" theme="success" label="Editar" />
        </x-slot>
    </x-adminlte-modal>
</div>



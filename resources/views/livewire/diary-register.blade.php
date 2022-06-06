<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <p class="card-text">Monto de hoy ${{ $total }}</p>

    <div action="#" class="form-inline">
        <div class="form-group mx-sm-3 mb-2">
            <input wire:model="amount" type="number" class="form-control" id="amountvalue" />
        </div>
        @hasrole('Jefe')
        <button class="btn btn-primary" wire:click="showComplete()">Registrar</button>
        @else
        <button wire:click="register" type="button" class="btn btn-primary mb-2">Registrar</button>
        @endhasrole
    </div>

    {{-- modal para completar el pago --}}
    <x-adminlte-modal id="modalcomplete" wire:ignore title="Pagar" theme="lightblue" icon="fas fa-money-bill-wave" v-centered scrollable>

        <div class="form-group row">
            <label class="control-label col-sm-5" for="branch_id">Sede</label>
            <div class="col-sm-5">
                <select class="custom-select form-control form-control-sm" wire:model="branch_id" required>
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
</div>
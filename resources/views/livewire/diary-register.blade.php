<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="card text-center align-items-center">
                <div class="card-body">
                    <p class="h1">${{ number_format($total, 2) }}</p>
                    @hasrole('Jefe')
                    <button class="btn btn-primary" wire:click="$emit('showModal')">+</button>
                    @else
                    <button wire:click="register" type="button" class="btn btn-primary mb-2">+</button>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>

    {{-- modal para completar el pago --}}
    <x-adminlte-modal id="branchSelectModal" wire:ignore title="Pagar" theme="lightblue" icon="fas fa-money-bill-wave" v-centered scrollable>

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
            <x-adminlte-button style="height: 3em;" wire:click="registerModal" class="bg-lightblue" icon="fas fa-lg fa-save" />
        </x-slot>
    </x-adminlte-modal>


    @push("js")
    <script>
        Livewire.on('showModal', () => {
            $('#branchSelectModal').modal('show')
        })

        Livewire.on('hideModal', () => {
            $('#branchSelectModal').modal('hide')
        })
    </script>
    @endpush
</div>
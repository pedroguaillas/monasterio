<div>

    <button class="btn btn-success" data-toggle="modal" data-target="#modalwindow">Agregar egreso</button>

    <x-adminlte-modal id="modalwindow" wire:ignore role="dialog" theme="green" title="Registro de gasto">
        <form wire:submit.prevent="store">
            <div class="modal-body">

                <div class="form-group row">
                    <label class="control-label col-sm-4" for="description">Descripción</label>
                    <div class="col-sm-8">
                        <input type="text" wire:model="description" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <label class="control-label col-sm-4" for="amount">Costo ($)</label>
                    <div class="col-sm-3">
                        <input type="text" wire:model="amount" class="form-control form-control-sm" required>
                    </div>
                </div>
            </div>

            <x-slot name="footerSlot">
                <x-adminlte-button style="height: 3em;" wire:click="store" theme="success" icon="fas fa-lg fa-save" />
            </x-slot>
        </form>
    </x-adminlte-modal>

</div>
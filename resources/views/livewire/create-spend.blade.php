<div>

    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#modalwindow">Agregar Egreso</button>

    <x-adminlte-modal id="modalwindow" wire:ignore role="dialog" theme="green" title="Registro de Gastos">
        <form wire:submit.prevent="store">
            <div class="modal-body">

                <div class="form-group row">
                    <label class="control-label col-sm-4" for="description">Descripción</label>
                    <div class="col-sm-8">
                        <input type="text" wire:model="description" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-sm-4" for="amount">Costo ($)</label>
                    <div class="col-sm-3">
                        <input type="text" wire:model="amount" class="form-control form-control-sm" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" style="height: 3em;"><i class="far fa-save"></i></button>
            </div>
        </form>
    </x-adminlte-modal>
    
</div>
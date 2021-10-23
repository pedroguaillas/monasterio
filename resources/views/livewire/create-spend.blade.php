<div>
    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#modalwindow">Agregar Egreso</button>
    <div class="modal fade" id="modalwindow" wire:ignore role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Registro de Gasto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
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
                        <button class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
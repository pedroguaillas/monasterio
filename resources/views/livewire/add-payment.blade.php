<div>
    <a class="btn btn-success" data-toggle="modal" data-target="#modal-test" href="#">Pagar</a>
    <div class="modal fade" id="modal-test">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="store">
                    <div class="modal-header">
                        <h4 class="modal-title">Pagos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="date">Fecha de inscripción</label>
                            <div class="col-sm-4">
                                <input type="date" wire:model="date" class="form-control form-control-sm" id="date" name="date" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="month">Mes (es)</label>
                            <div class="col-sm-2">
                                <input type="number" wire:model="month" min="1" class="form-control form-control-sm" id="month" name="month" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4">Fecha mes próximo</label>
                            <span class="control-label col-sm-8">{{$date_next_month}}</span>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="amount">Valor a pagar ($)</label>
                            <div class="col-sm-2">
                                <input type="number" wire:model="amount" min="10" class="form-control form-control-sm" id="amount" name="amount" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <a class="btn btn-success" href="#">Editar</a> -->
</div>
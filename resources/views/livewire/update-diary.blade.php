<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <div class="card">
        <div class="card-header">
            <div class="card-title">Diario</div>
        </div>
        <div class="card-body">
            <div class="card-tools">
                <div class="dt-buttons btn-group flex-wrap" style="width: 300px;">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Diario</span>
                        </div>
                        <input wire:model="amount" class="form-control">
                        <div class="input-group-append">
                            <button wire:click="save" title="Actualizar" class="input-group-text">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
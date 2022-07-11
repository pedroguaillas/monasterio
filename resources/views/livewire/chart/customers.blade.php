<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <div class="row mb-3">
        <div class="col-5"></div>
        <div class="col-1">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" wire:model="types" />
                <label class="form-check-label" for="Zeus">
                    Zeus
                </label>
            </div>
        </div>
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="2" wire:model="types" />
                <label class="form-check-label" for="Monasterio">
                    Monasterio
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-users"></i>
                        Usuarios
                    </h3>
                </div>
                <div class="card-body" style="height: 34rem;">
                    <livewire:livewire-pie-chart key="{{ $columnChartModelCustomers->reactiveKey() }}" :pie-chart-model="$columnChartModelCustomers" />
                </div>
            </div>
        </div>
    </div>
</div>
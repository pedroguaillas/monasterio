<div>

    <div class="row mb-2">
        <div class="col-1"></div>
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
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-users"></i>
                        Usuarios
                    </h3>
                </div>
                <div class="card-body" style="height: 24rem;">
                    <livewire:livewire-pie-chart key="{{ $columnChartModelCustomers->reactiveKey() }}" :pie-chart-model="$columnChartModelCustomers" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-home"></i>
                        Sedes
                    </h3>
                </div>
                <div class="card-body" style="height: 24rem;">
                    <livewire:livewire-column-chart key="{{ $columnChartModelGenere->reactiveKey() }}" :column-chart-model="$columnChartModelGenere" />
                </div>
            </div>
        </div>
    </div>
    <!-- Falta por hora ingreso -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-calendar"></i>
                        Edades
                    </h3>
                </div>
                <div class="card-body" style="height: 24rem;">
                    <livewire:livewire-column-chart key="{{ $columnChartModelDates->reactiveKey() }}" :column-chart-model="$columnChartModelDates" />
                </div>
            </div>
        </div>
    </div>

</div>
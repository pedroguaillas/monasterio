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

    <!-- Reporte por rango de fechas -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-statistics"></i>
                Reporte por rango de fechas
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Inicio</label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control form-control-sm" wire:model="date_start" required />
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Fin</label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control form-control-sm" wire:model="date_end" required />
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Ingresos</th>
                        <th>Egresos</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($closures as $item)
                    <tr data-widget="expandable-table" aria-expanded="true">
                        <td style="width: 25%;">{{$item->date}}</td>
                        <td style="width: 25%;">{{ number_format($item->entry, 2, ',', '.') }}</td>
                        <td style="width: 25%;">{{ number_format($item->egress, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->entry - $item->egress, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
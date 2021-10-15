<div>
    <div class="card-header">
        <h3 class="text-center">Usuarios</h3>
        <div>
            <div class="input-group input-group">
                <input type="text" wire:model="search" name="table_search" class="form-control float-right" placeholder="Buscar">
            </div>
        </div>
    </div>

    <div class="card-body">
        @if($customers !== null && $customers->count())
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th style="width: 40px">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{$customer->identification}}</td>
                    <td>{{$customer->first_name}}</td>
                    <td>{{$customer->last_name}}</td>
                    <td>
                        <livewire:add-payment :post="$customer">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
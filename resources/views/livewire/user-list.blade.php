<div>
    <div class="card-header">
        <h3 class="card-title">Lista de usuarios</h3>
        <div class="card-tools">
            <div class="dt-buttons btn-group flex-wrap">
                <a type="button" class="btn btn-success btn-sm" href="{{ url('admin/usuarios/create') }}">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if($users !== null && count($users))
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th style="width: 1.5em;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->user }}</td>
                    <td>
                        <div class="btn-group">
                            <a title="Editar" wire:click="edit({{ $item->id }})" class="btn btn-primary btn-sm">
                                <i class="far fa-edit"></i>
                            </a>

                            <button title="Eliminar" class="btn btn-danger btn-sm ml-1" onClick='userDelete("{{ $item->id }}")'>
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- modal pago --}}
    <x-adminlte-modal id="modalwindow" wire:ignore title="Editar usuario" theme="lightblue" icon="fas fa-user" v-centered scrollable>
        <div class="form-group row">
            <label class="control-label col-sm-5">Nombre</label>
            <div class="col-sm-5">
                <input type="text" wire:model="user.name" class="form-control form-control-sm" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-5" for="amount">Usurio</label>
            <div class="col-sm-5">
                <input type="text" wire:model="user.user" class="form-control form-control-sm" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-5">Correo</label>
            <div class="col-sm-5">
                <input type="email" wire:model="user.email" class="form-control form-control-sm" required>
            </div>
        </div>

        <!-- <div class="form-group row">
            <label class="control-label col-sm-5">Contraseña</label>
            <div class="col-sm-5">
                <input type="password" wire:model="user.password" class="form-control form-control-sm">
            </div>
        </div> -->

        <x-slot name="footerSlot">
            <x-adminlte-button style="height: 3em;" wire:click="update()" class="bg-lightblue" icon="fas fa-lg fa-save" />
        </x-slot>
    </x-adminlte-modal>
</div>
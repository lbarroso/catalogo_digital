@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-users mr-2"></i> Clientes (Local)</h1>
            <small class="text-muted d-block mt-1">Almacén: <strong>{{ $almcnt }}</strong></small>
        </div>
        <div class="col-sm-6 text-right mt-2 mt-sm-0">
            <a href="{{ route('customers.import.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-file-excel mr-1"></i> Importar Excel
            </a>
            <form action="{{ route('customers.syncSupabase') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-success">
                    <i class="fas fa-cloud-upload-alt"></i> Sincronizar clientes a Pedidos
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h3 class="card-title mb-0">
                    <i class="fas fa-table mr-1"></i> Lista de clientes
                </h3>
                <form method="GET" action="{{ route('customers.index') }}" class="form-inline">
                    <div class="input-group input-group-sm">
                        <input type="text"
                               name="q"
                               value="{{ $q ?? '' }}"
                               class="form-control"
                               placeholder="Buscar: ctecve, localidad, encargado..."
                               style="min-width: 220px;">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary" title="Limpiar">
                                <i class="fas fa-eraser"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>CTECVE</th>
                            <th>Canal</th>
                            <th>Localidad</th>
                            <th>Encargado</th>
                            <th>Teléfono</th>
                            <th>RFC</th>
                            <th>CURP</th>
                            <th>CP</th>
                            <th>Lat</th>
                            <th>Lng</th>
                            <th>Ruta Sup</th>
                            <th>Nombre Sup</th>
                            <th>Actualizado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($customers as $c)
                        <tr>
                            <td class="font-weight-bold">{{ $c->ctecve }}</td>
                            <td>
                                <span class="badge badge-{{ ((int)$c->canal === 57) ? 'success' : (((int)$c->canal === 54) ? 'warning' : 'secondary') }}">
                                    {{ $c->canal }}
                                </span>
                            </td>
                            <td>{{ $c->localidad }}</td>
                            <td>{{ $c->encargado }}</td>
                            <td>{{ $c->telefono }}</td>
                            <td>{{ $c->rfc }}</td>
                            <td>{{ $c->curp }}</td>
                            <td>{{ $c->codigo_postal }}</td>
                            <td class="text-monospace small">
                                @if(!is_null($c->latitud)) {{ number_format((float)$c->latitud, 6) }} @endif
                            </td>
                            <td class="text-monospace small">
                                @if(!is_null($c->longitud)) {{ number_format((float)$c->longitud, 6) }} @endif
                            </td>
                            <td>{{ $c->ruta_sup }}</td>
                            <td>{{ $c->nombre_sup }}</td>
                            <td class="text-muted small">{{ $c->updated_at }}</td>
                            <td class="text-center">
                                <button type="button"
                                        class="btn btn-sm btn-warning btn-edit-localidad"
                                        data-id="{{ $c->id }}"
                                        data-ctecve="{{ $c->ctecve }}"
                                        data-canal="{{ $c->canal }}"
                                        data-localidad="{{ $c->localidad ?? '' }}"
                                        data-encargado="{{ $c->encargado ?? '' }}"
                                        title="Editar localidad">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center text-muted py-4">
                                No se encontraron clientes para este almacén.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer clearfix">
            <div class="float-right">
                {{ $customers->links() }}
            </div>
            <div class="float-left text-muted small">
                Mostrando {{ $customers->firstItem() ?? 0 }} a {{ $customers->lastItem() ?? 0 }}
                de {{ $customers->total() }} registros
            </div>
        </div>
    </div>

</div>

{{-- Modal: Editar Localidad --}}
<div class="modal fade" id="modalEditLocalidad" tabindex="-1" role="dialog" aria-labelledby="modalEditLocalidadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="modalEditLocalidadLabel">
                    <i class="fas fa-map-marker-alt mr-2"></i> Editar Localidad
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditLocalidad"
                  action="{{ route('customers.updateLocalidad', ['id' => '__ID__']) }}"
                  data-action-template="{{ route('customers.updateLocalidad', ['id' => '__ID__']) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row mb-2">
                        <label class="col-sm-4 col-form-label text-muted small">CTECVE</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm bg-light" id="modalCtecve" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-4 col-form-label text-muted small">Canal</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm bg-light" id="modalCanal" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-4 col-form-label text-muted small">Encargado</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm bg-light" id="modalEncargado" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group mb-0">
                        <label for="modalLocalidad">Localidad <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control"
                               name="localidad"
                               id="modalLocalidad"
                               required
                               placeholder="Nombre de la localidad">
                        <input type="hidden" name="id" id="modalId">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnSync = document.getElementById('btnSyncSupabase');
    if (btnSync) {
        btnSync.addEventListener('click', function() {
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sincronizando...';
        });
    }

    // Editar localidad: abrir modal y rellenar datos
    var modal = document.getElementById('modalEditLocalidad');
    var form = document.getElementById('formEditLocalidad');
    var modalCtecve = document.getElementById('modalCtecve');
    var modalCanal = document.getElementById('modalCanal');
    var modalEncargado = document.getElementById('modalEncargado');
    var modalLocalidad = document.getElementById('modalLocalidad');
    var modalId = document.getElementById('modalId');
    var actionTemplate = form ? form.getAttribute('data-action-template') : null;

    document.querySelectorAll('.btn-edit-localidad').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var ctecve = this.getAttribute('data-ctecve') || '';
            var canal = this.getAttribute('data-canal') || '';
            var localidad = this.getAttribute('data-localidad') || '';
            var encargado = this.getAttribute('data-encargado') || '';

            if (modalId) modalId.value = id;
            if (modalCtecve) modalCtecve.value = ctecve;
            if (modalCanal) modalCanal.value = canal;
            if (modalEncargado) modalEncargado.value = encargado;
            if (modalLocalidad) modalLocalidad.value = localidad;

            if (form && actionTemplate && id) {
                form.action = actionTemplate.replace('__ID__', id);
            }

            $(modal).modal('show');
        });
    });
});
</script>
@endsection

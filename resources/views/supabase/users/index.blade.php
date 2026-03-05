{{--
    Listado de usuarios de Supabase (Auth + public.users)
    Catálogo Digital / Pedidos Offline
    Con DataTables y estilo AdminLTE profesional
--}}
@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-users-cog"></i> Usuarios Supabase
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Usuarios Supabase</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">

    {{-- MENSAJES FLASH --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check-circle"></i>
            <strong>¡Éxito!</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-exclamation-circle"></i>
            <strong>Error:</strong> {{ session('error') }}
        </div>
    @endif

    {{-- CARD PRINCIPAL --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table"></i> Listado de Usuarios Registrados
            </h3>

            <div class="card-tools">
                {{-- BUSCADOR POR EMAIL --}}
                <div class="input-group input-group-sm" style="width: 250px; display: inline-flex;">
                    <input type="text" id="searchEmail" class="form-control"
                        placeholder="Buscar por email...">
                    <div class="input-group-append">
                        <button class="btn btn-default" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                {{-- BOTÓN AGREGAR USUARIO --}}
                <a href="{{ route('supabase.users.create') }}" class="btn btn-primary btn-sm ml-2">
                    <i class="fas fa-user-plus"></i> Agregar Usuario
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table id="usersTable" class="table table-hover text-nowrap">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 100px;">UUID</th>
                        <th>Email</th>
                        <th>Nombre</th>
                        <th style="width: 80px;">Almacén</th>
                        <th style="width: 150px;">Rol</th>
                        <th style="width: 150px;">Fecha Registro</th>
                        
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $u)
                        @php
                            // Determinar texto y clase del rol
                            $roleValue = $u['public']['role'] ?? null;
                            $roleText = '—';
                            $roleBadgeClass = 'badge-secondary';
                            
                            if ($roleValue === 0 || $roleValue === '0') {
                                $roleText = 'Encargado de Tienda';
                                $roleBadgeClass = 'badge-info';
                            } elseif ($roleValue === 1 || $roleValue === '1') {
                                $roleText = 'Supervisor';
                                $roleBadgeClass = 'badge-warning';
                            }
                            
                            // Último acceso
                            $lastSignIn = $u['last_signin'] ?? null;
                            $lastSignInFormatted = $lastSignIn 
                                ? \Carbon\Carbon::parse($lastSignIn)->format('Y-m-d H:i')
                                : 'Nunca';
                            $lastSignInClass = !$lastSignIn ? 'text-danger' : 
                                (\Carbon\Carbon::parse($lastSignIn)->isToday() ? 'text-success' : 'text-muted');
                        @endphp

                        <tr>
                            {{-- UUID (corto) --}}
                            <td>
                                <span class="badge badge-pill badge-light text-monospace" 
                                      title="{{ $u['auth_id'] }}"
                                      data-toggle="tooltip">
                                    {{ substr($u['auth_id'], 0, 8) }}…
                                </span>
                            </td>

                            {{-- EMAIL --}}
                            <td class="text-primary font-weight-bold">
                                <i class="fas fa-envelope fa-sm"></i> {{ $u['email'] }}
                            </td>

                            {{-- NOMBRE --}}
                            <td>
                                @if(isset($u['public']['name']))
                                    <i class="fas fa-user fa-sm text-muted"></i> {{ $u['public']['name'] }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- ALMACÉN --}}
                            <td class="text-center">
                                @if(isset($u['public']['almcnt']))
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-warehouse fa-sm"></i> {{ $u['public']['almcnt'] }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- ROL --}}
                            <td>
                                <span class="badge {{ $roleBadgeClass }}">
                                    @if($roleValue === 0 || $roleValue === '0')
                                        <i class="fas fa-user"></i>
                                    @elseif($roleValue === 1 || $roleValue === '1')
                                        <i class="fas fa-user-tie"></i>
                                    @endif
                                    {{ $roleText }}
                                </span>
                            </td>

                            {{-- FECHA REGISTRO --}}
                            <td>
                                <small>
                                    <i class="fas fa-calendar-alt fa-sm text-muted"></i>
                                    {{ \Carbon\Carbon::parse($u['created_at'])->format('Y-m-d H:i') }}
                                </small>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                No hay usuarios registrados aún.
                                <br>
                                <a href="{{ route('supabase.users.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-user-plus"></i> Crear el primer usuario
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <div class="float-left">
                <a href="{{ route('supabase.users.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Agregar Nuevo Usuario
                </a>
            </div>
            <div class="float-right">
                <small class="text-muted">
                    <i class="fas fa-users"></i> Total usuarios: <strong>{{ count($users) }}</strong>
                </small>
            </div>
        </div>
    </div>

    {{-- LEYENDA DE ROLES --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-secondary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Leyenda de Roles
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><span class="badge badge-info"><i class="fas fa-user"></i> Encargado de Tienda</span></td>
                            <td>Rol <code>0</code> - Acceso básico a operaciones de tienda</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning"><i class="fas fa-user-tie"></i> Supervisor</span></td>
                            <td>Rol <code>1</code> - Acceso a supervisión y reportes</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


{{-- ESTILOS --}}
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    /* Estilos para mejorar la tabla */
    table td { vertical-align: middle !important; }
    .badge-pill { font-size: .85rem; }
    
    /* Card outline */
    .card-outline.card-primary {
        border-top: 3px solid #007bff;
    }
    
    /* Tooltips en UUID */
    [data-toggle="tooltip"] {
        cursor: help;
    }
    
    /* Mejorar apariencia de badges de rol */
    .badge-info {
        background-color: #17a2b8;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
</style>
@endsection


{{-- SCRIPTS --}}
@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {

    // Inicializar DataTables con configuración es-MX
    let table = $('#usersTable').DataTable({
        // Idioma español México
        language: { 
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json" 
        },
        responsive: true,
        autoWidth: false,
        // Ordenar por fecha de registro (columna 5) descendente
        order: [[5, "desc"]],
        // Opciones de paginación
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        pageLength: 25,
        // Desactivar búsqueda global (usamos la personalizada)
        searching: true,
        dom: 'lrtip' // Sin caja de búsqueda default
    });

    // BUSCADOR PERSONALIZADO POR EMAIL (columna 1)
    $('#searchEmail').on('keyup', function () {
        table.column(1).search(this.value).draw();
    });

    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection

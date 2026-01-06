@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-users-cog"></i> Administración de Usuarios (Supabase)
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Usuarios Supabase</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="container-fluid">

    {{-- CARD PRINCIPAL --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-table"></i> Listado de Usuarios Registrados (Auth + Public)</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 230px;">
                    <input type="text" id="searchEmail" class="form-control float-right"
                        placeholder="Buscar email...">

                    <div class="input-group-append">
                        <button class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table id="usersTable" class="table table-hover text-nowrap">
                <thead class="bg-light">
                    <tr>
                        <th>UUID</th>
                        <th>Email</th>
                        <th>Nombre</th>
                        <th>Almacén</th>
                        <th>Rol</th>
                        <th>Fecha Registro</th>
             
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $u)
                        @php
                            $last = $u['last_signin'];
                            $lastColor = !$last ? 'badge-danger' :
                                (\Carbon\Carbon::parse($last)->isToday() ? 'badge-success' : 'badge-secondary');
                        @endphp

                        <tr>
                            <td>
                                <span class="badge badge-pill badge-light text-monospace">
                                    {{ substr($u['auth_id'], 0, 8) }}…
                                </span>
                            </td>

                            <td class="text-primary font-weight-bold">
                                <i class="fas fa-envelope"></i> {{ $u['email'] }}
                            </td>

                            <td>{{ $u['public']['name'] ?? '—' }}</td>

                            <td>
                                @if(isset($u['public']['almcnt']))
                                    <span class="badge badge-secondary">
                                        {{ $u['public']['almcnt'] }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                <span class="badge badge-info">
                                    {{ $u['public']['role'] ?? '—' }}
                                </span>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($u['created_at'])->format('Y-m-d H:i') }}</td>

                      
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <div class="float-right">
                <small class="text-muted">
                    Total usuarios: {{ count($users) }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection


{{-- ESTILOS --}}
@section('styles')
<link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    table td { vertical-align: middle !important; }
    .badge-pill { font-size: .85rem; }
</style>
@endsection


{{-- SCRIPTS --}}
@section('scripts')

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {

    let table = $('#usersTable').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json" },
        responsive: true,
        autoWidth: false,
        order: [[5, "desc"]],  // Ordenar por fecha registro
        lengthMenu: [10, 25, 50, 100],
        pageLength: 25
    });

    // BUSCADOR AL ESTILO ADMINLTE
    $('#searchEmail').on('keyup', function () {
        table.column(1).search(this.value).draw();
    });
});
</script>

@endsection

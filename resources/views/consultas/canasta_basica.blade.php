@extends('layouts.admin')

@section('title', 'Canasta Básica')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-shopping-cart"></i> Monitoreo de Abasto de Canasta Básica</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Seguimiento del surtimiento de productos por tienda</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')

<style>
.table-responsive {
    overflow-y: auto;
    position: relative;
}

th {
    position: sticky;
    top: 0;
    z-index: 2;
    background-color: #343a40;
    color: #fff;
}

</style>

<div class="row">

    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title">Canasta Básica</h5>
            </div>
            <div class="card-body">            
				
				<!--Formulario-->
				<form method="POST" action="{{ route('consultas.filtrar') }}" id="filter-form">
				@csrf
				<div class="row">
					<!-- Mes -->
					<div class="col-md-4 mb-3">
						<label for="mes">Mes:</label>
						<select id="mes" name="mes" class="form-control">
							@for ($i = 1; $i <= 12; $i++)
								<option value="{{ $i }}" {{ old('mes', date('n')) == $i ? 'selected' : '' }}>
									{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
								</option>
							@endfor
						</select>
					</div>

					<!-- Año -->
					<div class="col-md-4 mb-3">
						<label for="year">Año:</label>
						<select id="year" name="year" class="form-control">
							@php
								$currentYear = date('Y');
								$previousYear = $currentYear - 1;
							@endphp
							<option value="{{ $currentYear }}" {{ old('year', $year ?? '') == $currentYear ? 'selected' : '' }}>{{ $currentYear }}</option>
							<option value="{{ $previousYear }}" {{ old('year', $year ?? '') == $previousYear ? 'selected' : '' }}>{{ $previousYear }}</option>
						</select>
					</div>
					<!-- Botón Filtrar -->
					<div class="col-md-4 mb-3">
                        <label for="filter-button">&nbsp;</label>
						<button type="submit" id="filter-button" class="btn btn-primary btn-block">						
							<i class="fas fa-filter"></i> Filtrar
						</button>
					</div>
				</div>
				<input type="hidden" name="filtrar" value="1">
			</form>

				<div class="table-responsive">
					<div style="overflow-x: auto; max-height: 500px; position: relative;">
					
						<table class="table table-bordered table-sm table-striped table-hover text-nowrap">
							<thead class="thead-dark">
								<tr>
									<th>Cancve</th>
									<th>Ctecve</th>
									<th>Localidad</th>
									<th>Maiz</th>
									<th>Frijol</th>
									<th>Arroz</th>
									<th>Azucar</th>
									<th>Aceite</th>
									<th>Leche</th>
									<th>HnaTrig</th>
									<th>HnaMaiz</th>
									<th>Sal</th>
									<th>Cafe</th>
									<th>Galletas</th>
									<th>Pastas</th>
									<th>AtunySard</th>
									<th>Chiles</th>
									<th>Detergentes</th>
									<th>JabLav</th>
									<th>BlanqYSuav</th>
									<th>LimpLqPvo</th>
									<th>PapelHig</th>
									<th>Servilletas</th>
									<th>ToallasFem</th>
									<th>JabToc</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($articulos) && count($articulos) > 0)
								@foreach($articulos as $row)
								<tr>
									<td>{{ $row->cancve }}</td>
									<td>{{ $row->ctecve }}</td>
									
									<td>{{ mb_convert_encoding($row->locnom, 'UTF-8', 'UTF-8') }}</td>
									<td class="text-right" style="{{ $row->maiz == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->maiz }}</td>
									<td class="text-right" style="{{ $row->frijol == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->frijol }}</td>
									<td class="text-right" style="{{ $row->arroz == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->arroz }}</td>
									<td class="text-right" style="{{ $row->azucar == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->azucar }}</td>
									<td class="text-right" style="{{ $row->aceite == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->aceite }}</td>
									<td class="text-right" style="{{ $row->leche == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->leche }}</td>
									<td class="text-right" style="{{ $row->hnatrig == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->hnatrig }}</td>
									<td class="text-right" style="{{ $row->hnamaiz == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->hnamaiz }}</td>
									<td class="text-right" style="{{ $row->sal == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->sal }}</td>
									<td class="text-right" style="{{ $row->cafe == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->cafe }}</td>
									<td class="text-right" style="{{ $row->galletas == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->galletas }}</td>
									<td class="text-right" style="{{ $row->pastas == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->pastas }}</td>
									<td class="text-right" style="{{ $row->atunysard == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->atunysard }}</td>
									<td class="text-right" style="{{ $row->chiles == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->chiles }}</td>
									<td class="text-right" style="{{ $row->detergentes == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->detergentes }}</td>
									<td class="text-right" style="{{ $row->jablav == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->jablav }}</td>
									<td class="text-right" style="{{ $row->blanqysuav == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->blanqysuav }}</td>
									<td class="text-right" style="{{ $row->limplqpvo == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->limplqpvo }}</td>
									<td class="text-right" style="{{ $row->papelhig == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->papelhig }}</td>
									<td class="text-right" style="{{ $row->servilletas == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->servilletas }}</td>
									<td class="text-right" style="{{ $row->toallasfem == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->toallasfem }}</td>
									<td class="text-right" style="{{ $row->jabtoc == 0 ? 'background-color: #ddc9a3;' : '' }}">{{ $row->jabtoc }}</td>
								</tr>
								@endforeach
								@else
									<tr>
										<td colspan="25" class="text-center text-muted"> No hay datos para mostrar  </td>
									</tr>
								@endif
							</tbody>
						</table>
												
					</div>
					
					@if(!empty($articulos))
					<div class="row mt-3">
						<div class="col-md-4">
							<button id="export-button" class="btn btn-success btn-block">
								<i class="fas fa-file-excel"></i> Exportar a Excel
							</button>
						</div>
					</div>
					@endif
				</div>

						  
            </div>
        </div>
    </div>
</div>  

<!-- Modal -->
<div class="modal fade" id="cafeModal" tabindex="-1" aria-labelledby="cafeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cafeModalLabel">Detalles de Café</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="cafeTable">
                    <thead>
                        <tr>
							<th>Almacen</th>
                            <th>Clave</th>
                            <th>Descripción</th>
                            <th>DI</th>
                            <th>PDM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargarán aquí vía Ajax -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@stop


@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const filterForm = document.getElementById("filter-form");
			const filterButton = document.getElementById("filter-button");

			filterForm.addEventListener("submit", function () {
				filterButton.disabled = true; // Desactivar el botón
				filterButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...'; // Cambiar texto del botón
			});
		});
			

        // Manejar exportación a Excel
        const exportButton = document.getElementById('export-button');
        if (exportButton) {
            exportButton.addEventListener('click', function () {
                const table = document.querySelector('.table-responsive table');
                if (!table) return;

                const host = 'almacen';
                const workbook = XLSX.utils.table_to_book(table, { sheet: host });
                XLSX.writeFile(workbook, `Canasta_Basica_${host}.xlsx`);
            });
        }
	</script>
@stop

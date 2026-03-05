@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-chart-line text-primary"></i> Reportes
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="breadcrumb-item active">Reportes</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- HEADER CON DESCRIPCIÓN --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="callout callout-info">
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-file-alt fa-2x text-info"></i>
                </div>
                <div>
                    <h5 class="mb-1">Reportes Diarios</h5>
                    <p class="mb-0 text-muted">
                        Genera y descarga catálogos en formato PDF o Excel para tu operación diaria.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- CARD 1: CATÁLOGO DIGITAL PDF --}}
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card card-widget widget-user-2 shadow-sm h-100">
            {{-- Header con gradiente --}}
            <div class="widget-user-header bg-gradient-primary">
                <div class="d-flex align-items-center">
                    <div class="widget-user-image mr-3">
                        <i class="fas fa-file-pdf fa-3x text-white-50"></i>
                    </div>
                    <div>
                        <h3 class="widget-user-username mb-0 text-white">
                            Catálogo Digital
                        </h3>
                        <h5 class="widget-user-desc text-white-50">
                            <i class="fas fa-images"></i> Con imágenes de productos
                        </h5>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="post" action="{{ route('catalogo.pdf') }}" target="_pdf" id="formCatalogoPdf">
                    @csrf

                    {{-- Vista previa del catálogo --}}
                    <div class="text-center mb-4">
                        <div class="preview-container">
                            <img src="{{ asset('admin/dist/img/fondocatalogo.png') }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 alt="Vista previa del catálogo"
                                 style="max-height: 140px; border: 3px solid #e9ecef;">
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> 
                            El catálogo incluye fotos de cada producto
                        </small>
                    </div>

                    {{-- Opciones del formulario --}}
                    <div class="options-container">
                        
                        {{-- Opción: Precio de venta --}}
                        <div class="form-group">
                            <label for="artprventa" class="font-weight-bold">
                                <i class="fas fa-dollar-sign text-success"></i> 
                                Precio de Venta
                            </label>
                            <select class="form-control custom-select" name="artprventa" id="artprventa">
                                <option value="NO">
                                    🚫 SIN MOSTRAR PRECIO DE VENTA
                                </option>
                                <option value="SI">
                                    💰 INCLUIR PRECIO DE VENTA
                                </option>
                            </select>
                            <small class="form-text text-muted">
                                Elige si deseas mostrar los precios en el catálogo
                            </small>
                        </div>

                        {{-- Opción: Tipo de inventario --}}
                        <div class="form-group">
                            <label for="artseccion" class="font-weight-bold">
                                <i class="fas fa-boxes text-warning"></i> 
                                Tipo de Inventario
                            </label>
                            <select class="form-control custom-select" name="artseccion" id="artseccion">
                                @foreach ($tiposInventarios as $tipoinv)
                                    <option value="{{ $tipoinv }}">
                                        📦 TIPO DE INVENTARIO: {{ $tipoinv }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Selecciona la sección de inventario a exportar
                            </small>
                        </div>
                    </div>

                    {{-- Botón de acción --}}
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block btn-generate">
                            <i class="fas fa-file-download mr-2"></i>
                            Generar Catálogo PDF
                        </button>
                    </div>
                </form>
            </div>

            {{-- Footer informativo --}}
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> Tiempo estimado: 10-30 seg
                    </small>
                    <span class="badge badge-primary">
                        <i class="fas fa-file-pdf"></i> PDF
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 2: CATÁLOGO DE SUPERVISORES EXCEL --}}
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card card-widget widget-user-2 shadow-sm h-100">
            {{-- Header con gradiente --}}
            <div class="widget-user-header bg-gradient-success">
                <div class="d-flex align-items-center">
                    <div class="widget-user-image mr-3">
                        <i class="fas fa-file-excel fa-3x text-white-50"></i>
                    </div>
                    <div>
                        <h3 class="widget-user-username mb-0 text-white">
                            Catálogo de Supervisores
                        </h3>
                        <h5 class="widget-user-desc text-white-50">
                            <i class="fas fa-table"></i> Formato Excel editable
                        </h5>
                    </div>
                </div>
            </div>

            <div class="card-body d-flex flex-column">
                
                {{-- Vista previa --}}
                <div class="text-center mb-4 flex-grow-1">
                    <div class="preview-container">
                        <img src="{{ asset('admin/dist/img/excel.jpg') }}" 
                             class="img-fluid rounded shadow-sm" 
                             alt="Vista previa Excel"
                             style="max-height: 180px; border: 3px solid #e9ecef;">
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="info-box bg-light mb-4">
                    <span class="info-box-icon bg-success">
                        <i class="fas fa-clipboard-list"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Incluye</span>
                        <span class="info-box-number text-muted" style="font-size: 0.9rem;">
                            Posición de almacén, códigos y existencias
                        </span>
                    </div>
                </div>

                {{-- Características --}}
                <ul class="list-unstyled mb-4">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success"></i>
                        Datos actualizados al momento
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success"></i>
                        Compatible con Microsoft Excel
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success"></i>
                        Ideal para supervisión de inventario
                    </li>
                </ul>

                {{-- Botón de descarga --}}
                <div class="mt-auto">
                    <a href="{{ route('posicion.almacen') }}" class="btn btn-success btn-lg btn-block btn-generate">
                        <i class="fas fa-download mr-2"></i>
                        Descargar Archivo Excel
                    </a>
                </div>
            </div>

            {{-- Footer informativo --}}
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-bolt"></i> Descarga instantánea
                    </small>
                    <span class="badge badge-success">
                        <i class="fas fa-file-excel"></i> XLSX
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- SECCIÓN DE AYUDA --}}
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-secondary collapsed-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-question-circle"></i> ¿Necesitas ayuda?
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-file-pdf text-danger"></i> Catálogo PDF</h6>
                        <ul class="text-muted">
                            <li>Incluye imágenes de todos los productos</li>
                            <li>Puedes elegir mostrar u ocultar precios</li>
                            <li>Se abre en una nueva pestaña del navegador</li>
                            <li>Ideal para impresión o envío por correo</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-file-excel text-success"></i> Archivo Excel</h6>
                        <ul class="text-muted">
                            <li>Exporta datos en formato editable</li>
                            <li>Incluye posiciones de almacén</li>
                            <li>Puedes filtrar y ordenar datos</li>
                            <li>Útil para control de inventario</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    /* === ESTILOS GENERALES === */
    .card-widget {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card-widget:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    /* === HEADERS CON GRADIENTE === */
    .widget-user-header {
        padding: 1.5rem;
        border-radius: 0.25rem 0.25rem 0 0;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    }

    /* === CONTENEDOR DE VISTA PREVIA === */
    .preview-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-radius: 0.5rem;
        display: inline-block;
    }
    
    .preview-container img {
        transition: transform 0.3s ease;
    }
    
    .preview-container:hover img {
        transform: scale(1.05);
    }

    /* === FORMULARIOS === */
    .custom-select {
        border: 2px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    
    .custom-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
    }
    
    .form-group label {
        color: #495057;
        margin-bottom: 0.5rem;
    }

    /* === BOTONES === */
    .btn-generate {
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-generate:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .btn-generate:active {
        transform: translateY(0);
    }
    
    .btn-primary.btn-generate {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
    }
    
    .btn-success.btn-generate {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        border: none;
    }

    /* === INFO BOX === */
    .info-box {
        border-radius: 0.5rem;
        box-shadow: none;
        border: 1px solid #e9ecef;
    }

    /* === CALLOUT === */
    .callout-info {
        border-left-color: #17a2b8;
        background: linear-gradient(135deg, #e8f4f8 0%, #d1ecf1 100%);
        border-radius: 0.5rem;
    }

    /* === FOOTER DE CARDS === */
    .card-footer {
        border-top: 1px solid #e9ecef;
    }

    /* === ANIMACIONES === */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    .btn-generate:focus {
        animation: pulse 0.5s ease;
    }

    /* === RESPONSIVE === */
    @media (max-width: 991px) {
        .widget-user-header {
            text-align: center;
        }
        
        .widget-user-header .d-flex {
            flex-direction: column;
        }
        
        .widget-user-header .widget-user-image {
            margin-bottom: 1rem;
            margin-right: 0 !important;
        }
    }

    /* === LISTA DE CARACTERÍSTICAS === */
    .list-unstyled li {
        padding: 0.25rem 0;
    }
    
    .list-unstyled i {
        width: 20px;
    }
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Feedback visual al enviar formulario PDF
    $('#formCatalogoPdf').on('submit', function() {
        var btn = $(this).find('button[type="submit"]');
        var originalText = btn.html();
        
        btn.prop('disabled', true)
           .html('<i class="fas fa-spinner fa-spin mr-2"></i> Generando PDF...');
        
        // Restaurar después de 5 segundos (el PDF se abre en otra pestaña)
        setTimeout(function() {
            btn.prop('disabled', false).html(originalText);
        }, 5000);
    });

    // Efecto visual al cambiar selects
    $('#artprventa, #artseccion').on('change', function() {
        $(this).addClass('border-primary');
        setTimeout(() => {
            $(this).removeClass('border-primary');
        }, 500);
    });

    // Feedback al hacer clic en botón de Excel
    $('.btn-success.btn-generate').on('click', function() {
        var btn = $(this);
        var originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Preparando descarga...');
        
        setTimeout(function() {
            btn.html('<i class="fas fa-check mr-2"></i> ¡Descarga iniciada!');
            setTimeout(function() {
                btn.html(originalText);
            }, 2000);
        }, 1000);
    });
});
</script>
@endsection

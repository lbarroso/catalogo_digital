@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-print mr-2"></i> Cenefas
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Cenefas</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.cenefas-page-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border-radius: 8px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
}
.cenefas-page-header .page-title {
    color: #fff;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
}
.cenefas-page-header .page-subtitle {
    color: rgba(255,255,255,0.9);
    font-size: 0.9rem;
    margin: 0;
}
.cenefas-card {
    transition: box-shadow 0.2s ease;
}
.cenefas-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.cenefas-card .card-header {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}
.cenefas-card .card-header .card-title {
    font-weight: 600;
    font-size: 1rem;
}
.cenefas-card .card-header small {
    display: block;
    color: #6c757d;
    font-size: 0.8rem;
    margin-top: 2px;
}
.cenefas-preview-img {
    max-width: 100%;
    height: auto;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}
.input-group-text {
    background-color: #f8f9fa;
}
@media (max-width: 768px) {
    .cenefas-page-header { padding: 1rem; }
}
</style>
@endsection

@section('content')

<!-- Encabezado de página -->
<div class="cenefas-page-header d-flex flex-wrap align-items-center justify-content-between">
    <div>
        <h2 class="page-title">
            <i class="fas fa-file-pdf mr-2"></i> Imprimir Cenefas PDF
        </h2>
        <p class="page-subtitle mb-0">Genera PDFs por familia, inventario o por factura</p>
    </div>
    <span class="badge badge-light badge-pill px-3 py-2">
        <i class="fas fa-print mr-1"></i> Impresión
    </span>
</div>

<!-- Callout de ayuda -->
<div class="callout callout-info py-2 mb-3">
    <i class="fas fa-lightbulb mr-2"></i>
    <strong>Consejo:</strong> Genera primero en blanco si vas a escribir precios manualmente.
</div>

<div class="row">
    <!-- Card: Cenefas con precio (izquierda, más grande) -->
    <div class="col-lg-8 mb-4">
        <div class="card cenefas-card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title m-0">
                    <i class="fas fa-tags mr-2 text-primary"></i> Cenefas con precio
                </h5>
                <small>Selecciona familia e inventario para generar cenefas con precios incluidos</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img src="{{ asset('admin/dist/img/cenefa-blanco345x200.jpg') }}" class="cenefas-preview-img img-fluid" alt="Vista previa cenefa" width="220">
                    </div>
                    <div class="col-md-8">
                        <form method="post" action="{{ route('cenefas.precio.pdf') }}" target="_cenefas" class="form-cenefas-precio">
                            @csrf
                            <div class="form-group">
                                <label for="category_id">Familia</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-layer-group text-muted"></i></span>
                                    </div>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="0">Seleccionar Todas las Familias</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="form-text text-muted">Familia: selecciona una familia o todas.</small>
                            </div>

                            <div class="form-group">
                                <label for="artseccion">Inventario</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-warehouse text-muted"></i></span>
                                    </div>
                                    <select class="form-control" name="artseccion" id="artseccion">
                                        @foreach ($tiposInventarios as $tipoinv)
                                            <option value="{{ $tipoinv }}">Tipo de Inventario: {{ $tipoinv }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="form-text text-muted">Inventario: elige el tipo de inventario.</small>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary btn-lg btn-cenefas-precio">
                                    <i class="fas fa-file-pdf mr-2"></i> Generar Cenefas con Precio
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Cenefas en blanco (derecha, compacta) -->
    <div class="col-lg-4 mb-4">
        <div class="card cenefas-card card-outline card-secondary h-100">
            <div class="card-header">
                <h5 class="card-title m-0">
                    <i class="fas fa-file-alt mr-2 text-secondary"></i> Cenefas en blanco
                </h5>
                <small>Descarga cenefas sin precios para impresión manual</small>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <a href="{{ route('cenefa.blanco.pdf') }}" target="_cenefa" class="btn btn-outline-primary btn-block btn-lg btn-cenefa-blanco">
                    <i class="fas fa-download mr-2"></i> Descargar Cenefas en Blanco PDF
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Card: Generar cenefas por factura -->
<div class="row">
    <div class="col-12">
        <div class="card cenefas-card card-outline card-success">
            <div class="card-header">
                <h5 class="card-title m-0">
                    <i class="fas fa-receipt mr-2 text-success"></i> Generar cenefas de una factura
                </h5>
                <small>Ingresa orden y factura para generar cenefas específicas</small>
            </div>
            <div class="card-body">
                <form action="{{ route('cenefas.factura') }}" method="GET" target="_blank" class="form-cenefas-factura">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="docord">Número de Orden</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hashtag text-muted"></i></span>
                                </div>
                                <input type="text" class="form-control" id="docord" name="docord" placeholder="Ej: 1023">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="docnumdoc">Número de Factura</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-file-invoice text-muted"></i></span>
                                </div>
                                <input type="text" class="form-control" id="docnumdoc" name="docnumdoc" placeholder="Ej: A-5532">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-block btn-lg btn-cenefas-factura">
                                <i class="fas fa-print mr-2"></i> Generar cenefas de la factura
                            </button>
                        </div>
                    </div>
                    <small class="form-text text-muted mt-2">Ejemplo: Orden 1023 / Factura A-5532</small>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Loading state visual para formularios (solo UI, no afecta submit)
    var formPrecio = document.querySelector('.form-cenefas-precio');
    if (formPrecio) {
        formPrecio.addEventListener('submit', function() {
            var btn = formPrecio.querySelector('.btn-cenefas-precio');
            if (btn && !btn.disabled) {
                //btn.disabled = true;
                //btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generando...';
            }
        });
    }

    var linkBlanco = document.querySelector('.btn-cenefa-blanco');
    if (linkBlanco) {
        linkBlanco.addEventListener('click', function() {
            //linkBlanco.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Descargando...';
            //linkBlanco.classList.add('disabled');
        });
    }

    var formFactura = document.querySelector('.form-cenefas-factura');
    if (formFactura) {
        formFactura.addEventListener('submit', function() {
            var btn = formFactura.querySelector('.btn-cenefas-factura');
            if (btn && !btn.disabled) {
                //btn.disabled = true;
                //btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generando...';
            }
        });
    }
});
</script>
@endsection

@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Importar datos para actualizar {{ config('app.name', 'Laravel') }} </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Estilos para cards uniformes */
.card-hover {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

/* Headers de las cards con colores temáticos */
.card-header {
    border: none;
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--bg-color-start) 0%, var(--bg-color-end) 100%);
}

.bg-primary {
    --bg-color-start: #007bff;
    --bg-color-end: #0056b3;
}

.bg-info {
    --bg-color-start: #17a2b8;
    --bg-color-end: #117a8b;
}

.bg-success {
    --bg-color-start: #28a745;
    --bg-color-end: #1e7e34;
}

/* Iconos de las cards */
.card-icon i {
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

/* Contenedor de imágenes uniforme */
.card-img-container {
    height: 180px;
    overflow: hidden;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-img-uniform {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.card-hover:hover .card-img-uniform {
    transform: scale(1.05);
}

/* Cuerpo de las cards */
.card-body {
    padding: 1.5rem;
    min-height: 300px;
}

.card-text {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.5;
}

/* Badges de estado */
.info-badge, .status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.info-badge {
    background-color: #e3f2fd;
    color: #1976d2;
    border: 1px solid #bbdefb;
}

.status-ready {
    background-color: #e8f5e8;
    color: #2e7d32;
    border: 1px solid #c8e6c9;
}

.status-online {
    background-color: #e8f5e8;
    color: #2e7d32;
    border: 1px solid #c8e6c9;
}

/* Alertas personalizadas */
.alert-custom {
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 0.9rem;
    border-left: 4px solid #ffc107;
}

/* Botones mejorados */
.btn-lg {
    padding: 12px 20px;
    font-size: 1.1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-lg:disabled {
    transform: none;
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-lg i {
    transition: transform 0.3s ease;
}

.btn-lg:hover i:not(.fa-spin) {
    transform: scale(1.1);
}

/* Spinner animado */
.btn:disabled .fa-spinner {
    animation: spin 1s linear infinite, pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Grid responsive */
.d-grid {
    display: grid;
    gap: 0.75rem;
}

/* Responsive design */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
        min-height: auto;
    }
    
    .card-icon i {
        font-size: 2rem !important;
    }
    
    .card-img-container {
        height: 150px;
    }
    
    .btn-lg {
        padding: 10px 15px;
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .col-lg-4 {
        margin-bottom: 2rem;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .card-title {
        font-size: 1.1rem;
    }
}

/* Efecto de carga para los botones */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    border: 2px solid transparent;
    border-top: 2px solid #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Mejoras adicionales */
.card-title {
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.shadow-sm {
    box-shadow: 0 2px 4px rgba(0,0,0,0.08) !important;
}

/* Animación para las cards al cargar */
.card-hover {
    animation: slideInUp 0.6s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Delay para las animaciones */
.col-lg-4:nth-child(1) .card-hover { animation-delay: 0.1s; }
.col-lg-4:nth-child(2) .card-hover { animation-delay: 0.2s; }
.col-lg-4:nth-child(3) .card-hover { animation-delay: 0.3s; }
</style>
@endsection

@section('scripts')
<script src="{{ asset('admin/plugins/notify/notify.min.js') }}"></script>
<script>
// Funcionalidad para el botón de Importar Artículos
document.addEventListener('DOMContentLoaded', function() {
    // Botón Importar Artículos
    const btnImportArticles = document.getElementById('btnImportArticles');
    if (btnImportArticles) {
        btnImportArticles.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const btn = this;
            const spinner = document.getElementById('spinnerArticles');
            const txtBtn = document.getElementById('txtImportArticles');
            const originalText = txtBtn.textContent;

            // Confirmar acción
            const confirmed = confirm('¿Está seguro de que desea importar artículos desde SIAC?\n\nEste proceso puede tardar varios minutos y actualizará todo el catálogo.');
            
            if (!confirmed) return;

            // UI: activar spinner y deshabilitar botón
            spinner.classList.remove('d-none');
            btn.setAttribute('disabled', 'disabled');
            txtBtn.textContent = 'Importando...';

            // Mostrar notificación inicial
            if (typeof $.notify !== 'undefined') {
                $.notify(
                    '🔄 Iniciando importación de artículos desde SIAC...',
                    { className: 'info', autoHideDelay: 4000 }
                );
            }

            try {
                // Delay para mostrar notificación
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Redirigir a la ruta de importación
                window.location.href = "{{ route('import') }}";
                
            } catch (err) {
                console.error(err);
                if (typeof $.notify !== 'undefined') {
                    $.notify('❌ Error al iniciar la importación', { className: 'error' });
                }
                
                // Restaurar estado del botón
                spinner.classList.add('d-none');
                btn.removeAttribute('disabled');
                txtBtn.textContent = originalText;
            }
        });
    }

    // Botón Importar Imágenes
    const btnImportImages = document.getElementById('btnImportImages');
    if (btnImportImages) {
        btnImportImages.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const btn = this;
            const spinner = document.getElementById('spinnerImages');
            const txtBtn = document.getElementById('txtImportImages');
            const originalText = txtBtn.textContent;

            // Confirmar acción
            const confirmed = confirm('¿Está seguro de que desea importar el banco de imágenes?\n\n⚠️ IMPORTANTE: Este proceso solo puede ejecutarse UNA VEZ y puede tardar mucho tiempo.');
            
            if (!confirmed) return;

            // UI: activar spinner y deshabilitar botón
            spinner.classList.remove('d-none');
            btn.setAttribute('disabled', 'disabled');
            txtBtn.textContent = 'Importando imágenes...';

            // Mostrar notificación inicial
            if (typeof $.notify !== 'undefined') {
                $.notify(
                    '📸 Iniciando importación del banco de imágenes...',
                    { className: 'info', autoHideDelay: 4000 }
                );
            }

            try {
                // Delay para mostrar notificación
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Redirigir a la ruta de importación de imágenes
                window.location.href = "{{ route('duplicate') }}";
                
            } catch (err) {
                console.error(err);
                if (typeof $.notify !== 'undefined') {
                    $.notify('❌ Error al iniciar la importación de imágenes', { className: 'error' });
                }
                
                // Restaurar estado del botón
                spinner.classList.add('d-none');
                btn.removeAttribute('disabled');
                txtBtn.textContent = originalText;
            }
        });
    }

    // Agregar tooltips si Bootstrap está disponible
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Animación de entrada para las cards
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Efecto de hover mejorado para los botones
    const buttons = document.querySelectorAll('.btn-lg');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(-2px)';
            }
        });
        
        button.addEventListener('mouseleave', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(0)';
            }
        });
    });
});

// Función para mostrar notificaciones
function showNotification(message, type = 'info') {
    if (typeof $.notify !== 'undefined') {
        $.notify(message, { 
            className: type, 
            autoHideDelay: 5000,
            position: 'top right'
        });
    } else {
        // Fallback para navegadores sin notify
        alert(message);
    }
}

// Manejar errores de carga de imágenes
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.card-img-uniform');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE4MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlbiBubyBkaXNwb25pYmxlPC90ZXh0Pjwvc3ZnPg==';
            this.alt = 'Imagen no disponible';
        });
    });
});
</script>
@endsection

@section('content')


<div class="row">
  <!-- Card 1: Importar Artículos -->
  <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100 card-hover shadow-sm">
          <div class="card-header text-center bg-primary text-white">
              <div class="card-icon mb-2">
                  <i class="fas fa-download fa-3x"></i>
              </div>
              <h4 class="card-title mb-0">Importar Artículos</h4>
          </div>
          <div class="card-img-container">
              <img src="{{ asset('admin/dist/img/import.jpg') }}" class="card-img-uniform" alt="Importar Artículos">
          </div>
          <div class="card-body d-flex flex-column">
              <div class="mb-3">
                  <div class="info-badge mb-2">
                      <i class="fas fa-server me-1"></i>
                      IPv4: {{ Auth::user()->ip ?? 'No disponible' }}
                  </div>
              </div>
              
              <p class="card-text flex-grow-1">
                  Este paso puede realizarse las veces que sea necesario, asegura que todos los productos disponibles en el catálogo estén actualizados y reflejen la información más reciente, incluyendo nuevos artículos, precios y disponibilidad.
              </p>
              
              <div class="mt-auto">
                  <button id="btnImportArticles" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                      <i class="fas fa-download me-2"></i>
                      <span id="txtImportArticles">Importar desde SIAC</span>
                      <i id="spinnerArticles" class="fas fa-spinner fa-spin d-none ms-2"></i>
                  </button>
              </div>
          </div>
      </div>
  </div>

  <!-- Card 2: Importar Imágenes -->
  <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100 card-hover shadow-sm">
          <div class="card-header text-center bg-info text-white">
              <div class="card-icon mb-2">
                  <i class="fas fa-images fa-3x"></i>
              </div>
              <h4 class="card-title mb-0">Importar Imágenes</h4>
          </div>
          <div class="card-img-container">
              <img src="{{ asset('admin/dist/img/import-images.jpg') }}" class="card-img-uniform" alt="Importar Imágenes">
          </div>
          <div class="card-body d-flex flex-column">
              @if ($numRegistros > 0)
                  <div class="mb-3">
                      <div class="status-badge status-ready">
                          <i class="fas fa-check-circle me-1"></i>
                          Sistema listo para importar
                      </div>
                  </div>
              @endif
              
              <div class="alert alert-warning alert-custom mb-3">
                  <i class="fas fa-exclamation-triangle me-2"></i>
                  <strong>Importante:</strong> Este proceso solo puede ejecutarse una vez
              </div>
              
              <p class="card-text flex-grow-1">
                  Se importan imágenes de alta calidad para cada producto. Esto no solo mejora la presentación visual del catálogo, sino que también ayuda a los usuarios a identificar rápidamente los productos deseados.
              </p>
              
              <div class="mt-auto">
                  @if ($numRegistros > 0 && $empresa->regleyenda == null)
                      
                      <button id="btnImportImages" class="btn btn-info btn-lg w-100 d-flex align-items-center justify-content-center">
                          <i class="fas fa-file-import me-2"></i>
                          <span id="txtImportImages">Importar Banco de Imágenes</span>
                          <i id="spinnerImages" class="fas fa-spinner fa-spin d-none ms-2"></i>
                      </button>
                      
                  @else
                      <button class="btn btn-secondary btn-lg w-100" disabled>
                          <i class="fas fa-lock me-2"></i>
                          Requiere artículos importados
                      </button>
                  @endif
              </div>

          </div>
      </div>
  </div>

 

  <!-- Card 4: Eliminar productos e imágenes del almacén (solo usuarios autenticados) -->
  @auth
  <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100 card-hover shadow-sm">
          <div class="card-header text-center text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
              <div class="card-icon mb-2">
                  <i class="fas fa-trash-alt fa-3x"></i>
              </div>
              <h4 class="card-title mb-0">Limpiar almacén</h4>
          </div>
          <div class="card-img-container">
              <img src="{{ asset('admin/dist/img/import.jpg') }}" class="card-img-uniform" alt="Eliminar productos">
          </div>
          <div class="card-body d-flex flex-column">
              <div class="alert alert-warning alert-custom mb-3">
                  <i class="fas fa-exclamation-triangle me-2"></i>
                  <strong>Irreversible:</strong> Se eliminarán todos los productos y sus imágenes del almacén {{ Auth::user()->almcnt ?? 'actual' }}.
              </div>
              <p class="card-text flex-grow-1">
                  Use esta opción para vaciar el catálogo del almacén y volver a importar desde cero. No afecta a otros almacenes.
              </p>
              <!-- SI ALMACEN = 2038 NO MOSTRAR EL BOTON -->
              @if (Auth::user()->almcnt != 2039)    
                <div class="mt-auto">
                    <button type="button" class="btn btn-danger btn-lg w-100 d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalResetWarehouse">
                        <i class="fas fa-trash-alt me-2"></i>
                        Eliminar productos e imágenes del almacén
                    </button>
                </div>
              @endif
          </div>
      </div>
  </div>
  @endauth
</div>

<!-- Modal de confirmación: Eliminar productos e imágenes del almacén -->
@auth
<div class="modal fade" id="modalResetWarehouse" tabindex="-1" role="dialog" aria-labelledby="modalResetWarehouseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalResetWarehouseLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmar eliminación
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">
                    Se eliminarán <strong>todos los productos</strong> y sus imágenes asociadas del almacén <strong>{{ Auth::user()->almcnt ?? 'actual' }}</strong>. Esta acción no se puede deshacer.
                </p>
                <p class="text-muted small mt-2 mb-0">¿Desea continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form action="{{ route('products.resetCurrentWarehouse') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Eliminar todo
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth

@endsection

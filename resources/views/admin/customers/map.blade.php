@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-map-marked-alt mr-2"></i> Mapa de Clientes</h1>
            <small class="text-muted">Almacén: <strong>{{ $almcnt }}</strong></small>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Clientes</a></li>
                <li class="breadcrumb-item active">Mapa</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous" />
<style>
#map { height: 70vh; min-height: 400px; border-radius: 8px; }
.customer-map-controls { background: #fff; border-radius: 8px; padding: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1rem; }
.customer-map-controls .form-group { margin-bottom: 0.5rem; }
.points-counter { font-size: 0.9rem; color: #6c757d; }
.leaflet-popup-content-wrapper { border-radius: 8px; }
.leaflet-popup-content { margin: 12px 16px; min-width: 180px; }

/* Etiqueta CTECVE con paleta institucional (#611232) */
.ctecve-tooltip{
  background: rgba(97, 18, 50, 0.92);   /* #611232 con leve transparencia */
  color: #fff;
  border: 1px solid rgba(255,255,255,.25);
  border-radius: 8px;
  padding: 3px 8px;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: .2px;
  box-shadow: 0 2px 8px rgba(0,0,0,.18);
}

/* Quita el borde/estilo default de Leaflet */
.ctecve-tooltip.leaflet-tooltip{
  border: 0;
}

/* Flecha del tooltip en el mismo tono */
.leaflet-tooltip-top.ctecve-tooltip:before{
  border-top-color: rgba(97, 18, 50, 0.92);
}
.leaflet-tooltip-bottom.ctecve-tooltip:before{
  border-bottom-color: rgba(97, 18, 50, 0.92);
}
.leaflet-tooltip-left.ctecve-tooltip:before{
  border-left-color: rgba(97, 18, 50, 0.92);
}
.leaflet-tooltip-right.ctecve-tooltip:before{
  border-right-color: rgba(97, 18, 50, 0.92);
}
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="customer-map-controls">
                <div class="row">
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <label class="small text-muted mb-1">Vista del mapa</label>
                        <div class="btn-group btn-group-sm d-flex" role="group">
                            <button type="button" class="btn btn-outline-primary active" id="btnLayerMap" data-layer="osm">Mapa</button>
                            <button type="button" class="btn btn-outline-primary" id="btnLayerSatellite" data-layer="satellite">Satelital</button>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 mb-2 mb-md-0">
                        <label class="small text-muted mb-1">Color de puntos</label>
                        <select class="form-control form-control-sm" id="selectPointColor">
                            <option value="#007bff">Azul</option>
                            <option value="#28a745">Verde</option>
                            <option value="#dc3545">Rojo</option>
                            <option value="#fd7e14">Naranja</option>
                            <option value="#6f42c1">Morado</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 mb-2 mb-md-0 d-flex align-items-end">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="switchColorByCanal">
                            <label class="custom-control-label small" for="switchColorByCanal">Colorear por canal</label>
                        </div>
                    </div>
                    <div class="col-md-2 col-12 d-flex align-items-end flex-wrap gap-1">
                        <button type="button" class="btn btn-sm btn-secondary" id="btnFitBounds" title="Ajustar vista a todos los puntos">
                            <i class="fas fa-expand-arrows-alt"></i> Ajustar vista
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4 col-12">
                        <label class="small text-muted mb-1">Buscar (CTECVE / Localidad)</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="searchPoints" placeholder="Ej: 1234 o nombre localidad">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="btnClearSearch" title="Limpiar"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 d-flex align-items-end">
                        <span class="points-counter" id="pointsCounter">Puntos cargados: 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <script type="application/json" id="map-points-data">{!! json_encode($points, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) !!}</script>
            <div id="map"></div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>
<script>
(function() {
    var dataEl = document.getElementById('map-points-data');
    var rawPoints = dataEl ? JSON.parse(dataEl.textContent) : [];
    var points = rawPoints.map(function(p) {
        var lat = parseFloat(p.latitud);
        var lng = parseFloat(p.longitud);
        if (isNaN(lat) || isNaN(lng)) return null;
        return {
            ctecve: p.ctecve,
            canal: p.canal != null ? parseInt(p.canal, 10) : null,
            localidad: p.localidad || '',
            encargado: p.encargado || '',
            telefono: p.telefono || '',
            lat: lat,
            lng: lng
        };
    }).filter(Boolean);

    var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });
    var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri'
    });

    var map = L.map('map', { layers: [osmLayer] }).setView([23.6, -102.5], 5);
    var markersLayer = L.layerGroup().addTo(map);

    var currentColor = '#007bff';
    var colorByCanal = false;

    function getColorForPoint(p) {
        if (colorByCanal && p.canal !== null && p.canal !== undefined) {
            if (p.canal === 57) return '#28a745';
            if (p.canal === 54) return '#fd7e14';
            return '#007bff';
        }
        return currentColor;
    }

    function createDivIcon(p) {
        var color = getColorForPoint(p);
        return L.divIcon({
            className: 'customer-marker',
            html: '<div style="width:14px;height:14px;border-radius:50%;background:' + color + ';border:2px solid #fff;box-shadow:0 1px 3px rgba(0,0,0,0.3);"></div>',
            iconSize: [14, 14],
            iconAnchor: [7, 7]
        });
    }

    function buildPopupContent(p) {
        return '<div class="small">' +
            '<strong>' + (p.localidad || '—') + '</strong><br>' +
            'CTECVE: ' + (p.ctecve != null ? p.ctecve : '—') + '<br>' +
            'Canal: ' + (p.canal != null ? p.canal : '—') + '<br>' +
            'Encargado: ' + (p.encargado || '—') + '<br>' +
            'Teléfono: ' + (p.telefono || '—') + '<br>' +
            'Coordenadas: ' + p.lat.toFixed(6) + ', ' + p.lng.toFixed(6) + '</div>';
    }

    function renderMarkers(data) {
        markersLayer.clearLayers();
        data.forEach(function(p) {
         var marker = L.marker([p.lat, p.lng], { icon: createDivIcon(p) });
            marker.bindPopup(buildPopupContent(p));

            // 👇 etiqueta visible siempre con ctecve
            marker.bindTooltip(String(p.ctecve ?? ''), {
            permanent: true,
            direction: 'top',
            offset: [0, -10],
            opacity: 0.9,
            className: 'ctecve-tooltip'
            });

            markersLayer.addLayer(marker);
        });
        document.getElementById('pointsCounter').textContent = 'Puntos cargados: ' + data.length;
    }

    function getFilteredPoints() {
        var q = (document.getElementById('searchPoints').value || '').trim().toLowerCase();
        if (!q) return points;
        return points.filter(function(p) {
            var ctecve = String(p.ctecve || '').toLowerCase();
            var localidad = (p.localidad || '').toLowerCase();
            return ctecve.indexOf(q) !== -1 || localidad.indexOf(q) !== -1;
        });
    }

    function applyFiltersAndRender() {
        var filtered = getFilteredPoints();
        renderMarkers(filtered);
        if (filtered.length > 0) {
            var bounds = L.latLngBounds(filtered.map(function(p) { return [p.lat, p.lng]; }));
            map.fitBounds(bounds, { padding: [30, 30], maxZoom: 15 });
        }
    }

    renderMarkers(points);
    if (points.length > 0) {
        var bounds = L.latLngBounds(points.map(function(p) { return [p.lat, p.lng]; }));
        map.fitBounds(bounds, { padding: [30, 30], maxZoom: 15 });
    }

    document.getElementById('btnLayerMap').addEventListener('click', function() {
        map.removeLayer(satelliteLayer);
        map.addLayer(osmLayer);
        this.classList.add('active');
        document.getElementById('btnLayerSatellite').classList.remove('active');
    });
    document.getElementById('btnLayerSatellite').addEventListener('click', function() {
        map.removeLayer(osmLayer);
        map.addLayer(satelliteLayer);
        this.classList.add('active');
        document.getElementById('btnLayerMap').classList.remove('active');
    });

    document.getElementById('selectPointColor').addEventListener('change', function() {
        currentColor = this.value;
        renderMarkers(getFilteredPoints());
    });

    document.getElementById('switchColorByCanal').addEventListener('change', function() {
        colorByCanal = this.checked;
        renderMarkers(getFilteredPoints());
    });

    document.getElementById('btnFitBounds').addEventListener('click', function() {
        var filtered = getFilteredPoints();
        if (filtered.length === 0) return;
        var bounds = L.latLngBounds(filtered.map(function(p) { return [p.lat, p.lng]; }));
        map.fitBounds(bounds, { padding: [30, 30], maxZoom: 15 });
    });

    document.getElementById('searchPoints').addEventListener('input', function() {
        var filtered = getFilteredPoints();
        renderMarkers(filtered);
    });
    document.getElementById('searchPoints').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            var filtered = getFilteredPoints();
            if (filtered.length > 0) {
                map.fitBounds(L.latLngBounds(filtered.map(function(p) { return [p.lat, p.lng]; })), { padding: [30, 30], maxZoom: 15 });
            }
        }
    });
    document.getElementById('btnClearSearch').addEventListener('click', function() {
        document.getElementById('searchPoints').value = '';
        renderMarkers(points);
        if (points.length > 0) {
            map.fitBounds(L.latLngBounds(points.map(function(p) { return [p.lat, p.lng]; })), { padding: [30, 30], maxZoom: 15 });
        }
    });
})();
</script>
@endsection

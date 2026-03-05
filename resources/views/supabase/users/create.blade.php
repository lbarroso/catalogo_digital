{{-- 
    Vista para crear nuevos usuarios en Supabase (Auth + public.users)
    Catálogo Digital / Pedidos Offline
--}}
@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-user-plus"></i> Agregar Nuevo Usuario
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('supabase.users.index') }}">Usuarios Supabase</a></li>
                <li class="breadcrumb-item active">Nuevo</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

            {{-- CARD PRINCIPAL DEL FORMULARIO --}}
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-id-card"></i> Datos del Nuevo Usuario (Supabase)
                    </h3>
                </div>

                <form action="{{ route('supabase.users.store') }}" method="POST" id="formCreateUser">
                    @csrf

                    <div class="card-body">

                        {{-- MENSAJE DE ÉXITO --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-check-circle"></i>
                                <strong>¡Éxito!</strong> {{ session('success') }}
                            </div>
                        @endif

                        {{-- ERRORES DE VALIDACIÓN --}}
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h5><i class="fas fa-exclamation-triangle"></i> Error</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- INFORMACIÓN DEL FLUJO --}}
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info-circle"></i> ¿Qué hace este formulario?</h5>
                            <p class="mb-0">
                                Al crear un usuario, se realizan <strong>dos operaciones</strong> en Supabase:
                            </p>
                            <ol class="mb-0 mt-2">
                                <li>Crea el usuario en <code>auth.users</code> (email + contraseña)</li>
                                <li>Inserta el registro en <code>public.users</code> (almacén, nombre, rol, FK)</li>
                            </ol>
                        </div>

                        <hr>

                        {{-- SECCIÓN: CREDENCIALES --}}
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-key"></i> Credenciales de Acceso
                        </h5>

                        <div class="row">
                            {{-- EMAIL --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope"></i> Correo Electrónico
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="usuario@ejemplo.com"
                                           value="{{ old('email') }}" 
                                           required>
                                    <small class="text-muted">
                                        Este será el email para iniciar sesión en la app móvil.
                                    </small>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- PASSWORD --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">
                                        <i class="fas fa-lock"></i> Contraseña
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="password" 
                                               id="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Mínimo 8 caracteres"
                                               minlength="8"
                                               required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" 
                                                    onclick="togglePassword('password', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- PASSWORD CONFIRMATION --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">
                                        <i class="fas fa-lock"></i> Confirmar Contraseña
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation" 
                                               class="form-control" 
                                               placeholder="Repetir contraseña"
                                               minlength="8"
                                               required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" 
                                                    onclick="togglePassword('password_confirmation', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- SECCIÓN: DATOS DE PERFIL --}}
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-user"></i> Datos del Perfil
                        </h5>

                        <div class="row">
                            {{-- NOMBRE --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-id-badge"></i> Nombre Completo
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Nombre del usuario"
                                           value="{{ old('name') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- ALMACÉN --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="almcnt">
                                        <i class="fas fa-warehouse"></i> Número de Almacén
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           name="almcnt" 
                                           id="almcnt" 
                                           class="form-control @error('almcnt') is-invalid @enderror" 
                                           placeholder="Ej: 1, 2, 3..."
                                           value="{{ old('almcnt') }}" 
                                           min="1"
                                           required>
                                    <small class="text-muted">
                                        Identificador del almacén/tienda asignado.
                                    </small>
                                    @error('almcnt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- ROL --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">
                                        <i class="fas fa-user-tag"></i> Rol del Usuario
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="role" 
                                            id="role" 
                                            class="form-control @error('role') is-invalid @enderror"
                                            required>
                                        <option value="">-- Seleccionar rol --</option>
                                        <option value="0" {{ old('role') === '0' ? 'selected' : '' }}>
                                            👤 Encargado de Tienda
                                        </option>
                                        <option value="1" {{ old('role') === '1' ? 'selected' : '' }}>
                                            👔 Supervisor
                                        </option>
                                    </select>
                                    <small class="text-muted">
                                        <strong>0</strong> = Encargado de tienda | 
                                        <strong>1</strong> = Supervisor
                                    </small>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- FOOTER CON BOTONES --}}
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit">
                            <i class="fas fa-save"></i> Crear Usuario
                        </button>
                        <a href="{{ route('supabase.users.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                    </div>
                </form>
            </div>

            {{-- CARD DE AYUDA --}}
            <div class="card card-outline card-secondary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-question-circle"></i> Ayuda y Notas
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>La contraseña debe tener <strong>mínimo 8 caracteres</strong>.</li>
                        <li>El email debe ser <strong>único</strong> (no puede existir otro usuario con el mismo email en Supabase).</li>
                        <li>Si ocurre un error al insertar en <code>public.users</code>, el usuario de <code>auth.users</code> será eliminado automáticamente (rollback).</li>
                        <li>El usuario podrá iniciar sesión inmediatamente después de ser creado.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Mejoras visuales para el formulario */
    .card-outline.card-primary {
        border-top: 3px solid #007bff;
    }
    
    .callout-info {
        border-left-color: #17a2b8;
        background-color: #e8f4f8;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    
    .input-group-append .btn {
        border-color: #ced4da;
    }
    
    /* Indicador de campo requerido */
    label .text-danger {
        font-weight: bold;
    }
    
    /* Mejorar apariencia del select */
    select.form-control {
        cursor: pointer;
    }
</style>
@endsection

@section('scripts')
<script>
/**
 * Alternar visibilidad de contraseña
 * @param {string} inputId - ID del input de password
 * @param {HTMLElement} btn - Botón que dispara la acción
 */
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Validación en tiempo real de confirmación de contraseña
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmation = this.value;
    
    if (confirmation && password !== confirmation) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});

// Prevenir doble envío del formulario
document.getElementById('formCreateUser').addEventListener('submit', function() {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando usuario...';
});
</script>
@endsection

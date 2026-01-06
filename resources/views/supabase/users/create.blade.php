@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-shopping-cart"></i> Administracion usuarios</h1>
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
<div class="container mt-4">

    <h2 class="mb-4">Crear Nuevo Usuario (Supabase)</h2>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errores --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('supabase.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Almacén (almcnt)</label>
            <input type="number" name="almcnt" class="form-control" value="{{ old('almcnt') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label>
            <input type="number" name="role" class="form-control" value="{{ old('role') }}" required>
            {{-- Puedes reemplazar por un <select> si manejas roles específicos --}}
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary">
            Crear Usuario
        </button>
    </form>

</div>
@endsection

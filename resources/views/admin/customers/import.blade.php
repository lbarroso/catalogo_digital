@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-excel"></i> Importar Clientes (Excel)</h3>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('customers.import.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Archivo Excel (formato heredado)</label>
                    <input type="file" name="file" class="form-control" required>
                    <small class="text-muted">
                        Nota: el sistema leerá datos desde la fila 7 (encabezados en la fila 6).
                    </small>
                </div>

                <button class="btn btn-primary">
                    <i class="fas fa-upload"></i> Importar
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
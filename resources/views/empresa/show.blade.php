@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Información de empresa </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Empresas </li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title"> Informacón de empresa</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('empresas.index') }}"> regresar atrás </a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            Nombre de empresa:
                            {{ $empresa->regnom }}
                        </div>
                        <div class="form-group">
                            Teléfono:
                            {{ $empresa->regtel }}
                        </div>
                        <div class="form-group">
                            Correo electrónico:
                            {{ $empresa->regemail }}
                        </div>
                        <div class="form-group">
                            Municipio:
                            {{ $empresa->regmun }}
                        </div>
                        <div class="form-group">
                            Localidad:
                            {{ $empresa->regloc }}
                        </div>
                        <div class="form-group">
                            Estado:
                            {{ $empresa->regedo }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Empresas </h1>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Información empresa o negocio
                            </span>

                             <div class="float-right">
                                <a href="{{ route('empresas.create') }}" class="btn btn-primary btn-md float-right"  data-placement="left">
                                  <i class="fa fa-plus"></i> Nueva empresa
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>Almcnt</th>                                        
										<th>Nombre </th>										
										<th>Correo electr&oacute;nico</th>
										<th>Unidad Operativa</th>
										<th>Direcci&oacute;n</th>
										<th>Sucursal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empresas as $empresa)
                                        <tr>
                                            <td>{{ $empresa->id }}</td>                                            
											<td>{{ $empresa->regnom }}</td>
										
											<td>{{ $empresa->regemail }}</td>
											<td>{{ $empresa->regmun }}</td>
											<td>{{ $empresa->regloc }}</td>
											<td>{{ $empresa->regedo }}</td>

                                            <td>
                                                <form action="{{ route('empresas.destroy',$empresa->id) }}" method="POST">
                                                    <a class="btn btn-md btn-primary " href="{{ route('empresas.show',$empresa->id) }}"><i class="fa fa-fw fa-eye"></i> ver </a>
                                                    <a class="btn btn-md btn-success" href="{{ route('empresas.edit',$empresa->id) }}"><i class="fa fa-fw fa-edit"></i> editar </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-md"><i class="fa fa-fw fa-trash"></i> eliminar </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $empresas->links() !!}
            </div>
        </div>
    </div>
@endsection

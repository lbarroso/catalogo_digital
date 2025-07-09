@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Novedades y ofertas</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Productos Nuevos</li>
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
                                Este m&oacute;dulo permite agregar productos para su difusi&oacute;n y promoci&oacute;n, productos que han bajado de precio, o nuevos art&iacute;culos negociados con proveedores.
                            </span>

                             <div class="float-right">
                                <a href="{{ route('releases.create') }}" class="btn btn-primary btn-md float-right"  data-placement="left">
                                  Agregar nueva novedad 
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
                        <table class="table table-hover" id="table" class="display" style="width:100%">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Clave SIAC</th>
										<th>Descripci&oacute;n</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($releases as $release)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $release->artcve }}</td>
											<td>{{ $release->artdesc }}</td>

                                            <td>
                                                <form action="{{ route('releases.destroy',$release->id) }}" method="POST">
                                                    
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
                {!! $releases->links() !!}
            </div>
        </div>
    </div>
@endsection

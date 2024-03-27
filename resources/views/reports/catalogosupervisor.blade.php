@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"> Generar cat&aacute;logo para supervisor</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Cat&aacute;lago </li>
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
                                Exportar y compartir cat&aacute;logo
                            </span>

                            <div class="float-right">
                                &nbsp;
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        <p class="text center"> <a
                            name=""
                            id=""
                            class="btn btn-primary"
                            href="#"
                            role="button"
                            >Descargar archivo Excel</a
                        >
                         </p>

                         <p class="text center"> <a
                            name=""
                            id=""
                            class="btn btn-primary"
                            href="#"
                            role="button"
                            >Descagar archivo PDF</a
                         >
                          </p>
                          <p class="text center"> 
                            <a
                                name=""
                                id=""
                                class="btn btn-success"
                                href="#"
                                role="button"
                                >Compartir por WhatsApp</a
                            >
                            
                          </p>

                          <div >

                                <img src="{{ asset('admin/dist/img/catalogo.png') }}" class="rounded mx-auto d-block" alt="...">
                                <p class="text center"> <h3> Escanear c&oacute;digo Qr para descargar cat&aacute;logo digital </h3> </p>
                          </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
@endsection

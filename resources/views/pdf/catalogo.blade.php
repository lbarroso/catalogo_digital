<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogo Digital</title>    
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">

    <style>
        /* Contenedor de las imágenes */
        .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        }


        /* Estilo de las imágenes */
        .product-image-container img {
        width: 180px;
        height: 180px;
        display: block;
        }


        /* Estilo para un contenedor general de productos (ajusta según tu diseño) */
        .product-container {
        width: 180px;
        margin: 20px;
        }

        .img-thumbnail{
    width:220px;height:277px;object-fit:cover;
    border:0;border-radius:10px;
    box-shadow:0 2px 6px rgba(0,0,0,.18);
  }        

        .jumbotron-custom {
            background-color: #10312B;
            color: white;
        }

        .btn-gold-rounded {
            background-color: #BC955C;
            color: #fff;
            border-radius: 30px;
            border: none;
        }

    </style>
    

</head>

<body>

<div class="container mt-2">
    
    <div class="row">
        <div class="col-md-12 text-center">
            <h1> {{ $empresa->regnom }} </h1>
        </div>
    </div>

    <header class="bg-dark text-white text-center py-5">        
        <p class="lead"> UNIDAD OPERATIVA {{ $empresa->regmun }}  </p>
    </header>

    <div class="text-center">
        <img src="{{ asset('admin/dist/img/FondoCatalogo700x650.png') }}" width="700" height="650" class="" >
    <div>        
    
    <div class="jumbotron text-center jumbotron-custom">
        <h1 class="display-4">¡Bienvenido a nuestro Catálogo Digital!</h1>
        <p class="lead">Descubre nuestra amplia selección de productos de alta calidad.</p>
        <a class="btn btn-lg btn-gold-rounded" href="#categories" role="button">Explorar Catálogo</a>
    </div>


    <h3 class="text-left" id="categories">Categorias  <small class="text-muted">Al hacer clic en el enlace, serás llevado a la categor&iacute;a correspondiente</small>    </h3>
    
    <div class="row" style="font-size:9pt">

        <ul>
            @foreach($categories as $category)
                <li> <a href="#{{ $category->name }}"> {{ $category->name }} </a> </li>
            @endforeach
        </ul>

    </div>


<br>
    
</div>

<div class="container mt-2">
    
    @if($releases)
        <h1> Productos Novedades </h1>
        
        <div class="row">    
            @foreach($releases as $product)    
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <?php                     
                            if(!$product->file_name) $imagen = 'http://10.101.21.24/catalogo/public/admin/dist/img/sinfoto.jpg'; 
                            else $imagen = 'http://10.101.21.24/catalogo/public/storage/'.$product->id.'/'.$product->file_name;                                                                                       
                        ?>
                        <img src="<?php echo $imagen; ?>" class="img-thumbnail" width="220" height="277">
                    </div>
                    <div class="card-body">
                        <h4>  {{ substr($product->artdesc,0, 25) }}  </h4>
                        <p class="text-muted"> 
                            Clave: {{ $product->artcve }}                
                            Presentaci&oacute;n: {{ $product->artpesoum }}
                        </p>    
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    @endif
    
</div>

@php
    $category = "nada";
@endphp  
        
@foreach($products->chunk(3) as $productChunk)

    <table style="font-size: 9pt;" width="100%"  border="0" class="product-image-container">      

        <tr>
            
            @foreach($productChunk as $product)
                                        
                <td width="33%">

                    <?php                        
                    if(!$product->image) $imagen = 'http://10.101.21.24/catalogo/public/admin/dist/img/sinfoto.jpg'; 
                    else{
                        $file_name = str_replace(' ', '-', $product->image);
                        $imagen = 'http://10.101.21.24/catalogo/public/storage/'.$product->id.'/conversions'.'/'.$file_name.'-preview.jpg';
                    }                    
                    ?>

                    <img src="<?php echo $imagen; ?>" class="product-image-container img" >

                    <p class="text-justify"> 
                        Clave: <span style="background-color:#238e9a; color:#fff; "> {{ $product->artcve }} </span>
                        @if($product->name != $category)   
                        <a href="#categories" id="{{ $product->name }}"> CATEGORIAS </a>
                        @endif 
                    </p>
                    <p class="text-left"> <strong>  {{ substr($product->artdesc,0, 25) }} </strong> </p>
                    
                    <p class="text-justify"> <span style="color: #BC955C;">  Presentaci&oacute;n: {{ $product->artpesoum }} </span> </p>

                    @if($artprventa === 'SI')
                        <p class="text-justify">
                            Piezas: {{ $product->stock }}  <span style="color: #9f2241;"> Precio: ${{ number_format($product->artprventa,2) }} </span> 
                        </p>
                    @else
                        <p class="text-justify"> Piezas: {{ $product->stock }} Tipoinv: {{ $product->artseccion }}</p>    
                    @endif
        
                </td>
                
                <?php $category =$product->name; ?>                

            @endforeach

        </tr>

    </table>            

@endforeach  

</body>

</html>
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
        width: 110px;
        margin: 20px;
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
        <p class="lead"> Catálogo Digital Suc. {{ $empresa->regedo }}  </p>
    </header>

    <div class="text-center">
        <img src="{{ asset('admin/dist/img/fondocatalogo.png') }}" width="700" height="650" class="" >
    <div>        
    
    <div class="jumbotron text-center">
        <h1 class="display-4">¡Bienvenido a nuestro Catálogo Digital!</h1>
        <p class="lead">Descubre nuestra amplia selección de productos de alta calidad.</p>
        <a class="btn btn-primary btn-lg" href="#categories" role="button">Explorar Catálogo</a>
    </div>


    <h2 class="text-left" id="categories">Categorias </h2>

    <div class="row" style="font-size:10pt">

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


    <table style="font-size: 9pt;" width="100%"  border="0" class="text-center" class="product-image-container">      

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
                        Clave: <span style="background-color:#691C32; color:#fff; "> {{ $product->artcve }} </span>
                        @if($product->name != $category)   
                        <a href="#categories" id="{{ $product->name }}"> CATEGORIAS </a>
                        @endif 
                    </p>
                    <p class="text-left"> <strong>  {{ substr($product->artdesc,0, 25) }} </strong> </p>
                    <p class="text-justify"> Presentaci&oacute;n: {{ $product->artpesoum }}</p>
                    <p class="text-justify"> Piezas: {{ $product->stock }} Tipoinv: {{ $product->artseccion }}</p>    
        
                </td>
                
                <?php $category =$product->name; ?>                

            @endforeach

        </tr>

    </table>            

@endforeach

    

  

</body>

</html>
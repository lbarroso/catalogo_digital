<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cenefas factura</title>    
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">

    <style>
        @charset "UTF-8";

        .card-img-background {
            background-size: cover;
            background-position: center;
            height: 200px;
        }
    </style>

</head>

<body>

<table  width="auto"  border="0" >
@php
    $products = $products->chunk(2); // Divide los productos en grupos de dos
@endphp

@foreach($products as $productChunk)
    <tr>
        @foreach($productChunk as $product)
            <td style="background-image:url('http://10.101.21.24/catalogo/public/admin/dist/img/cenefa-precio-blanco345x200.jpg'); width: 345px; height: 200px;">
                <h5> &nbsp;</h5>
                <p style="text-align: right;
                    font-size: 48pt;
                    font-weight: 1800;
                    color: #000;
                    margin-right: 20px;">

                    <span style="border-bottom: 3px solid #bc955c;
                                padding-bottom: 2px;">
                        {{ number_format($product->pieza, 2) }}
                    </span>
                </p>
                <div class="content">
                    
                    <p style="text-align:center; font-size:15pt;"> <strong> {{ utf8_encode(substr($product->artdesc, 0, 25)) }} </strong>  </p>
                    <p style="text-align:center; font-size:11pt; color:#FFF;">
                        <strong>
                            {{ $product->artpesogrm }} / {{ $product->artpesoum  }}
                        </strong>
                    </p>
                </div>
            </td>
        @endforeach
    </tr>
@endforeach


</table>


</body>

</html>
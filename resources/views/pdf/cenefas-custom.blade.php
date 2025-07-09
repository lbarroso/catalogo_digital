<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cenefas Individuales</title>    
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">

    <style>
        .card-img-background {
            background-size: cover;
            background-position: center;
            height: 200px;
        }
    </style>

</head>

<body>

<table  width="auto"  border="0" >
        @foreach($products as $product)
        <tr>
            <td style="background-image:url('http://10.101.21.24/catalogo/public/admin/dist/img/cenefa345x190.jpg'); width: 345px; height: 190px;">
                <p style="text-align:right; font-size:26pt;"> <strong> {{ number_format($product->artprventa,2) }} </strong> &nbsp;&nbsp;&nbsp;&nbsp;</p>
                <div class="content">
                    <h5> &nbsp;</h5>
                    <p style="text-align:center; font-size:15pt;"> <strong> {{ substr($product->artdesc,0,25) }} </strong>  </p>
                    <p style="text-align:center; font-size:13pt;"> <strong> {{ $product->artpesoum }} </strong>  </p>
                </div>
            </td>
            <td style="background-image:url('http://10.101.21.24/catalogo/public/admin/dist/img/cenefa345x190.jpg'); width: 345px; height: 190px;">
                <p style="text-align:right; font-size:26pt;"> <strong> {{ number_format($product->artprventa,2) }} </strong> &nbsp;&nbsp;&nbsp;&nbsp;</p>
                <div class="content">
                    <h5> &nbsp;</h5>
                    <p style="text-align:center; font-size:15pt;"> <strong> {{ substr($product->artdesc,0,25) }} </strong> </p>
                    <p style="text-align:center; font-size:13pt;"> <strong> {{ $product->artpesoum }} </strong>  </p>
                </div>
            </td>
        </tr>
        @endforeach
</table>


</body>

</html>
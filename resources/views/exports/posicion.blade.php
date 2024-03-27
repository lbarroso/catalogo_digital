<table style="border:1px solid #cccccc;">



    <thead>

        <tr>

            
            <th><strong>CLAVE</strong></th>

            <th><strong>DESCRIPCION</strong></th>

            <th><strong>PRESENTACION</strong></th>

            <th><strong>TDEINV</strong></th>

            <th><strong>PRECIO VENTA</strong></th>

            <th><strong>RESTOS</strong></th>

        </tr>

    </thead>

    <tbody>



        @foreach ($products as $item)

            <tr>                

                <td width="16"> {{ $item->artcve  }} </td>

                <td width="80"> {{ $item->artdesc }} </td>
                
                <td width="16"> {{ $item->artpesoum }} </td>

                <td width="13"> {{ $item->artseccion }} </td>

                <td width="13"> {{ $item->artprventa }} </td>

                <td> {{ $item->stock }} </td>
                 
            </tr>

        @endforeach

        

    </tbody>

    <tfoot>

        <tr>

            <td></td>

            <td></td>

            <td></td>

            <td></td>

            <td></td>

        </tr>

    </tfoot>

</table>
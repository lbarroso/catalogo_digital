<table style="border:1px solid #cccccc;">



    <thead>

        <tr>

            <th><strong>FAM</strong></th>

            <th><strong>CLAVE</strong></th>

            <th><strong>DESCRIPCION</strong></th>

            <th><strong>CAP</strong></th>

            <th><strong>GRAM</strong></th>

            <th><strong>PRECIO</strong></th>

            <th><strong>RESTOS</strong></th>

            <th><strong>TI</strong></th>

        </tr>

    </thead>

    <tbody>



        @foreach ($products as $item)

            <tr>                

                <td width="6"> {{ $item->category_id  }} </td>

                <td width="16"> {{ $item->artcve  }} </td>

                <td width="80"> {{ $item->artdesc }} </td>

                @php
                    $parts = explode('/', $item->artpesoum);                    
                    $firstPart = $parts[0];
                @endphp                
                
                <td> {{  $firstPart }} </td>
                
                <td> {{ $item->artpesogrm }} </td>

                <td width="13"> {{ $item->artprventa }} </td>

                <td> {{ $item->stock }} </td>

                <td> {{ $item->artseccion }} </td>
                 
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
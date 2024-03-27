<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articulos</title>
</head>
<body>

<table border="1">
    <thead>
        <tr>             
            <th>i</th>
            <th>almcnt</th>
            <th>artcve</th> 
            <th>artdesc</th> 
            <th>prvcve</th>
            <th>artstatus</th> 
            <th>famcve</th> 
            <th>codbarras</th> 
            <th>artmarca </th>
            <th>artestilo </th>
            <th>artcolor </th>
            <th>artseccion </th>
            <th>arttalla  </th>
            <th>stock </th> 
            <th>artimg </th> 
            <th>dartprcosto </th>            
            <th>artprventa </th>            
            <th>artpesogrm </th>                 
            <th>artpesoum </th> 
            <th> artganancia  </th>
            <th>eximin </th>
            <th>eximax</th>
            <th>artdetalle </th>
            <th>created_at </th>
            <th>updated_at</th>
        </tr>
    </thead>
    <tbody>    
    {{ $i = 1 }} 
    @foreach($articulos as $row )
    
    <tr>       
         <td> {{ $i++ }} </td>  
         <td> {{ $row->almcnt }} </td>
         <td> {{ $row->artcve }} </td>  
         <td> {{ utf8_encode( $row->artdesc) }} </td>  
         <td> {{ $row->prvcve }} </td>                 
         <td> {{ $row->artstatus }} </td>             
         <td> {{ $row->famcve }} </td>                                       
         <td> {{ $row->codbarras  }} </td>   
         <td>  marca </td>   
         <td> estilo </td>   
         <td> color </td>  
         <td> seccion </td>   
         <td> talla </td>   
         <td> {{ $row->er }} </td>
         <td> artimg </td>
         <td> 0 </td>
         <td> {{ $row->pieza }} </td>  
         <td> {{ $row->artgms }} </td>  
         <td> {{ $row->artmed }} </td>  
         <td> 0 </td>  

         <td> 0  </td>  
         <td> 0 </td>  
         <td>  </td>  
         <td>  2024-03-11 </td> 
         <td> 2024-03-11 </td> 

    </tr>
    
    @endforeach
    
    </tbody>
</table>

</body>
</html>

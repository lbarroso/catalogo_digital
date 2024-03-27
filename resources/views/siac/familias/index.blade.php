<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Familias </title>
</head>
<body>

<table border="1">
    <thead>
        <tr> 
            <th>famcve</th> 
            <th>famdesc</th> 

        </tr>
    </thead>
    <tbody>    
    @foreach($familias as $row )
    <tr>         
         <td> {{ $row->famcve }} </td>  
         <td> {{ $row->famdesc }} </td> 

    </tr>
    @endforeach
    
    </tbody>
</table>

</body>
</html>

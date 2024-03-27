var product_property_id;
$(document).ready(function(){
    $('#modal-property').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        product_property_id = button.data('product_id')
        let name = button.data('name')
        $('#titleProperty').text(name);
        getProperties(product_property_id);
    
    });

    $("#formProperty").submit(function(e){
        e.preventDefault();
        let data = $(this).serialize();
        data += '&product_id='+product_property_id
        $.ajax({
            method: 'post',
            url: storeProperty,
            data: data,
            success: function(){
                $.notify("Se guardo correctamente", "success");
                $('#formProperty')[0].reset();
                getProperties(product_property_id);


            },
            error:function(){
                $.notify("Ha ocurrido un error", "error");

            }
        })
    });

 



});

function getProperties(id){
    $('#tableProperties').empty();

    let url = getProperty.replace("/0","/"+id);
    $.ajax({
        method:'get',
        url: url,
        success: function(data){
            var table = '';

            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                table += '<tr>'
                table += '<td>'+ element["id"] +'</td>';
                table += '<td>'+ element["name"] +'</td>';
                table += '<td>'+ element["value"] +'</td>';
                table += '<td><button onclick="deleteProperty('+element["id"] +')" class="btn btn-danger">Eliminar</button></td>';
                table += '</tr>'
                
            }

            $('#tableProperties').append(table);


        }
    })
}


function deleteProperty(id){
    let url = deletProperty.replace("/0","/"+id);
    $.ajax({
        method:'delete',
        url: url,
        success: function(){
            $.notify("Se elimino correctamente", "success");

            getProperties(product_property_id)
        }
    })
}

$(document).ready(function(){

    $('#modalAddress').on('show.bs.modal',function(e){
        $("#formAddress")[0].reset();
    });


    $('#formAddress').submit(function(e){
        e.preventDefault();
        var url = '/domicilio';

        $.ajax({
            method:'post',
            url:url,
            data: $(this).serialize(),
            success:function(){
                $('#modalAddress').modal('hide');
                $.notify("Se guardo correctamente", "success");
                address();
            },
            error:function(){
                $.notify("Ha ocurrido un error", "error");

            }
        })

    })

    address();


})

function address(){

    $('#address_id').empty();

    $.ajax({
        method:'get',
        url: '/domicilio',
        success:function(response){
            var cadena ="<option value = '' > Seleccione un domicilio</option>";
            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                cadena += "<option value = '"+ element['id'] +"' > " + element["street"]+' '+ element["postal_code"] + "</option>";
                
            }

            $('#address_id').append(cadena);
        }
    })
}
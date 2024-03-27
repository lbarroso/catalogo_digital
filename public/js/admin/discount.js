var product_id;


$(document).ready(function() {
    $('#modal-discount').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        product_id = button.data('product_id')

        getDiscount(product_id);
    
    });



    $('#formDiscount').submit(function(e){
        e.preventDefault();

        let data = $(this).serialize()
        data += '&product_id='+product_id

        $.ajax({
            method: 'post',
            url: '/administracion/discounts/store',
            data: data,
            success: function(){
                $.notify("Se guardo correctamente", "success");
                $('#formDiscount')[0].reset();
                getDiscount(product_id);


            },
            error:function(){
                $.notify("Ha ocurrido un error", "error");

            }
        })

    })
})




function getDiscount(id){
    $('#tableDiscount').empty();
    $.ajax({
        method:'get',
        url: '/administracion/discounts/product/table/'+id,
        success: function(data){
            var discount = '';

            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                discount += '<tr>'
                discount += '<td>'+ element["id"] +'</td>';
                discount += '<td>'+ element["percentage"] +'</td>';
                discount += '<td>'+ element["date_start"] +'</td>';
                discount += '<td>'+ element["date_end"] +'</td>';
                discount += '<td>'+ element["is_active"] +'</td>';
                discount += '<td><button onclick="deleteDiscount('+element["id"] +')" class="btn btn-danger">Eliminar</button></td>';
                discount += '</tr>'
                
            }

            $('#tableDiscount').append(discount);


        }
    })
}


function deleteDiscount(id){
    $.ajax({
        method:'delete',
        url: '/administracion/discounts/'+id,
        success: function(){

            getDiscount(product_id)
        }
    })
}
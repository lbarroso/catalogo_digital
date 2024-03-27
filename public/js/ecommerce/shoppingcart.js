function addShoppingCart(product_id,quantity){

    $.ajax({
        method:'post',
        url:'/carrito/guardar',
        data:{
            product_id:product_id,
            quantity:quantity
        },
        success:function(){
            $.notify("Se guardo correctamente","success");
        },
        error:function(){
            $.notify("El producto tiene poco inventario","error");

        }
    })
}


$('#formShoppingCart').submit(function(e){
    e.preventDefault();
    var quantity = $('#formShoppingCart #quantity').val();
    var product_id = $('#formShoppingCart #id').val();
    addShoppingCart(product_id,quantity);
})


function updateShopppingCart(id){
    var quantity = $("#quantity_"+id).val();

    $.ajax({
        method: "put",
        url: "/carrito/actualizar/"+id,
        data : {
            quantity: quantity
        },
        success: function(params) {
            window.location.reload();
        }
    });

}

function deleteShopppingCart(id){

    $.ajax({
        method: "delete",
        url: "/carrito/eliminar/"+id,
        success: function(params) {
            window.location.reload();
        }
    });
}
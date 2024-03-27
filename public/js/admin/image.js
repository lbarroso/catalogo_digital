var product_id_images;
$(document).ready(function(){
    $('#formImages').submit(function(e){
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('product_id',product_id_images);

        $.ajax({
            method:'post',
            url: urlImageStore,
            data:formData,
            contentType: false,
            cache:false,
            processData:false,
            success:function(){
                var product_id = $("#formImages #images_product_id").val();
                getImages(product_id);
                $('#formImages')[0].reset();
                $("#formImages #images_product_id").val(product_id)
            }
        })
    })

    $('#modal-images').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        product_id_images = button.data('product_id');
        $("#formImages #images_product_id").val(product_id_images);
        getImages(product_id_images);
    
    })
})


function getImages(id){
        
    
    
    
    $.ajax({
        method: "GET",
        url: 'images/product/table/' + id,
        success:function(data){
            var cadena = "";

            for (let i = 0; i < data.length; i++) {
                const element = data[i];

                cadena += "<div class='col-4'><div class='card' >";
                cadena += "<img src='"+ element["preview_url"] +"' class='card-img-top'/>";
                cadena += "<div class='card-body pl-1 pr-1 text-center'>";
                if(element.custom_properties.first == true){
                    cadena += '<p class="card-text">Es principal</p>'
                }
                cadena += "<a onclick='deleteImage("+ element.id +","+ product_id_images +")' class='btn btn-danger btn-sm'>Eliminar</a>";
                cadena += "</div></div></div>";
            }


            $("#targetImages").html(cadena);
        }

    })
}


function deleteImage(id, product_id){
    $.ajax({
        method:"delete",
        url:"images/"+id,
        data:{
            product_id: product_id
        },
        success:function(){
            getImages(product_id);
        }
    })
}
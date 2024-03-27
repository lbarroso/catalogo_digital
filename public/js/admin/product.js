var datatable;


$(document).ready(function(){	

    datatable = $('#table').DataTable({
		
		order: [[0, 'desc']], 
        ajax: indexUrl,
		
        columns: [
            { data:'artcve' },            
            { data:'artdesc' },
            { data:'artpesoum' },
            { data:'codbarras' },
            { 
				data:'artprventa',
				"render": function (data, type, row) {
					// Formatear el número con dos decimales
					return parseFloat(data).toFixed(2);
				}				
			},
            { data:'artseccion' },
            { data:'stock' },
            { data:'category.name' },
            { 
                data:'id',
                render: function(data,type,row){
                    var edit = ''
                    var pDelete = ''
                    var pDiscount = ''
					var pProperty = ''					
                    var pImages = ''

                    edit = '<button data-id="'+data+'" data-toggle="modal" data-target="#modal-product" class="btn btn-warning btn-sm mr-1"><i class="fas fa-edit"></i></button>';
                    pDelete = '<button onclick="if(confirm(\'eliminar\')) deleteModel('+data+'); else return false;"  class="btn btn-danger btn-sm mr-1"><i class="fas fa-trash"></i></button>';
                    pDiscount = '<button data-product_id="'+data+'" data-toggle="modal" data-target="#modal-discount" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-table"></i></button>';                    
                    pProperty = '<button data-name="'+row.name+'" data-product_id="'+data+'" data-toggle="modal" data-target="#modal-property" class="btn btn-info btn-sm mr-1"><i class="fas fa-table"></i></button>';
					pImages = '<button data-name="'+row.name+'" data-product_id="'+data+'" data-toggle="modal" data-target="#modal-images" class="btn btn-info btn-sm mr-1"><i class="fa fa-image"></i></button>';

                    return edit+pDelete+pImages;
                }
            }
        ]
    });

    
   getCategories();


    $('#formProduct').validate({
        rules:{
            artdesc: {
                required:true,
                minlength: 3
            },
            category_id: {
                required:true,
                minlength: 1
            },               
            artprventa: {
                required:true,
                minlength: 1
            },            
        },
        errorClass:'text-danger',
        submitHandler:function(form){
            let id =  $('#id').val()
            let url = storeUrl;
            let method  = 'post';

            if(parseInt(id) !== 0){
                url = updateUrl.replace("/0","/"+id);
                method = 'PUT';
            }

            $.ajax({
                method: method,
                url : url,
                data:$(form).serialize(),
                success:function(){
                    $('#modal-product').modal('hide');
                    $.notify("Se guardo correctamente", "success");

                    datatable.ajax.reload();

                },
                error:function(res){
                    console.log(res);
                }
            })

        }


    });


    $('#modal-product').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
		
		
        if(parseInt(id) == 0){
            $("#formProduct")[0].reset();
            $('#id').val(0)
        }else{

            find(id);
        } 
      
    });
})



function getCategories(){
    $.ajax({
        method: 'get',
        url: urlCategories,
        success:function(response){
            var categories = "";

            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                categories += "<option value = '"+ element['id'] +"' > " + element["name"] + "</option>";
            }

            $('#category_id').append(categories);
        }
    })
}


function find(id){
    let url = showUrl.replace("/0","/"+id);
    $.ajax({
        method:'get',
        url:url,
        success:function(response){            
			$('#artdesc').focus();			
            $('#artdesc').val(response.artdesc);			
			$('#codbarras').val(response.codbarras);            
            $('#artprcosto').val(parseFloat(response.artprcosto).toFixed(2));
			$('#artganancia').val(parseFloat(response.artganancia).toFixed(2));
			$('#artprventa').val(parseFloat(response.artprventa).toFixed(2));
            $('#stock').val(response.stock);
            $('#artmarca').val(response.artmarca);
            $('#category_id').val(response.category_id);            
            $('#id').val(response.id);
        }
    })

}

function deleteModel(id){
    let url = deleteUrl.replace("/0","/"+id);

    $.ajax({
        method:'DELETE',
        url:url,
        success:function(respo){
            $.notify("Se elimino correctamente", "success");

            datatable.ajax.reload();
        }
    });

}






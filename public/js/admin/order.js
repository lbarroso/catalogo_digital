var datatable;


$(document).ready(function(){

    // datos de la tabla
    datatable = $('#table').DataTable({
        ajax: indexUrl,
        columns: [
            { data:'id' },
            { data:'created_at' },
            { data:'invoice' },
            { data:'statu.name' },

            { 
                data:'id',
                render: function(data,type,row){

                    var edit = ''
                    
                    edit = '<button data-id="'+data+'" data-toggle="modal" data-target="#modal-order" class="btn btn-warning btn-sm mr-1"><i class="fas fa-tags"></i></button>';

                    return edit;
                }
            }
        ]
    });

    // modal formulario agregar o actualizar 
    $('#formOrder').validate({
        rules:{
            name: {
                required:true,
                minlength: 3
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
                    $('#modal-order').modal('hide');
                    $.notify("Se guardo correctamente", "success");

                    datatable.ajax.reload();

                },
                error:function(res){
                    console.log(res);
                }
            })

        }
    });

    // colocar datos en el formulario
    $('#modal-order').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        if(parseInt(id) == 0){
            $("#formOrder")[0].reset();
            $('#id').val(0)
        }else{

            find(id);
        } 
      
    });
	


	
})


// mostrar datos para editarlos
// admin.orders.show
function find(id){
    
    let url = showUrl.replace("/0","/"+id);

    $.ajax({
        method:'get',
        url:url,
        success:function(response){
            $('#id').val(response.id);				

        }
    })

}




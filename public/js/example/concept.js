var datatable;


$(document).ready(function(){
    datatable = $('#table').DataTable({
        ajax: indexUrl,
        columns: [
            { data:'id' },
            { data:'concepto' },
            

            { 
                data:'id',
                render: function(data,type,row){
                    var edit = ''
                    var pDelete = ''

                    edit = '<button data-id="'+data+'" data-toggle="modal" data-target="#modal-concept" class="btn btn-warning btn-sm mr-1"><i class="fas fa-edit"></i></button>';
                    pDelete = '<button onclick="deleteModel('+data+')"  class="btn btn-danger btn-sm mr-1"><i class="fas fa-trash"></i></button>';


                    return edit+pDelete;
                }
            }
        ]
    });




    $('#formPost').validate({
        rules:{
            title: {
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
                    $('#modal-post').modal('hide');
                    $.notify("Se guardo correctamente", "success");

                    datatable.ajax.reload();

                },
                error:function(res){
                    console.log(res);
                }
            })

        }
    });


    $('#modal-post').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        if(parseInt(id) == 0){
            $("#formPost")[0].reset();
            $('#id').val(0)
        }else{

            find(id);
        } 
      
    });
})






function find(id){
    let url = showUrl.replace("/0","/"+id);


    $.ajax({
        method:'get',
        url:url,
        success:function(response){
            $('#id').val(response.id);
            $('#title').val(response.title);
            $('#message').val(response.message);
           
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
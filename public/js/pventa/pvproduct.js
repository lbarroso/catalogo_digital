var datatable;

$(document).ready(function(){
		
    datatable = $('#table').DataTable({
		
		order: [[0, 'asc']], 
        ajax: indexUrl,
		
        columns: [
            // La primera columna ahora es un número consecutivo
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data:'artdesc' },			
            { data:'doccant' },
            {
				data:'artprventa',
				"render": function (data, type, row) {
					return parseFloat(data).toFixed(2);
				}
			},
			{ data:'artdescto' },
            {
				data:'docimporte',
				"render": function (data, type, row) {
					return parseFloat(data).toFixed(2);
				}
			},
            {
                data:'id',
                render: function(data,type,row){
                    var edit = ''
                    var pDelete = ''
                    
                    edit = '<button data-id="'+data+'" data-toggle="modal" data-target="#modal-product" class="btn btn-warning btn-sm mr-1"><i class="fas fa-edit"></i></button>';
                    pDelete = '<button onclick="deleteModel('+data+')"  class="btn btn-danger btn-sm mr-1"><i class="fas fa-trash"></i></button>';

                    return edit + pDelete;
                }
            }
        ]
    }); // datatable
	
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
	    
// 	var form = document.querySelector("#formProduct"); // form	
	var btn = document.querySelector("#formProductBtn"); // boton
	btn.addEventListener("click",updatePvproduct);
	
	function updatePvproduct(e){
		
		e.preventDefault;
		
		let url = updateUrl;

		$.ajax({
			method:'PUT',
			url:url,
			data: $('#formProduct').serialize(),
			success:function(respo){
				$('#modal-product').modal('hide');		        
				
				datatable.ajax.reload();
				document.getElementById("codigo").focus();
			}
		});

	}

	
}) // document.ready


// modificar cantidad
function find(id){
    let url = showUrl.replace("/0","/"+id);
	
    $.ajax({
        method:'get',
        url:url,
		data: { 'id' : id },
        success:function(response){	
			$('.modal-title').html(response.artdesc);
            $('#doccant').val(parseFloat(response.doccant).toFixed(2));
            $('#id').val(response.id);
			$('#doccant').focus();
			$('#doccant').select();
        }
    })
}


function deleteModel(id){
	
    let url = deleteUrl.replace("/0","/"+id);

    $.ajax({
        method:'DELETE',
        url:url,
		data: { 'id' : id },
        success:function(respo){
            
			$.notify("Se elimino correctamente", "success");

            datatable.ajax.reload();
			document.getElementById("codigo").focus();
        }
    });

}


// enter cantidad
function enterCantidad(field, event)
{
	var tecla = event.keyCode;
	
	if(tecla == 13){
		event.preventDefault;
	  
		let url = updateUrl;

		$.ajax({
			method:'PUT',
			url:url,
			data: $('#formProduct').serialize(),
			success:function(respo){
				$('#modal-product').modal('hide');		        
				// $.notify("Cantidad actualizada correctamente", "success");
				datatable.ajax.reload();
				document.getElementById("codigo").focus();
			}
		});	  
	}
}
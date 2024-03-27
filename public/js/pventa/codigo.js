document.getElementById("codigo").focus();

function enterCodigo(event)
{	
	var tecla = event.keyCode;
	
	if(tecla == 13)
	{

		event.preventDefault();
		var codigo = document.getElementById("codigo").value;
		if (codigo.trim() == 'BUSCAR' || codigo.trim() == 'buscar') $('#modal-findproduct').modal(); // abrir modal	
		if (codigo.trim() == 'vender' || codigo.trim() == 'vender') alert('modal confirm venta');
		
		if(codigo.length <= 0 || codigo == '') return false;
				
		$.ajax({
			url: storeUrl,
			type: 'post',
			data: { 'codigo' : codigo},
			success:function(){
				
				$("#formCodigo")[0].reset();
				
				datatable.ajax.reload();

			},
			error:function(res){
				console.log(res);
			}
		});
	}
	
} // function
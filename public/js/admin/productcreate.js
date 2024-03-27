$(document).ready(function(){
	
	//Initialize Select2 Elements
    $('.select2').select2()
	
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })		

	const primerInput = document.getElementById("codbarras");	
	
	if (primerInput) {                
		primerInput.focus();
		primerInput.select();
	}

    getCategories();
		
	
}) // document.ready

// listado categorias 
// pantalla nuevo producto
function getCategories(){
    $.ajax({
        method: 'get',
        url: urlCategories,
        success:function(response){
            var categories = "";

            for (let index = 0; index < response.length; index++) {
                const element = response[index];
				// categoria predeterminada
				if(element["name"] == 'DULCES Y CARAMELOS'){
					categories += "<option value = '"+ element['id'] +"' selected> " + element["name"] + "</option>";
				}		
				else{
					categories += "<option value = '"+ element['id'] +"' > " + element["name"] + "</option>";
				}
                
            }

            $('#category_id').append(categories);
        }
    })
}


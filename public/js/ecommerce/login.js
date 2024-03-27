$(document).ready(function(){

    $("#formLogin").submit(function(e){
        e.preventDefault();

        $.ajax({
            method: 'post',
            url : '/login',
            data: $(this).serialize(),
            success: function(){
                window.location.href = '/';
            },
            error: function(response){
                console.log(response);
                //400 deben mostrar un error de falta correo o password
                //401 debe mostrar usuario no registrado
            }
        })

    });
})
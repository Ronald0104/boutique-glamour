$(document).ready(function(){
    console.log('kardex');

    // Registrar un movimiento en el kardex
    $('.btn-kardex-register').on('click', registrarOperacionKardex)

    function registrarOperacionKardex(){
        console.log($(this));
        var option = $(this).data('option');
        console.log(option);

        window.location = "/inventario/kardex_registrar/" + option;
        return 0;
        var request = $.ajax({
            'type' : 'POST',
            'url' : '/inventario/kardex_registrar',
            'data' : {option : option}
        })
        .done(function(data){
            console.log(data);
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');
        });
    }   


    
})
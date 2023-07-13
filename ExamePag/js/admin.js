$(document).ready(function(){
    //Variáveis Globais

    $("#formulario-login-senha").focus();

    //EVENTOS
    $("#formulario-login-senha").on('keyup', function () {
        //console.log($(this).val());
        if(String($(this).val()).length >= 10){
            $.post("admin/senha.php", {
                senha: $(this).val()
                },
                function(result){
                    //console.log("autenticacao: ",result);
                    if(result == 10){
                        $("#formulario-login-senha").val("");
                        $("#formulario-login").fadeOut(1);
                        $("#formulario-upload").fadeIn(1000);
                    }
                }
            );
        }
    });


});
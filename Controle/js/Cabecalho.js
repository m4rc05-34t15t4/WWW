$(document).ready(function(){
    $link = "../";
    
    Centralizar_cabecalho();

    Por_imagem_usuario_cabecalho();

    Desabilitar_botao_menu_lateral_pagina_atual();
    
    //EVENTOS

    //hover
    $(".botao-menu-lateral").hover(function(){
        if($(this).css("opacity") != "0.5"){
            $(this).css("background-color", "#09F");
        }
    });

    //mouseout
    $(".botao-menu-lateral").mouseout(function(){
        if($(this).attr("paginaatual") != "ok"){
            $(this).css("background", "none");
        }
    });
    
    //click
    $("#status-login-usuario, #usuario-perfil, #formulario-login-cancelar").click(function(){
        if($("#status-login-usuario").text().indexOf("Sair") < 0){
            $(".formularios").toggle(500);
        }
    });

    $("#usuario-perfil").click(function(){
        $codigo = $(this).attr("codigo");
        if($codigo != ""){
            window.location.href = "Usuario_informacoes.php?id="+$codigo;
        }
    });

    $(".botao-menu-lateral").click(function(){
        if($(this).css("opacity") != "0.5"){
            window.location.href = $(this).attr("link");
        }
    });

    //FUNÇÕES

    function Desabilitar_botao_menu_lateral_pagina_atual(){
        $arr_url = String(location).split("Controle/php/");
        $attr_link = $arr_url[1];
        if($arr_url[1].indexOf("?") > 0){
            $arr_url = $arr_url[1].split("?");
            $attr_link = $arr_url[0];
        }
        $(".botao-menu-lateral[link^='"+$attr_link+"']").css("opacity","50%").css("cursor","initial").css("background-color","blanchedalmond");
        $(".botao-menu-lateral[link^='"+$attr_link+"']").attr('paginaatual', 'ok');
    }

    function Centralizar_cabecalho(){
        $largura_nome_usuario = Converte_px_pt($("#nome-usuario").css("width"));
        $(".cabecalho").css("padding-left","calc( (var(--largura-pagina) - var(--largura-usuario-perfil) - " + $largura_nome_usuario + "pt - 700pt) / 2 )");
    }

    function Por_imagem_usuario_cabecalho(){
        $codigo = $("#usuario-perfil").attr("codigo");
        if($codigo != ""){
            $backgroud_imagem = "../img/usuario.png";
            $url = "../img/usuarios/"+$codigo+"/avatar";
            if(Existe($url+".jpg")) {
                $backgroud_imagem = $url+".jpg";
            }
            else if(Existe($url+".png")){
                $backgroud_imagem = $url+".png";
            }
            $("#usuario-perfil").css("background-image", "url('"+$backgroud_imagem+"')");
        }
        else{
            //Seção não iniciada
            $(".botao-menu-lateral:not('#botao-todos-mi')").css("opacity","50%").css("cursor","initial");
        }
    }

});
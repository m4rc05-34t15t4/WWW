$(document).ready(function(){
    
    $link = "../";

    $lista_edicao = new Map();
    $lista_usuarios = new Map();
    $lista_fases_edicao = new Map();

    Recarregar_pagina_resize();
    
    Configuracoes_iniciais();

    Insere_dados_variaveis_auxiliares();
    
    //EVENTOS

    //hover

    $(".blocos table tr td").hover(function(e) {
        $bloco = $(this).attr('bloco');
        $("#bloco_"+$bloco).fadeOut(100);
        $(".blocos-nome").not("#bloco_"+$bloco).fadeIn(500);
        
        //Insere valores na DIV descricao_mi
        Insere_dados_mi_descricao($(this).attr('mi'), e);

    });

    $(".blocos table tr .fora-proj").hover(function() {
        $bloco = $(this).attr('bloco');
        $("#descricao_mi").fadeOut(500);
    });

    $(".blocos-nome").hover(function() {
        $(this).fadeOut(100);
        $(".blocos-nome").not(this).fadeIn(500);
    });

    //click

    //redirecionamento de pagina MI_informações
    $(document).keydown(function(event){
        if(event.which=="17")
            $cntrlIsPressed = true;
    });
    $(document).keyup(function(){
        if(event.which=="17")
            $cntrlIsPressed = false;
    });
    $cntrlIsPressed = false;
    $(".blocos table tr td[mi]").click(function() {
        if($cntrlIsPressed){
            $cntrlIsPressed = false;
            window.open("Mi_informacoes.php?mi="+$(this).attr("mi"));    
        }
        else{
            window.location.href = "Mi_informacoes.php?mi="+$(this).attr("mi");
        }           
    });

    

    //FUNÇÕES

    //Insere_dados_no_mi_descricao
    function Insere_dados_mi_descricao(mi, e){
        //Insere valores na DIV descricao_mi
        if(mi){

            $(".blocos table").css("cursor", "pointer");

            $("#descricao_mi").fadeIn(300);

            //dificuldade
            $dificuldade = "Não classificado";
            if($lista_edicao.get(mi)["niveis"]){
                $dificuldade = $lista_edicao.get(mi)["niveis"];
            }
            
            //operador
            $operador = Seleciona_ultimo_operador_mi(mi);
            
            //conteudo da div
            $conteudo_div_descricao_mi = "<div class=\"fase_"+$lista_edicao.get(mi)["status"]+"\"><b>"+$dificuldade+"</b><br>"+mi+"<br><b>"+$operador+"</b></div>";
            $("#descricao_mi").text("");
            $("#descricao_mi").append($conteudo_div_descricao_mi);

            //posicao da div descricao_mi
            $largura_mi = Converte_px_pt($(".blocos table tr td[mi=\""+mi+"\"]").css("height")) * 0.8;
            if($largura_mi < 10){
                $largura_mi = $largura_mi * 2;
            }
            $posicao_x = Converte_px_pt(e.clientX);
            $posicao_y = Converte_px_pt(e.clientY);
            $left = "calc( "+$posicao_x+"pt - ( var(--largura-div-descricao-mi) / 2 ))";
            $top = "calc( "+$posicao_y+"pt - var(--largura-div-descricao-mi) - "+$largura_mi+"pt )";
            $largura_tela = Converte_px_pt(window.innerWidth);
            if($posicao_y < 200){
                $top = "calc( "+$posicao_y+"pt + "+$largura_mi+"pt )";
            }
            if($posicao_x < 150){
                $left = "calc( "+$posicao_x+"pt)";
            }
            else if($posicao_x > ($largura_tela - 100)){
                $left = "calc( "+$posicao_x+"pt  - var(--largura-div-descricao-mi))";
            }
            $("#descricao_mi").css("left", $left);
            $("#descricao_mi").css("top", $top);
        }
        else{

            $(".blocos table").css("cursor", "default");
            
        }
    }

    //Seleciona qual ultimo operador da carta
    function Seleciona_ultimo_operador_mi($mi){
        $operador = "";
        $status_mi = $lista_edicao.get($mi)["status"];

        switch (String($status_mi)){
            case "9": //revisor2
            case "8": 
            case "7":
                //alteração feita por motivos do banco de dados esta faltando alguns revisor2 pq é igual a revisor1
                if($lista_edicao.get($mi)["revisor2"]){
                    $operador = $lista_edicao.get($mi)["revisor2"];
                    break;
                }
            case "6": //revisor1
            case "5":
                $operador = $lista_edicao.get($mi)["revisor1"];
                break;
            case "81": //editor
            case "80":
            case "61":
            case "60":
            case "4":
            case "3":
            case "2":
                $operador = $lista_edicao.get($mi)["editor"];
                break;
            default:
                $operador = -1;
                break;
        }

        if(($operador < 0) || ($operador == null)){
            return "Sem Operador";   
        }
        return $lista_usuarios.get($operador)["nome"];
    }

    //Faz consulta SQL na tabela edicao usuarios e fases_edicao ($lista_edicao.get("1436-4-NE")["mi"])
    function Insere_dados_variaveis_auxiliares(){
        $.getJSON($link+'php/conexao_todos_mi.php', function(listas) {
            if(listas != 0){
                //console.log(listas);

                $lista_edicao = Formatar_variaveis_auxiliares(listas[0], "mi");
                $lista_usuarios = Formatar_variaveis_auxiliares(listas[1], "codigo");
                $lista_fases_edicao = Formatar_variaveis_auxiliares(listas[2], "codigo");

                Insere_backgroud_status_mi($lista_edicao);
            }
            else{
                alert("Erro ao consudar dados no servidor, Recarregue a página ou tente novamente mais tarde.");
            }
        });
    }

    //Insere cores de fundo com base no status dos mi
    function Insere_backgroud_status_mi(lista_edicao){
        lista_edicao.forEach(function(valor, chave) {
            $(".blocos table tr td[mi=\""+chave+"\"]").addClass("fase_"+valor["status"]);
        });
    }

    //Formata variaveis auxiliares
    function Formatar_variaveis_auxiliares($array, $key){
        $map = new Map();
        for($i=0; $i < $array.length; $i++){
            $map.set($array[$i][$key], $array[$i]);
        }
        //console.log($map);
        return $map;
    }

    //Setar posicao nome DIV bloco
    function Configuracoes_iniciais(){

        //Insere a altura das td MI com base em sua largura
        $(".blocos table tr td").css("height", $(".blocos table tr td").css('width'));
        
        //Defina a posicao nas DIV nomes Bloco
        $qtd_colunas = parseInt($(".blocos table").attr('colunas'));
        $qtd_linhas = parseInt($(".blocos table").attr('linhas'));
        $largura_blocos_table = Converte_px_pt($(".blocos table").css('width'));
        $altura_blocos_table = Converte_px_pt($(".blocos table").css('height'));
        $largura_td_mi = $largura_blocos_table / $qtd_colunas;
        $altura_td_mi = $altura_blocos_table / $qtd_linhas;
        $blocos = ["A1", "A2", "B", "C1", "C2", "C3", "D1", "D2", "D3", "E1", "E2", "E3", "E4", "F1", "F2", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P"];
        for($i=0; $i < $blocos.length; $i++){
            $div = $("#bloco_"+$blocos[$i]);
            $mi_central = $div.attr('mi-central').split("x");
            $left = $mi_central[1] * $largura_td_mi;
            $top = ($mi_central[0] * $altura_td_mi);
            $div.css("left", "calc( var(--padding) - (var(--largura-div-nome-bloco) / 2) + "+$left+"pt)");
            $div.css("top", "calc( var(--padding) - (var(--largura-div-nome-bloco) / 2) + "+$top+"pt)");
        }
        
        //legenda
        $legenda_top = $altura_td_mi * 55;
        $altura_legenda = $altura_td_mi * 24;
        $legenda = $("#todos-mi-legenda-status");
        $legenda.css("top", $legenda_top+"pt");
        $legenda.css("height", $altura_legenda+"pt");
        $largura_tela = Converte_px_pt(window.innerWidth);
        $e_menor = ($largura_tela / 3) < (Converte_px_pt($legenda.css("width")));
        if($e_menor){
            $legenda.css("font-size", "15pt");
        }

    }

});
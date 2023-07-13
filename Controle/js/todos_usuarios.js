$(document).ready(function(){
    $link = "../Controle/";
    $link = "../";

    Todos_usuarios();

    //Insere todos usuarios  pagina Todos_usuario
    function Todos_usuarios(){

        //definir ordem
        $ordenar = "funcao";
        if((Get_url_variaveis() != -1) && (Get_url_variaveis().get("ordenar"))){
            $ordenar = Get_url_variaveis().get("ordenar");
        }

        $.get($link+'php/conexao_todos_usuarios.php', {
            funcao: "all",
            ordenar: $ordenar
            }, 
            function(usuarios){
                console.log(usuarios);
                if(usuarios == 0){
                    alert("Erro ao consultar usuários!");
                }
                else if(usuarios == 1){
                    alert("Função não existe neste projeto!");
                }
                else{
                    $usuarios = usuarios["usuarios"];

                    //Inserir link das imagens dos selos
                    Inserir_link_img_selos(usuarios["descricao_situacao"]);

                    //cria o conteudo da div .todos-usuarios
                    $Content_usuarios = "";
                    $total_usuarios = 0;
                    for($i=0; $i < $usuarios.length; $i++){

                        //selos
                        $retorno_selos = Insere_Selos_situacao($usuarios[$i], usuarios["descricao_situacao"]);
                        
                        //define o backgroud
                        $backgroud_imagem = Usuarios_backgroud($usuarios[$i]["codigo"], $retorno_selos);

                        //define as funções do usuários
                        $usuarios_funcoes = Insere_funcoes_usuarios_adaptado($usuarios[$i], usuarios["descricao_funcoes"]);

                        //define a graduação
                        $posto_graduacao = usuarios["descricao_posto_graduacao"][$usuarios[$i]["posto_graduacao"]]["abrev"]+" "

                        $Content_usuarios += '<div selos_id="'+$retorno_selos["codigo"]+'" id="'+$usuarios[$i]["codigo"]+'" class="usuario"><a href="Usuario_informacoes.php?id=' + 
                            $usuarios[$i]["codigo"] +'"><table class="usuario-table"><tr><td class="usuario-avatar-mini" style="background-image: '+$backgroud_imagem+'">' +
                            '<div class="selos" style="background-image: '+$retorno_selos["img"]+';">'+$retorno_selos["texto"]+'</div></td></tr><tr><td class="usuario-nome-mini">' + 
                            $posto_graduacao + $usuarios[$i]["nome"] + '<br><span class="usuario-funcao-all">'+$usuarios_funcoes+'</span></span></td></tr></table></a></div>';
                            
                        $total_usuarios++;
                    }
                    $(".todos-usuarios").html($Content_usuarios);
                    
                    //Totais situacções usuarios menu superior
                    Totais_situacao(usuarios["descricao_situacao"], $total_usuarios);

                    //EVENTOS

                    //click

                        //filtro
                        $(".total-situacao .filtro").click(function(){
                            filter_situacao($(this));
                        });

                        //ordenar
                        $(".total-situacao .ordenar").click(function(){
                            window.location.href = "Todos_usuarios.php?ordenar="+$(this).attr("ordenar");
                        });

                    //hover
                        
                        //filtro
                        $(".total-situacao .filtro").mouseover(function(){
                            $codigo = $(this).attr("codigo");
                            $(".total-situacao .filtro:hover").css("color", "snow");
                            $(".total-situacao .filtro img[codigo="+$codigo+"]").css("opacity", "100%");
                        });
                        
                        //ordenador
                        $(".total-situacao .ordenar").mouseover(function(){
                            $(".total-situacao .ordenar:hover").css("color", "snow");
                        });

                    //mouseout
                    
                        //filtro
                        $(".total-situacao .filtro").mouseout(function(){
                            $codigo = $(this).attr("codigo");
                            $clicado = $(".total-situacao .filtro input[name="+$codigo+"]")[0].checked;

                            if($clicado){
                                $(this).css("color", "black");
                            }
                            else{
                                $(this).css("color", "brown");
                                $(".total-situacao .filtro img[codigo="+$codigo+"]").css("opacity", "30%");
                            }
                        });

                        //ordenador
                        $(".total-situacao .ordenar").mouseout(function(){
                            $ordenar = "funcao";
                            if((Get_url_variaveis() != -1) && (Get_url_variaveis().get("ordenar"))){
                                $ordenar = Get_url_variaveis().get("ordenar");
                            }
                            if($ordenar == $(this).attr("ordenar")){
                                $(this).css("color", "black");
                            }
                            else{
                                $(this).css("color", "brown");
                            }
                        });

                    //ESTILIZAÇÃO
                    Estilizar_pagina();
                
                }
            }
        )
    }

    //Defina backgoud dos usuarios
    function Usuarios_backgroud(usuario_codigo, selo_texto){
        $backgroud_imagem = "../img/usuario.png";
        $url = "../img/usuarios/"+usuario_codigo+"/avatar";
        if(Existe($url+".jpg")) {
            $backgroud_imagem = "url('"+$url+".jpg')";
        }
        else if(Existe($url+".png")){
            $backgroud_imagem = "url('"+$url+".png')";
        }
        //add imagem indisponivel no usuário
        if((selo_texto["texto"]).indexOf("cancelado") >= 0){
            $backgroud_imagem = "url('../img/cancelado.png'), "+$backgroud_imagem;
            selo_texto["texto"] = selo_texto["texto"].replace(",cancelado","").replace("cancelado,","").replace("cancelado","");
        }
        $backgroud_imagem += ";";
        return $backgroud_imagem;
    }

    //Insere valores totais da situação
    function Totais_situacao(usuarios_desc_situacao, total_usuarios){
        
        $(".total-situacao").append("<div class=\"situacao-contador\"></div>");
        
        usuarios_desc_situacao.forEach(function(valor){
            //img
            $img = "<img codigo=\""+valor["codigo"]+"\" src=\"../img/cancelado_mini.png\"/>";
            if(valor["img"].indexOf("png") > 0){
                $img = "<img codigo=\""+valor["codigo"]+"\" src=\""+valor["img"]+"\"/>";
            }
            //insere no html a div
            $(".total-situacao").append("<div class=\"filtro\" codigo=\""+valor["codigo"]+"\"><input type=\"checkbox\" name=\""+valor["codigo"]+"\">"+$img+"<b qtd=\""+valor["qtd"]+
                "\">"+valor["qtd"]+"</b><br>"+valor["descricao"]+"</div>");
        });
        $(".total-situacao").append("<div class=\"filtro\" codigo=\"0\"><input type=\"checkbox\" name=\"0\" checked><img codigo=\"0\" src=\"../img/all_usuarios_branco.png\"/><b qtd=\""+
            total_usuarios+"\">"+total_usuarios+"</b><br>Todos</div>");
        $(".total-situacao").append("<div class=\"ordenar-content\"><div class=\"ordenar-titulo\"><b>Ordenado por:</b></div><div class=\"ordenar-content-valor\"><div class=\"ordenar\" ordenar=\"nome\"><b>Nome</b></div><div class=\"ordenar\" ordenar=\"situacao\">" + 
            "<b>Situação</b></div><div class=\"ordenar\" ordenar=\"funcao\"><b>Função</b></div><div class=\"ordenar\" ordenar=\"posto-graduacao\"><b>Posto/Graduação</div></div></div>");
        $(".total-situacao .situacao-contador").html(total_usuarios);
    }

    function Estilizar_pagina(){

        Estilizar_show();

        Resize_selos();

        //define cor da ordenação
        if(Get_url_variaveis() != -1){
            $(".total-situacao .ordenar").css("color","brown");
            $(".total-situacao .ordenar[ordenar="+Get_url_variaveis().get("ordenar")+"]").css("color","black");
        }

        //dispara função quando resize
        window.onresize = function(){
            var time;
            clearTimeout(time);
            time = setTimeout(Estilizar_show(), 10);
        };
    }

    //executa a estilização quando a pagina é redimensionada
    function Estilizar_show(){
        //counteudo usuarios
        $altura_barra_situacoes = parseInt(Converte_px_pt($(".total-situacao").css("height")));
        $(".todos-usuarios").css("top","calc(var(--altura-cabecalho) + "+$altura_barra_situacoes+"pt)");
        $(".todos-usuarios").css("height","calc(var(--altura-do-corpo) - var(--padding) - "+$altura_barra_situacoes+"pt)");
        Resize_selos();
    }

    //redimensiona selos e textos dos selos
    function Resize_selos(){
        $largura_tela = parseInt(Converte_px_pt(window.innerWidth));
        if($largura_tela < 800){
            $(".selos").css("background-size","30pt")
                .css("font-size","12pt")
                .css("text-shadow","1pt 1pt #000");
        }
        else if($largura_tela < 1000){
            $(".selos").css("background-size","40pt")
                .css("font-size","16pt")
                .css("text-shadow","1.5pt 1.5pt #000");
        }
        else{
            $(".selos").css("background-size","50pt")
                .css("font-size","20pt")
                .css("text-shadow","2pt 2pt #000");
        }
    }

    //filtrar por situacao
    function filter_situacao(botao){
        
        codigo = botao.attr("codigo");

        //marca e desmarca checbox
        $item_clicado = $(".total-situacao .filtro input[name="+codigo+"]")[0];

        $total = 0;

        if(parseInt(codigo) != 0){

            if($item_clicado.checked == false){
                $item_clicado.checked = true;
                botao.css("color","black");
            }
            else{
                $item_clicado.checked = false;
                botao.css("color","brown");
            }

            //cria codigo seletor
            $(".total-situacao .filtro input[name=0]")[0].checked = 0;
            $(".total-situacao .filtro img[codigo=0]").css("opacity", "30%");
            $(".total-situacao .filtro[codigo=0]").css("color","brown");

            $codigo = [];
            $elemento = $(".total-situacao .filtro input:checked");
            for($i=0; $i < $elemento.length; $i++){
                $cod = $elemento[$i].attributes.name.value;
                $codigo.push(".usuario[selos_id~="+$cod+"]");
                //qtd de lementos
                $total += parseInt($(".total-situacao .filtro[codigo="+$cod+"] b").text());
            }
            $codigo_seletor = $codigo.join([separador = ', ']);
            
            //mostra os filtrados
            $(".usuario:not("+$codigo_seletor+")").fadeOut();
            $($codigo_seletor).fadeIn();
        }
        else{

            $(".total-situacao .filtro input[name=0]")[0].checked = 1;
            $(".total-situacao .filtro img[codigo=0]").css("opacity", "100%");
            $(".total-situacao .filtro[codigo=0]").css("color","black");

            //qtd de lementos
            $total = parseInt($(".total-situacao .filtro[codigo=0] b").text());

            //mostra todos e desmarca todos checkbox
            $(".usuario").fadeIn();

            $(".total-situacao .filtro img").css("opacity", "30%");
            $(".total-situacao .filtro:not([codigo=0])").css("color","brown");
            botao.css("color","black");

            $elemento = $(".total-situacao .filtro input:checked:not([name=0])");
            if($elemento.length > 0){
                for($i=0; $i < $elemento.length; $i++){
                    $elemento[$i].checked = 0;
                }
            }
        }

        //insere valor total de usuarios amostrar
        $(".total-situacao .situacao-contador").html($total);
    }

    //Verifica se arquivo existe passando a url com nome e extenção
    function Existe(url) {
        $http = new XMLHttpRequest();
        $http.open('HEAD', url, false);
        $http.send();
        return $http.status != 404;
    }

    //Extrai Selos
    function Insere_Selos_situacao(usuario, selos){
        $selos_usuario = parseInt(usuario["situacao"]);
        $selos = [];
        $desc = [];
        $codigo_selo = [];
        $retorno = [];
        selos.forEach(function(valor, key){
            if($selos_usuario >= parseInt(valor["codigo"])){
                $selos_usuario -= parseInt(valor["codigo"]);
                
                //qtd selos no grupo
                if(selos[key]["qtd"] > 0){
                    selos[key]["qtd"]++;
                }
                else{
                    selos[key]["qtd"] = 1;
                }

                $codigo_selo.push(parseInt(valor["codigo"]));

                switch(parseInt(valor["codigo"])){
                    case 1: 
                        $selos.push("url('../img/pronto.png')");
                        break;
                    case 2: 
                        $selos.push("url('../img/home_office.png')");
                        break;
                    case 4: 
                        $selos.push("url('../img/ferias.png')");
                        $desc.push("cancelado");
                        break;
                    case 8: 
                        $selos.push("url('../img/curso.png')");
                        $desc.push("cancelado");
                        break;
                    case 16: 
                        $selos.push("url('../img/missao.png')");
                        $desc.push("cancelado");
                        break;
                    case 32: 
                        $selos.push("url('../img/servico.png')");
                        break;
                    case 64: 
                        $selos.push("url('../img/dispensado.png')");
                        $desc.push("cancelado");
                        break;
                    case 512: 
                        $selos.push("url('../img/dispensa_medica.png')");
                        $desc.push("cancelado");
                        break;
                    default:
                        $desc.push(valor["descricao"]);
                        $desc.push("cancelado");
                        break;
                }
            }
            else{
                if(!selos[key]["qtd"]){
                    selos[key]["qtd"] = 0;
                }
                return false;
            }
        });
        $selos_unicos = [...new Set($selos)];
        $desc_unicos = [...new Set($desc)];
        $codigo_selo.push(0);//add codigo zero , pois, para selecionar todos usuarios é necessario ter o selo_id=0
        $retorno["img"] = $selos_unicos.join([separador = ',']);
        $retorno["texto"] = $desc_unicos.join([separador = ',']);
        $retorno["codigo"] = $codigo_selo.join([separador = ' ']);
        
        return $retorno;
    }

    //Inserir link nas imagens
    function Inserir_link_img_selos(selos){
        selos.forEach(function(valor, key){
            switch(parseInt(valor["codigo"])){
                case 1: 
                    selos[key]["img"] = '../img/pronto.png';
                    break;
                case 2: 
                    selos[key]["img"] = '../img/home_office.png';
                    break;
                case 4: 
                    selos[key]["img"] = '../img/ferias.png';
                    break;
                case 8: 
                    selos[key]["img"] = '../img/curso.png';
                    break;
                case 16: 
                    selos[key]["img"] = '../img/missao.png';
                    break;
                case 32: 
                    selos[key]["img"] = '../img/servico.png';
                    break;
                case 64: 
                    selos[key]["img"] = '../img/dispensado.png';
                    break;
                case 512: 
                    selos[key]["img"] = '../img/dispensa_medica.png';
                    break;
                default:
                    selos[key]["img"] = '../img/cancelado_mini.png';
                    break;
            }
        });
    }

    //Extrair funcoes usuarios // ADAPTADO
    function Insere_funcoes_usuarios_adaptado(usuario, funcoes){
        $funcao_usuario = parseInt(usuario["funcao"]);
        $funcoes = "";
        $primeiro = true;
        funcoes.forEach(function(valor, key){
            if($funcao_usuario >= parseInt(valor["codigo"])){
                $funcao_usuario -= parseInt(valor["codigo"]);
                if(!$primeiro){
                    $funcoes += ", ";
                }
                else{
                    $primeiro = false;
                }
                $funcoes += valor["nome"];
            }
        })
        return $funcoes;
    }

});
$(document).ready(function(){
    $link = "../";
    
    $mi = Get_url_variaveis();
    if( $mi == -1){
        alert("A página precisa de um valor de MI, add no final da url ex: ?mi=1513-2-NE");
    }
    else{
        $mi = $mi.get("mi");
        Mi_informacoes();
    }

    //FUNÇÕES

    //Insere todas informações do MI na pagina Mi_informacoes
    function Mi_informacoes(){
        $.get($link+'php/conexao_mi.php', {
            mi: $mi
            }, 
            function(carta){
                console.log(carta);
                if(carta == 0){
                    alert("Erro ao consultar carta!");
                }
                else if(carta == 1){
                    alert("Carta fora do projeto, escolha outra carta!");
                }
                else{

                    //apaga dados antigos dos campos para serem preenchidos os novos dados.
                    $(".informacoes-mi-descricao, .div-text, .mi-ligacao-individuais, .nome-carta").text("");

                    Inserir_dados_div_info_mi_descricao(carta);

                    Add_nome_mi_ligacao_no_html(carta);

                    //nome mi
                    $(".nome-carta").append(carta["nome_carta"]);
                
                }
            }
        )
    }

    //Insere so dados na DIV info_mi_descricao
    function Inserir_dados_div_info_mi_descricao(carta){

        Object.keys(carta).forEach(function(item){
            if(carta[item] == null){
                carta[item] = "";
            }
        });
  
        $fuso = carta["inom"].substring(3, 5);
        $epsg = '';
        $mc = ''
        if($fuso == '23'){
            $epsg = '31983';
            $mc = '-45'
        }
        else if($fuso == '24'){
            $epsg = '31984';
            $mc = '-39'
        }

        $info_mi_desc = 
            '<div class="titulo"><span>INFORMAÇÕES</span></div>'+
            '<hr><ul>'+
            '<li><span>ID:</span> ' + carta["id"] + '</li>'+
            '<li><span>Bloco:</span> ' + carta["bloco"] + '</li>'+
            '<li><span>INOM:</span> ' + carta["inom"] + '</li>'+
            '<li><span>Fuso:</span> ' + $fuso + 'S</li>'+
            '<li><span>EPSG:</span> ' + $epsg + '</li>'+
            '<li><span>MC:</span> ' + $mc + '</li>'+
            '<li><span>SRV-GOTHIC:</span> ' + carta["servidor"] + '</li>'+
            '<li><span>Dificuldade:</span> ' + carta["niveis"] + '</li>'+
            '<li><span>Densidade:</span> ' + carta["densidade"] + '</li>'+
            '<li><span>Fase:</span> ' + carta["status"] + '</li>'+
            '</ul><hr><ul>'+
            '<li><span>Editor:</span> <a class="link" href="Usuario_informacoes.php?id='+carta["id_editor"]+'">' + carta["editor"] + '</a></li>'+
            '<li><span>Início Edição:</span> ' + carta["inicioEdicao"] + '</li>'+
            '<li><span>Término Edição:</span> ' + carta["terminoEdicao"] + '</li>'+
            '</ul><hr><ul>'+
            '<li><span>1º Revisor:</span> <a class="link" href="Usuario_informacoes.php?id='+carta["id_revisor1"]+'">' + carta["revisor1"] + '</a></li>'+
            '<li><span>Início 1ª Rev:</span> ' + carta["inicio1rev"] + '</li>'+
            '<li><span>Término 1ª Rev:</span> ' + carta["termino1rev"] + '</li>'+
            '</ul><hr><ul>'+
            '<li><span>Início 1ª Correção:</span> ' + carta["inicioCorrecao1"] + '</li>'+
            '<li><span>Término 1ª Correção:</span> ' + carta["terminoCorrecao1"] + '</li>'+
            '</ul><hr><ul>'+
            '<li><span>Impressa:</span> ' + Sim_Nao(carta["impressa"]) + '</li>'+
            '<li><span>Ligação:</span> ' + Sim_Nao(carta["ligacao"]) + '</li>'+
            '<li><span>2º Revisor:</span> <a class="link" href="Usuario_informacoes.php?id='+carta["id_revisor2"]+'">' + carta["revisor2"] + '</a></li>'+
            '<li><span>Início 2ª Rev:</span> ' + carta["inicio2rev"] + '</li>'+
            '<li><span>Término 2ª Rev:</span> ' + carta["termino2rev"] + '</ul>'+
            '</ul><hr><ul>'+
            '<li><span>Início 2ª Correção:</span> ' + carta["inicioCorrecao2"] + '</li>'+
            '<li><span>Término 2ª Correção:</span> ' + carta["terminoCorrecao2"] + '</li>';

            
        $(".informacoes-mi-descricao").append($info_mi_desc);
    }

    //Função  Booleana retorn Sim ou Não
    function Sim_Nao(valor){
        $val = String(valor).toLowerCase();
        if( ($val == 't') || ($val == 'true') || ($val == '1') || ($val == 'sim')){
            return "Sim";
        }
        return "Não";
    }

    //Add o nome dos MI que fazem a lgacao na tabela do HTML
    function Add_nome_mi_ligacao_no_html(carta){

        $(".div-text, #mi-ligacao_c").html(carta["mi"]);
        $("#mi-ligacao_o").html(Mi_ligação_manipula_dados(carta["ligacao_o"], "o"));
        $("#mi-ligacao_s").html(Mi_ligação_manipula_dados(carta["ligacao_s"], "s"));
        $("#mi-ligacao_se").html(Mi_ligação_manipula_dados(carta["ligacao_se"], "se"));
        $("#mi-ligacao_so").html(Mi_ligação_manipula_dados(carta["ligacao_so"], "so"));
        $("#mi-ligacao_l").html(Mi_ligação_manipula_dados(carta["ligacao_l"], "l"));
        $("#mi-ligacao_n").html(Mi_ligação_manipula_dados(carta["ligacao_n"], "n"));
        $("#mi-ligacao_no").html(Mi_ligação_manipula_dados(carta["ligacao_no"], "no"));
        $("#mi-ligacao_ne").html(Mi_ligação_manipula_dados(carta["ligacao_ne"], "ne"));
        
        Verifica_merge_mi_ligacao_add_cor_status(carta);

    }

    //verifica mi ligacao com valores iguais, por conta da diferença de escala, e faz merge
    function Verifica_merge_mi_ligacao_add_cor_status(carta){
        $map = new Map();
        $map.set("no", carta["ligacao_no"]);
        $map.set("n", carta["ligacao_n"]);
        $map.set("ne", carta["ligacao_ne"]);
        $map.set("o", carta["ligacao_o"]);
        $map.set("c", carta["mi"]);
        $map.set("l", carta["ligacao_l"]);
        $map.set("so", carta["ligacao_so"]);
        $map.set("s", carta["ligacao_s"]);
        $map.set("se", carta["ligacao_se"]);

        $map.forEach(function(valor, key, map){
            
            //cor status
            $bg_color = $("#fase_"+carta["status_"+key]).css("background-color");
            $("#mi-ligacao_"+key).css("background", $bg_color);

            //Mergear ligacao
            map.forEach(function(valor_2, key_2){
                if((valor == valor_2) && (key != key_2)){
                    $switch = key+"_"+key_2;
                    switch($switch){
                        case "no_o":
                        case "o_so":
                        case "l_se":
                        case "ne_l":
                            Merge_mi_ligacao(key, key_2, false);
                            break;
                        case "no_n":
                        case "n_ne":
                        case "so_s":
                        case "s_se":
                            Merge_mi_ligacao(key, key_2, true);
                        break;
                    }
                }
            });
        });
    }

    //Merge mi de ligação iguais colspan boolean
    function Merge_mi_ligacao(ligacao_permanecera, ligacao_sumira, colspan){
        $("#mi-ligacao_"+ligacao_sumira).css("display","none");
        $span = "rowspan";
        if(colspan){
            $span = "colspan";
        }
        $("#mi-ligacao_"+ligacao_permanecera).attr($span, 2);
    }

    //trata a informação quando o MI liga com mais de um carta na mesma direção, quando ha mudança de escala (50k <-> 25k)
    function Mi_ligação_manipula_dados(mi_ligacao, direcao){
        $retorno = "<span><a href=\"Mi_informacoes.php?mi="+mi_ligacao+"\">"+mi_ligacao+"</a></span>";
        if(mi_ligacao.indexOf(",") > 0){
            $array = mi_ligacao.split(",");
            $array.sort();
            switch(direcao){
                case "l":
                case "o":
                    $retorno = "<span><a href=\"Mi_informacoes.php?mi="+$array[0]+"\">"+$array[0]+"</a></span><hr><span><a href=\"Mi_informacoes.php?mi="+$array[1]+
                        "\">"+$array[1]+"</a></span>";
                    break;
                case "s":
                case "n":
                    $retorno = "<div class=\"mi-ligacao-individuais-rotacao\"><span><a href=\"Mi_informacoes.php?mi="+$array[1]+"\">"+$array[1]+
                        "</a></span><hr><span><a href=\"Mi_informacoes.php?mi="+$array[0]+"\">"+$array[0]+"</a></span></div>";
                    break;
            }
        }
        return $retorno;
    }

    //Pegar variaveis get na url -> retorna um MAP -> se sem variaveis retorna -1
    function Get_url_variaveis(){
        if(String(location).indexOf("?") > 0){
            $url = location.search.slice(1);
            $url_map = new Map();
            if($url.indexOf("&") > 0){
                $get_urls = $url.split('&');
                $get_urls.forEach(function(valor, $key){
                    $array = valor.split('=');
                    $url_map.set($array[0], $array[1]);
                })
            }
            else{
                $array = $url.split('=');
                $url_map.set($array[0], $array[1]);
            }
            return $url_map;
        }
        return -1;
    }
});
<?php

    if(!isset($link)) $link = "../";

    include_once $link."php/conexao.php";

    if( (!isset($_GET["usuario"]) OR !isset($_GET["mi"]) OR !isset($_GET["tipo"]) ) && ( (intval($_GET["tipo"]) == 1) OR (intval($_GET["tipo"]) == 2) ) ){
        echo 0; //ERRO SERÁ TRATADO NO JS, ERRO: FALTA DE PARÂMETRO
    }
    else{
        //DEFINE AS VARIAVEIS
        date_default_timezone_set('America/Recife');
        $data_inicio_correcao = date('Y') . "-" . date('m') . "-" . date('d') . " " . date("H") . ":" . date("i") . ":" . date("s");
        $editor = strval($_GET["usuario"]);
        $mi = strval($_GET["mi"]);
        $tipo = intval($_GET["tipo"]);
        $status_origem = "6";
        $status_destino = "60";
        if($tipo == 2){
            $status_origem = "8";
            $status_destino = "80";
        }

        //QUERY para Pedir carta 
        $sql = "
            --Faz o pedido da carta para correção<br>
            UPDATE public.edicao SET status = '$status_destino', iniciocorrecao$tipo = '$data_inicio_correcao' 
                WHERE mi = '$mi' AND editor = '$editor' AND status = '$status_origem' AND (iniciocorrecao$tipo isnull OR length(iniciocorrecao$tipo) < 1)
            --Faz o retorno da linha atualizada pela query<br>
            RETURNING id, editor;";
        
        $query = pg_query($conexao,$sql);
        if($query) { 

            if(pg_fetch_all($query)){
            
                $row = pg_fetch_all($query);
                
                if(count($row) > 0){
                    //SUCESSO
                    echo 10;
                }
                else{
                    echo 4;
                }
            }
            else{
                echo 6;//Limite usuário no servidor ou não há cartas disponíveis
            }
        }
        else{
            echo 3; //ERRO SERÁ TRATADO NO JS, ERRO ONDE NÃO HOUVE conexão NO banco de dados, 
                    //possívelmente não solicitou carta, se aparecer nas pendentes verificar com adm
        }
    }

?>
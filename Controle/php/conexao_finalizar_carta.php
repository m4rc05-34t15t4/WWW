<?php

    if(!isset($link)) $link = "../";

    include_once $link."php/conexao.php";

    if( !isset($_GET["usuario"]) OR !isset($_GET["mi"]) OR !isset($_GET["tipo"]) ){
        echo 0; //ERRO SERÁ TRATADO NO JS, ERRO: FALTA DE PARÂMETRO
    }
    elseif( !strpos($_GET["mi"], "-") > 0){
        echo 1; //ERRO SERÁ TRATADO NO JS, ERRO: mi com dado errado
    }
    elseif(($_GET["tipo"] != "edicao") AND ($_GET["tipo"] != "1rev") AND ($_GET["tipo"] != "correcao1") AND ($_GET["tipo"] != "2rev")  AND ($_GET["tipo"] != "correcao2")){
        echo 3; //ERRO SERÁ TRATADO NO JS, ERRO: campo tipo especificado errado.
    }
    else{
        //DEFINE AS VARIAVEIS
        date_default_timezone_set('America/Recife');
        $data_final = date('Y') . "-" . date('m') . "-" . date('d') . " " . date("H") . ":" . date("i") . ":" . date("s");
        $usuario = strval($_GET["usuario"]);
        $mi = strval($_GET["mi"]);
        $tipo = strval($_GET["tipo"]);

        $status = "";
        $funcao = "";
        $termino = "termino" . $tipo;

        switch($tipo){
            case "edicao":
                $status = "4";
                $funcao = "editor";
                break;
            case "1rev":
                $status = "61";//SERIA 6, mas foi alterado para não haver 1ª correção
                $funcao = "revisor1";
                break;
            case "correcao1":
                $status = "61";
                $funcao = "editor";
                break;
            case "2rev":
                $status = "81";//SERIA 8, mas foi alterado para não haver 1ª correção
                $funcao = "revisor2";
                break;
            case "correcao2":
                $status = "81";
                $funcao = "editor";
                break;  
        }

        //Faz a SQL na tabela edicao - finaliozar cartas edição
        $sql = "UPDATE public.edicao SET status = '$status', " . $termino . " = '$data_final' WHERE mi = '$mi' AND " . $funcao . " = '$usuario';";
        $query = pg_query($conexao,$sql);
        if($query) {
            //codigo de sucesso
            echo 10;
        }
        else{
            echo 2; //ERRO SERÁ TRATADO NO JS, ERRO ONDE NÃO HOUVE conexão NO banco de dados, 
                    //possívelmente não solicitou carta, se aparecer nas pendentes verificar com adm
        }
    }

?>
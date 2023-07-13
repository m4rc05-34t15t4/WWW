<?php

//Cria a conexão com o bd
//$con_string = "host=10.46.136.30 port=5432 dbname=Combater_2023 user=postgres password=admin";
$conexao = pg_connect($con_string);
if(!$conexao){
    echo "Erro ao acessar banco de dados!";
    exit;
}

function consulta($conexao, $sql){
    $query = pg_query($conexao, $sql);
    if($query) { 
        if(pg_fetch_all($query)){
            $row = pg_fetch_all($query);
            if(count($row) > 0) return [true, $row];
            else return [false, "Consulta e Branco!"];
        }
        else return [false, "Erro ao capturar dados!"];
    }
    else return [false, "Não houve conexão no banco de dados!"];
}

?>
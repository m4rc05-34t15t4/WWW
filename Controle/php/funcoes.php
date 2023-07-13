<?php

date_default_timezone_set('America/Recife');

//Verifica se Existwe || se nulo || se vazio
function validar_variavel_miss($variavel){
    if(isset($variavel)){
        if((!is_null($variavel)) AND (!empty($variavel))){
            return true;
        }
    }
    return false;
}

//Retornar Descrição Status pelo codigo
function status_desc($status, $conexao){
    if(!is_null($status)){
        $sql = "SELECT \"descricao\" FROM \"public\".\"Fases_Edicao\" WHERE \"codigo\" = '" . $status . "'";
        $query = pg_query($conexao,$sql);
        if($query) {
            $row_aux = pg_fetch_all($query);
            return $row_aux[0]["descricao"];
        }
    }
    return $status;
}

//Retornar MI de ligação com a carta passada
function ligacao_mi($mi, $posicao, $conexao){
    if(!is_null($mi)){
        $sql = "SELECT " . $posicao . " FROM \"public\".\"ligacao_mi\" WHERE \"mi\" = '" . $mi . "'";
        $query = pg_query($conexao,$sql);
        if($query) {
            $row_aux = pg_fetch_all($query);
            return $row_aux[0][$posicao];
        }
    }
    return $posicao;
}

//Faz busca na Tabela edicao
function mi_status_code($mi, $campo, $conexao){
    if(!is_null($mi)){
        $sql = "SELECT " . $campo . " FROM \"public\".\"edicao\" WHERE \"mi\" = '" . $mi . "'";
        $query = pg_query($conexao,$sql);
        if($query) {
            $row_aux = pg_fetch_row($query);
            if(is_array($row_aux)){
                return $row_aux[0];
            }
        }
    }
    return "0";
}

//Faz busca na Tabela funcoes
function get_funcao($funcao, $campo, $conexao, $reverse = false){
    if(!is_null($funcao)){
        $desc = "";
        if($reverse == true){
            $desc = " ORDER BY codigo DESC";
        }
        $where = " WHERE \"codigo\" = '" . $funcao . "'";
        if(($funcao == "all") OR ($funcao == 0) OR (empty($funcao))){
            $where = "";
        }
        $sql = "SELECT " . $campo . " FROM \"public\".\"funcoes\"" . $where . $desc;
        $query = pg_query($conexao,$sql);
        if($query) {
            $row_aux = pg_fetch_all($query);
            if(pg_fetch_all($query)){
                return $row_aux;
            }
        }
    }
    return "0";
}

//Verifica se é nulo
function E_null($valor){
    if(!is_null($valor) AND (strtolower($valor) != "null") AND ($valor != "")){
        return false;
    }
    return true;
}

//faz consulta sql
function Consulta_sql($sql){

    global $conexao;

    $query = pg_query($conexao,$sql);
    if($query) {
        if(pg_fetch_all($query)){
            return pg_fetch_all($query);
        }
    }
    return 0; 
}

?>
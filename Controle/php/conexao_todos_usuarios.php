<?php

if(!isset($link)) $link = "../";

include_once $link."php/conexao.php";

include_once $link."php/funcoes.php";

//verifica quais funções deve ser buscadas
$where = "";
//verifica se a variavel foi iniciada
if(isset($_GET["funcao"])){
    if(($_GET["funcao"] != "all") AND (!empty($_GET["funcao"]))){
        $where = " WHERE \"funcao\" = '" . $_GET["funcao"] . "'";
    }
}
else{
    $_GET["funcao"] = "";
}

//define order by
$order_by = " ORDER BY \"funcao\" ASC, \"nome\" ASC";
if(isset($_GET["ordenar"])){
    switch(strtolower($_GET["ordenar"])){
        case "funcao": $order_by = " ORDER BY \"funcao\" ASC, \"nome\" ASC";
            break;
        case "nome": $order_by = " ORDER BY \"nome\" ASC";
            break;
        case "situacao": $order_by = " ORDER BY \"situacao\" ASC";
            break;
        case "posto-graduacao":
            $order_by = " ORDER BY \"posto_graduacao\" ASC";  
            break;
    }
}

//Busca dados das Funções dos usuarios
$get_funcao = get_funcao($_GET["funcao"], "*", $conexao, true);

//Busca dados situação usuario
$sql = "SELECT * FROM \"public\".\"situacao\" ORDER BY \"codigo\" DESC";
$get_sitiacao = Consulta_sql($sql);

//Busca dados posto graduação usuario
$sql = "SELECT * FROM \"public\".\"postos_graduacoes\" ORDER BY \"codigo\" ASC";
$get_posto_graduacao = Consulta_sql($sql);

//Faz a busca na tabela
$sql = "SELECT * FROM \"public\".\"usuarios\"" . $where . $order_by;
$query = pg_query($conexao,$sql);
if(!$query) {
    //Retorna Numero de erro de conexão com o bd
    echo 0; 
}
elseif(!pg_fetch_all($query)){
    echo 1;
}
else{

    //retorna linhas da consulta
    $row = pg_fetch_all($query);
    
    //exibir pagina como json
    header('Content-Type: application/json');
    
    //cria json com array de usuarios e array de funcoes
    $result = array(
        "usuarios" => $row,
        "descricao_funcoes" => $get_funcao,
        "descricao_situacao" => $get_sitiacao,
        "descricao_posto_graduacao" => $get_posto_graduacao
    );

    //exibe
    echo json_encode($result);
}

?>
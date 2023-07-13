<?php

if(!isset($link)) $link = "../";

if( (!isset($_GET["login"])) OR (!isset($_GET["senha"])) OR (!isset($_GET["codigo"])) OR ($_GET["login"] == "") OR ($_GET["senha"] == "") OR ($_GET["codigo"] == "")){
    echo "Faltando variaveis, login, senha ou codigo!";
} 
else{

    include_once $link."php/conexao.php";

    $login = $_GET["login"];
    $senha = $_GET["senha"];
    $codigo = $_GET["codigo"];

    //Faz a busca na tabela
    $sql = "UPDATE public.usuarios SET login = '" . $login . "', senha = '" . base64_encode($senha) . "' WHERE codigo = '" . $codigo . "'";
    $query = pg_query($conexao,$sql);
    if($query) {
        echo "Usuario atualizado com sucesso!"; 
    }
    else{
        echo "Erro: tente novamente"; 
    }
}

?>
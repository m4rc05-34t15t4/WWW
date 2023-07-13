<?php

    if(!isset($link)) $link = "../";

    include_once $link."php/conexao.php";

    session_start();

    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $pagina = $_POST['pagina'];
    
    $sql= "SELECT * FROM public.usuarios WHERE login = '" . $login . "' AND senha = '" . base64_encode($senha) . "'";
    $query = pg_query($conexao,$sql);

    if(pg_num_rows($query) > 0){

        if(pg_fetch_all($query)){

            $row = pg_fetch_row($query);

            $_SESSION['codigo'] = $row[0];
            $_SESSION['usuario'] = $row[1];
            $_SESSION['funcao'] = $row[2];
            $_SESSION['login'] = $row[3];
            $_SESSION['senha'] = $row[4];
            $_SESSION['pagina'] = $pagina;
        }
    }
    else{
    unset ($_SESSION['login']);
    unset ($_SESSION['senha']);
    unset ($_SESSION['pagina']);
    unset ($_SESSION['codigo']);
    unset ($_SESSION['usuario']);
    unset ($_SESSION['funcao']);
    }

    header('location:'.$pagina);

?>
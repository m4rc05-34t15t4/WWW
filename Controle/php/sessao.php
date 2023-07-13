<?php

$arr = explode("/", $_SERVER['REQUEST_URI']);
$pagina = end($arr);

session_start();

if(((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)) OR !isset($_SESSION['codigo']) OR !isset($_SESSION['usuario']) OR 
    !isset($_SESSION['funcao']) ){
        unset ($_SESSION['login']);
        unset ($_SESSION['senha']);
        unset ($_SESSION['pagina']);
        unset ($_SESSION['codigo']);
        unset ($_SESSION['usuario']);
        unset ($_SESSION['funcao']);
        if($pagina != "Todos_mi.php"){
            header('location:Todos_mi.php');
        }
}
else{
    $_SESSION['pagina'] = $pagina;
}

?>
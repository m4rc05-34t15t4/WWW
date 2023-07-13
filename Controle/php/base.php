<?php 

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache"); 
    header("Refresh:1800");//recarrega em 30min

    if(!isset($link)){$link = "../";}
    include_once $link."php/sessao.php";

    $Versao = "?v=3.0";

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <title>Controle Produção</title>
        <meta name="keywords" content="HTML5, CSS3, frontend, Controle, Projeto, EB">
        <meta name="description" content="Controle">
        <meta name="version" content="3.0">
        <meta name="author" content="3º Sgt Topo Marcos Batista">
        <link rel="stylesheet" type="text/css" href="<?php echo $link."css/reset.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $link."css/style.css$Versao"; ?>"/>
        <script src="<?php echo $link."js/jquery-3.5.0.js"; ?>"></script>
        <script src="<?php echo $link."js/Cabecalho.js$Versao"; ?>"></script>
        <script src="<?php echo $link."js/funcoes.js$Versao"; ?>"></script>

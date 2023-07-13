<?php 
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
    $V = "1.1.0";
    $Versao = "?v=".$V;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <title>Exame Pagamento</title>
        <meta name="keywords" content="HTML5, CSS3, frontend, Exame Pagamento, EB">
        <meta name="description" content="Ficha Auxiliar Exame Pagamento">
        <meta name="version" content="<?php echo $V; ?>">
        <meta name="author" content="2º Sgt Topo Marcos Batista">
        <meta name="OM" content="3º CGEO">
        <meta name="contato" content="81-994941677">
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <link rel="stylesheet" type="text/css" href="<?php echo "../css/reset.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo "../css/style.css$Versao"; ?>"/>
        <script src="<?php echo "../js/jquery-3.5.0.js"; ?>"></script>
        <script src="<?php echo "../js/funcoes.js$Versao"; ?>"></script>
        <script src="<?php echo "../js/jquery.mask.min.js$Versao"; ?>"></script>
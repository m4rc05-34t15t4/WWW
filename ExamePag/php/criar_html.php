<?php
   #header('Content-Type: text/html; charset=utf-8');

   $texto = $_POST["tabela"];
   $nome_arquivo = $_POST["nome_arq"];

    $fp = fopen("../fichas_auxiliares/".$nome_arquivo.".html" , "w");
    $fw = fwrite($fp, $texto);
    if($fw == strlen($texto))  echo ' arquivo criado ';
    else echo 'falha ao criar arquivo';
?>

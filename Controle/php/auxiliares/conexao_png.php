<?php

//Cria a conexão com o bd
$con_string = "host=localhost port=5432 dbname=Controle user=postgres password=postgres";
$conexao = pg_connect($con_string);
if(!$conexao){
    echo "Erro ao acessar banco de dados!";
    exit;
}

$ds = ibase_query($conexao,'SELECT ST_AsPNG(ST_AsRaster(geom,1000, 1000)) FROM "public"."blocos"');

$row=ibase_fetch_row($ds,IBASE_TEXT);

header('Content-type: image/png');

echo $row[0];

?>
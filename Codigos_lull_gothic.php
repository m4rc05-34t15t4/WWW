<?php

header('Content-Type: text/html; charset=utf-8');

$arquivo_txt = "codigos_lull_all.txt";
$replace_texto = "C:\Marcos_Batista\DGEO\Gothic\codigos\\";
$codigo_cmd = "cd $replace_texto && ";
$contador = 0;
$codigos = [];

$link_arquivos_lull = file("C:\Marcos_Batista\DGEO\Gothic\codigos\link_arquivos_lull.txt");
foreach($link_arquivos_lull as $link){
    if(strripos($link, ".lull")){

        $contador++;
        
        $link = str_replace($replace_texto, "", $link);

        $codigo_cmd .= "
            echo >> $arquivo_txt && 
            echo >> $arquivo_txt && 
            echo >> $arquivo_txt && 
            echo ############################## $link ############################## >> $arquivo_txt && 
            echo >> $arquivo_txt && 
            echo >> $arquivo_txt && 
            echo >> $arquivo_txt &&
            type $link >> $arquivo_txt
        ";

        if($contador < 10){
            $codigo_cmd .= " && ";
        }
        else{
            $contador = 0;
            array_push($codigos, $codigo_cmd);
            $codigo_cmd = "";
        }
    }
}

//var_dump($codigos);

foreach($codigos as $lista){
    echo $lista;
    echo "<hr>";
}

?>
<?php
    if( !isset($_GET["idt_mil"])) echo 0; //ERRO SERÁ TRATADO NO JS, ERRO: FALTA DE PARÂMETRO
    else{
        //exibir pagina como json
        header('Content-Type: application/json');
        //cria json
        $resultado = [];
        $path = "../fichas_auxiliares/";
        $diretorio = dir($path);
        while($arquivo = $diretorio -> read()) if(preg_match("/{$_GET["idt_mil"]}/", $arquivo)) array_push($resultado, $arquivo);
        $diretorio -> close();
        //exibe
        echo json_encode($resultado);
    }
?>

<?php
   // Determina que o arquivo é uma planilha do Excel
   //header("Content-type: application/x-msexcel; charset=utf-8");   

   // Força o download do arquivo
   //header("Content-type: application/force-download");  

   // Seta o nome do arquivo
   //header("Content-Disposition: attachment; filename=file.xls");

   //header("Pragma: no-cache");

   //header("Expires: mon 26 Jul 1997 05:00:00 GTM");

   //header("Cache-Control: no-cache, must-revalidate"); 

   #header('Content-Type: text/html; charset=utf-8');


   //echo $_GET["ficha_auxiliar"];

   $nome = explode('_', $_GET["ficha_auxiliar"], -1)[0];

?>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <title><?php echo $nome." - Ficha Auxiliar - Exame Pagamento"; ?></title>
        <meta name="keywords" content="HTML5, CSS3, frontend, Exame Pagmanto, Projeto, EB">
        <meta name="description" content="Exportar Contra-cheque">
        <meta name="version" content="1.0">
        <meta name="author" content="3º Sgt Topo Marcos Batista">
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css?v=1.0.0"/>
        <style>
            body {
                font-size: 10pt !important;
                display: block;
                background-color: white;
            }

            b {
                font-weight: 600;
            }

            u {
                text-decoration: underline;
            }

            i {
                font-style: italic;
            }

            #content {
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100%;
                padding: 0;
                margin: 0;
                align-items: center;
                justify-content: center;
            }

            #content-contracheque {
                display: block;
                text-align: center;
            }
            
            #ficha_auxiliar {
                margin: 50px;
                border: none;
                max-width: 50%;
            }

            #tr_receita, #tr_despesa {
                border: solid 1px black;
            }

            #ficha_auxiliar tr td{
                font-size: 10pt !important;
            }

            #rodape_data {
                border-top: solid 1px black !important;
            }

            #tr_despesa .dados_tipo, #tr_receita .dados_tipo {
                border-bottom : none !important;
            }

            #ficha_auxiliar #rodape_responsavel, #ficha_auxiliar #rodape_data {
                font-size: 12pt !important;
            }

            #ficha_auxiliar #rodape_responsavel span {
                border-top: solid 1px black;
                padding: 5pt;
            }

            #ficha_auxiliar #rodape_data {
                padding: 15pt; 
            }

            #ficha_auxiliar .cabecalho:nth-child(3) td {
                border-bottom : solid 1px black !important;
            }

            #despesa tr:nth-child(1) td {
                border-top: none;
            }
        </style>
</head>
    <body>

<?php

    include_once "../fichas_auxiliares/".$_GET["ficha_auxiliar"].".html";

?>

    </body>
</html>
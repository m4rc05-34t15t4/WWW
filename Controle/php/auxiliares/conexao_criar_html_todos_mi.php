<?php 
    if(!isset($link)) $link = "../../";
    
    include_once $link."php/base.php";
    include_once $link."php/conexao.php";
?>

</head>
    <body>
        <div class="todos-mi">
            <div class="blocos">
                <?php 
                    echo Criar_tabela_todos_blocos(); 
                ?>   
            </div>  
        </div>
    </body>
</html>

<?php

    //FUNÇÕES

    //Cria Tabela com celulas
    function Criar_tabela_todos_blocos(){

        global $div_bloco_conteudo;
        global $css_bloco_posicao;
        global $tabelas_enumeradas;

        $sql = "SELECT ligacao.mi, ligacao.linha, ligacao.coluna, ligacao.regiao, edicao.bloco FROM \"public\".\"ligacao_mi\" as ligacao 
                LEFT JOIN \"public\".\"edicao\" ON ligacao.mi = edicao.mi ORDER BY ligacao.linha, ligacao.coluna, ligacao.mi";
        
        if(Fazer_conexao($sql)) {

            //Cria variaveis auxiliares
            Cria_variaveis_auxiliares();

            //popula variaveis auxiliares
            
            Popula_variaveis_auxiliares(Fazer_conexao($sql));
            
            //Cria TAG HTML tabela
            $tabela = Criar_html_tabela();

            //Cria css Div blocos posicao
            Criar_css_posicao_div_blocos();

            //Cria Div Blocos conteudo
            Criar_div_blocos();

            //Cria a tabela enumerada das linhas e colunas
            Cria_tabela_enumerada();

            //Define o Content
            $content = $tabela . "\n\n\n" . $div_bloco_conteudo . "\n\n" . $tabelas_enumeradas . "\n\n" . $css_bloco_posicao;
            
            return $content;
        }
        
        return "Não foi possivel fazr a conexão com o Banco de Dados.";
    }

    //Cria variaveis auxiliares
    function Cria_variaveis_auxiliares(){
        $GLOBALS["lista_regiao"] = array();
        $GLOBALS["lista_linha"] = array();
        $GLOBALS["lista_coluna"] = array();
        $GLOBALS["lista_bloco"] = array();
        $GLOBALS["lista_celulas_criadas"] = array();
        $GLOBALS["lista_celulas_mi_info"] = array();
        $GLOBALS["lista_mi_central_bloco"] = array();
        $GLOBALS["max_linha"] = 0;
        $GLOBALS["min_linha"] = 0;
        $GLOBALS["max_coluna"] = 0;
        $GLOBALS["min_coluna"] = 0;
        $GLOBALS["qtd_linha"] = 0;
        $GLOBALS["qtd_coluna"] = 0;
        $GLOBALS["div_bloco_conteudo"] = "";
        $GLOBALS["css_bloco_posicao"] = "";
        $GLOBALS["tabelas_enumeradas"] = "";
    }

    //Cria Tabela com a numeração das linhas e colunas
    function Cria_tabela_enumerada(){

        global $min_linha;
        global $min_coluna;
        global $qtd_linha;
        global $qtd_coluna;
        global $tabelas_enumeradas;

        $tabelas_enumeradas = "<!--Tabela das linhas -->\n<table id=\"tabela-bloco-enumerada-linha\" class=\"tabela-blocos-enumerada\">\n";
        for($e=$min_linha; $e <= $qtd_linha; $e++){
            $tabelas_enumeradas .= "    <tr><td>" . $e . "</td></tr>\n";
        }
        $tabelas_enumeradas .= "</table>\n\n<!--Tabela das colunas -->\n<table id=\"tabela-bloco-enumerada-coluna\" class=\"tabela-blocos-enumerada\"><tr>\n";
        for($e=$min_coluna; $e <= $qtd_coluna; $e++){
            $tabelas_enumeradas .= "    <td>" . $e . "</td>\n";
        }
        $tabelas_enumeradas .= "</tr></table>";
    }

    //Cria CSS de posicao dos nomes dos Blocos e exibe como comentário no códido gonte da página
    function Criar_css_posicao_div_blocos(){

        global $css_bloco_posicao;
        global $lista_mi_central_bloco;

        //conecta ao banco de dados
        $sql = "SELECT 
            TRUNC(AVG(ligacao.linha), 0) AS linha_media, 
            TRUNC(AVG(ligacao.coluna), 0) AS coluna_media, edicao.bloco 
            FROM \"public\".\"ligacao_mi\" as ligacao 
            LEFT JOIN \"public\".\"edicao\" ON ligacao.mi = edicao.mi 
            GROUP BY edicao.bloco
            ORDER BY edicao.bloco;";
        $query = Fazer_conexao($sql);
        $row = pg_fetch_all($query);

        //escrevendo o css
        $css_bloco_posicao = "/* CSS Blocos Posicao */\n";
        /*#bloco_A1 {
            left: calc( var(--padding) + (var(--largura-mi-25k) * 40));
            top: calc( var(--padding) + (var(--largura-mi-25k) * 7));
        }*/
        for($b=0; $b < count($row); $b++){
            $css_bloco_posicao .= "#bloco_" . $row[$b]["bloco"] . 
                " {\n   left: calc( var(--padding) - (var(--largura-div-nome-bloco) / 2)  + (var(--largura-mi-25k) * " . $row[$b]["coluna_media"]  . "));\n" . 
                "   top: calc( var(--padding) - (var(--altura-div-nome-bloco) / 2)  + (var(--largura-mi-25k) * " . $row[$b]["linha_media"] . "));\n}\n";
                
                $lista_mi_central_bloco[$row[$b]["bloco"]]["linha_media"] = $row[$b]["linha_media"];
                $lista_mi_central_bloco[$row[$b]["bloco"]]["coluna_media"] = $row[$b]["coluna_media"];
        }
    }

    //Cria div nome dos blocos
    function Criar_div_blocos(){

        global $lista_bloco;
        global $div_bloco_conteudo;
        global $lista_mi_central_bloco;

        sort($lista_bloco);

        foreach($lista_bloco as $bloco){
            $mi_central = $lista_mi_central_bloco[$bloco]["linha_media"] . "x" . $lista_mi_central_bloco[$bloco]["coluna_media"];
            $div_bloco_conteudo .= "<div id=\"bloco_" . $bloco . "\" class=\"blocos-nome\" mi-central=\"" . $mi_central . "\">" . $bloco . "</div>\n";
        }

    }

    //faz consulta sql nos bancos edicao e ligacao_mi
    function Fazer_conexao($sql){
            
        global $conexao;

        return pg_query($conexao, $sql);
    }

    //popula variaveis auxiliares
    function Popula_variaveis_auxiliares($query){

        //retorna linhas da consulta
        $row = pg_fetch_all($query);
        
        global $lista_linha;
        global $lista_coluna;
        global $lista_regiao;
        global $lista_bloco;
        global $lista_celulas_mi_info;
        global $max_linha;
        global $min_linha;
        global $max_coluna;
        global $min_coluna;
        global $qtd_linha;
        global $qtd_coluna;

        for($i=0; $i < count($row); $i++){
            Insere_valor_lista($lista_linha, $row[$i]["linha"]);
            Insere_valor_lista($lista_coluna, $row[$i]["coluna"]);
            Insere_valor_lista($lista_regiao, $row[$i]["regiao"]);
            Insere_valor_lista($lista_bloco, $row[$i]["bloco"]);
            
            $celula = $row[$i]["linha"]."x".$row[$i]["coluna"];
            $span = 1; if(strlen($row[$i]["mi"]) < 9) $span = 2;

            $lista_celulas_mi_info[$celula]["bloco"] = $row[$i]["bloco"];
            $lista_celulas_mi_info[$celula]["regiao"] = $row[$i]["regiao"];
            $lista_celulas_mi_info[$celula]["mi"] = $row[$i]["mi"];
            $lista_celulas_mi_info[$celula]["span"] = $span;
        }

        $max_linha = $lista_linha[array_key_last($lista_linha)];
        $min_linha = $lista_linha[array_key_first($lista_linha)];
        $max_coluna = $lista_coluna[array_key_last($lista_coluna)];
        $min_coluna = $lista_coluna[array_key_first($lista_coluna)];
        $qtd_linha = $max_linha - $min_linha + 1;
        $qtd_coluna = $max_coluna - $min_coluna + 1;
    }

    //Inserir dados em variavel_lista
    function Insere_valor_lista(&$array, $valor){
        if(!in_array($valor, $array)){
            array_push($array, $valor);
            sort($array);
        }
    }

    //Cria TAG HTML tabela
    function Criar_html_tabela(){

        global $lista_celulas_mi_info;
        global $lista_celulas_criadas;
        global $min_linha;
        global $min_coluna;
        global $qtd_linha;
        global $qtd_coluna;

        $tabela = "<table linhas=\"" . $qtd_linha . "\" colunas=\"" . $qtd_coluna . "\">";
        
        //loop de linhas
        for($l = $min_linha; $l <= $qtd_linha; $l++){
            
            $tabela .= "\n<tr linha=\"" . $l . "\">";

            //loop de colunas
            for($c = $min_coluna; $c <= $qtd_coluna; $c++){

                $celula = $l."x".$c;
                $span = 1;
                $rowspan = "";
                $class = "";
                $bloco = "";
                $regiao = "";
                $mi = "";
                $classe = "";

                if(array_key_exists($celula, $lista_celulas_mi_info)){
                    $span = $lista_celulas_mi_info[$celula]["span"];
                    $bloco =  " bloco=\"" . $lista_celulas_mi_info[$celula]["bloco"] . "\"";
                    $regiao = " regiao=\"" . $lista_celulas_mi_info[$celula]["regiao"] . "\"";
                    $mi = " mi=\"" . $lista_celulas_mi_info[$celula]["mi"] . "\"";

                    Verifica_limite_blocos($l, $c, $span, $celula, $classe);   
                }
                else{
                    $class=" class=\"fora-proj\"";
                }
                
                if(!in_array($celula, $lista_celulas_criadas)){

                    array_push($lista_celulas_criadas, $celula);

                    if($span > 1){
                        $rowspan = " rowspan=\"2\" colspan=\"2\" ";
                        $c2 = $c + 1;
                        $l2 = $l + 1;
                        Insere_valor_lista($lista_celulas_criadas, $l."x".$c2);
                        Insere_valor_lista($lista_celulas_criadas, $l2."x".$c);
                        Insere_valor_lista($lista_celulas_criadas, $l2."x".$c2);
                    }

                    $tabela .= "<td" . $classe . $bloco . $mi . $regiao . " linha=\"" . $l . "\" coluna=\"" . $c . "\" celula=\"" . $celula . "\"" . 
                        $rowspan . $class . "></td>";
                }
            }
            $tabela .= "</tr>";
        }
        $tabela .= "\n</table>";
        return $tabela;
    }

    //Verifica limite de blocos nas celulas
    function Verifica_limite_blocos($l, $c, $span, $celula, &$classe){

        //celulas de ligação
        $celula_ligacao_esquerda = $l."x".($c - $span);
        $celula_ligacao_superior = ($l - $span)."x".$c;
        $celula_ligacao_direita = $l."x".($c + $span);
        $celula_ligacao_inferior = ($l + $span)."x".$c;

        Inserir_limite_bloco_projeto($celula_ligacao_esquerda, $celula, $classe, "limite_esquerdo");
        Inserir_limite_bloco_projeto($celula_ligacao_superior, $celula, $classe, "limite_superior");
        Inserir_limite_bloco_projeto($celula_ligacao_direita, $celula, $classe, "limite_direito");
        Inserir_limite_bloco_projeto($celula_ligacao_inferior, $celula, $classe, "limite_inferior");

        if(strlen($classe) > 0){
            $classe = " class=\"" . $classe . "\"";
        }
    }

    //Insere se necessário limite de blocos do projeto na celula 
    function Inserir_limite_bloco_projeto($celula_ligacao, $celula, &$classe, $classe_add){

        global $lista_celulas_mi_info;
        
        $inserir_limite = true;
        if(array_key_exists($celula_ligacao, $lista_celulas_mi_info)){
            $bloco_ligacao = $lista_celulas_mi_info[$celula_ligacao]["bloco"];
            $bloco_atual = $lista_celulas_mi_info[$celula]["bloco"];
            if(($bloco_ligacao == $bloco_atual)){
                $inserir_limite = false;
            }
        }

        if($inserir_limite){
            if(strlen($classe) > 0){
                $classe .= " ";
            }
            $classe .= $classe_add;
        }
    }

    //cria tabela por bloco antigo script
    function Criar_bloco_tabela($linhas, $colunas, $bloco){
        $tabela = "<table bloco=\"" . $bloco . "\">\n";
        for($c=0; $c < $colunas; $c++){
            $tabela .= "<tr linha=\"" . ($c + 1) . "\">";
            for($l=0; $l < $linhas; $l++){
                $tabela .= "<td coluna=\"" . ($l + 1) . "\"></td>";
            }
            $tabela .= "</tr>\n";
        }
        $tabela .= "\n</table>";
        return $tabela;
    }

/* CSS tabelas enumeradas
.tabela-blocos-enumerada {
    position: absolute;
    top: 0;
    left: calc(var(--largura-mi-25k) * -1);
    background-color: none;
    font-size: 8pt;
    padding: 0;
    margin: 0;
    max-height: calc(var(--largura-mi-25k) * 79);
}
#tabela-bloco-enumerada-linha{
    height: calc(var(--largura-mi-25k) * 79);
}


#tabela-bloco-enumerada-linha tr td {
    width: var(--padding);
    height: calc(var(--largura-mi-25k));
    

}
*/

?>

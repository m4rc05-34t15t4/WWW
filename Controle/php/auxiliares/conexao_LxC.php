<?php

    $link = "../";

    include_once $link."php/conexao.php";

    include_once $link."php/funcoes.php";

    //Faz a busca na tabela > 9 para cartas 1:25.000 e 6 para 1:50.000)
    $query = pg_query($conexao, Cria_sql());
    if($query) {

        //retorna linhas da consulta
        $row = pg_fetch_all($query);

        //cria array auxiliares
        $lista_mi_nao_utilizados = array();
        $lista_mi_utilizados = array();
        $lista_mi_formatado = array();
        $lista_mi_proximos = array();
        $lista_final_mi = array();

        //popula listas auxiliares
        Popula_listas_auxiliares();

        //Define MI BASE:
        //1946-2-SO L34 C17 'Oeste' 25K
        //2008-4-SO L40 C61'Litoral' 25K
        //1953-1 L33 C43 'Central' 50k
        Define_mi_central("1953-1", 33, 43);

        $contador = 0;
        while (count($lista_mi_nao_utilizados) > 0) {

            //pega lista proximo e cria uma lista identica estática 
            //para percorrer apenas estes elementos ja existentes antes deste loop
            $lista_proximo = $lista_mi_proximos;
            $qtd_proximos = count($lista_proximo);
            while ($qtd_proximos > 0) {
                Add_LxC_mis_ligacao($lista_proximo[$contador]);
                $qtd_proximos--;
            }

            //IMPRIME NA TELA BVALORES DOS PROCESSOS SE EXISTIR ELEMENTO, 
            //CASO CONTRARIO PARA SEREM OS PROXIMOS INSERE VALORES RESTANTES (ELEMENTOS NÃO AFETADOS NO SCRIPT)
            if(array_key_exists($contador, $lista_proximo)){
                //imprime na tela os valores do loop
                Imprime_loop_em_tela($contador, $lista_proximo[$contador]);
            }
            else{
                
                $contador--;
                
                $permissao = 0;
                $last_key = array_key_last($lista_mi_nao_utilizados);
                $elemento_loop_lista_mi_nao_utilizados = $lista_mi_nao_utilizados[$last_key];
                
                while ($permissao == 0){

                    //Define novo mi central para iniciar todo processo nos mi que não foram afetados
                    $first_Key = array_key_first($lista_mi_nao_utilizados);
                    $proximo_mi_central = $lista_mi_nao_utilizados[$first_Key];

                    if($proximo_mi_central == $elemento_loop_lista_mi_nao_utilizados){
                        //ja rodou todos mi do lista mi nao utilizados coloca permissão 2 
                        //para ser a ultima execução do while e permite imprimir que é necessári odefinir linha e coluna de algum MI
                        $permissao = 2;
                    }

                    //obter valor da linha e coluna do prox mi central e defini-lo
                    Obter_valores_define_prox_mi_central();
                }

                //sair do loop e imprime lista mi que precisao serem definido
                if($permissao == 2){
                    echo "Lista - MIs que pelo menos um elemento precisa ser definido Linha e COluna: <br>";
                    var_dump($lista_mi_nao_utilizados);
                    $lista_mi_nao_utilizados = array();
                }
            }
            $contador++;
        }
        //exibe
        Exibe_pagina("sql");
    }

    //FUNÇÕES

    //exipe pagina
    function Exibe_pagina($tipo = "json"){
        global $lista_final_mi;
        switch($tipo){
            case "json" : 
                //json
            case "JSON" : 
                //JSON
                header('Content-Type: application/json');
                echo json_encode($lista_final_mi);
                break;
            case "sql" : 
                //sql
            case "SQL" : 
                //SQL
                echo "Total: " . count($lista_final_mi) . " - código SQL:<br>";
                echo Gerar_sql_update_tabela_mi_ligacao();
                break;
            default:
                var_dump($lista_final_mi);
                break;
        }

    }

    //add linha e coluna ao MI
    function Add_LxC_mis_ligacao($mi){
        try {
            //add mi a lista de utilizados, pois ele é o atual
            global $lista_mi_utilizados;
            array_push($lista_mi_utilizados, $mi);

            //remove mi da lista dos proximos, pois ele é o atual
            global $lista_mi_proximos;
            ApagarElementoArray($lista_mi_proximos, $mi);

            //add mis ligação que serão usados para os proximos e direções
            Add_funcao_mi_ligacao($mi);
            
            //Finalizado MI atual
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //apaga elemento do array
    function ApagarElementoArray(&$array, $item){
        $key = array_search($item, $array);
        if($key!==false){
            unset($array[$key]);
            return true;
        }
        return false;
    }

    //Adiciona funcao aos mis ligação do mi atual
    function Add_funcao_mi_ligacao($mi){
        global $lista_mi_formatado;
        switch($lista_mi_formatado[$mi]["funcao"]){
            case "no" : 
                // o | no | n
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "o");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "no");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "n");
                break;
            case "n" : 
                // n
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "n");
                break;
            case "ne" : 
                // n | ne | l
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "n");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "ne");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "l");
                break;
            case "o" : 
                // o
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "o");
                break;
            case "c" : 
                // todos
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "no");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "n");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "ne");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "o");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "l");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "so");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "s");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "se");
                break;
            case "l" : 
                // l
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "l");
                break;
            case "so" : 
                // o | so | s
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "o");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "so");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "s");
                break;
            case "s" : 
                // s
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "s");
                break;
            case "se" : 
                // s | se | l
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "s");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "se");
                Add_mi_formatado_ligacao_funcao_lista_proximos($mi, "l");
                break;
        }
    }

    //funcao aux add função ao mi-igação do mi lista_mi_formatado atual (função de crescimento) e tbm add a lista dos próximos
    function Add_mi_formatado_ligacao_funcao_lista_proximos($mi, $funcao){

        global $lista_mi_formatado;
        global $lista_mi_nao_utilizados;

        //verifica se existe na lista mi nao utilizados
        if(Existe_valor_array($lista_mi_formatado[$mi][$funcao], $lista_mi_nao_utilizados)){
        
            //insere a função da ligação
            Add_funcao($lista_mi_formatado[$mi][$funcao], $funcao);

            //add mi ligação a lista dos proximos 
            Add_mi_lista_proximos($lista_mi_formatado[$mi][$funcao]);

            //remove mi ligação da lista dos nao_utilizados
            ApagarElementoArray($lista_mi_nao_utilizados, $lista_mi_formatado[$mi][$funcao]);

            //valor soma linha X Coluna
            Resolver_soma_linha_coluna($mi, $funcao);
            
        }
    }

    //Resolve qual valor soma para linha X Coluna
    function Resolver_soma_linha_coluna($mi, $funcao){
        
        $f = 1;
        //verifica se o MI é 50k
        if(strlen($mi) < 9){
            $f = 2;
        }

        switch($funcao){
            case "no" : 
                mi_valor_linha_coluna($mi, $funcao , (-1*$f), (-1*$f));
                break;
            case "n" : 
                mi_valor_linha_coluna($mi, $funcao , (-1*$f), (0*$f));
                break;
            case "ne" : 
                mi_valor_linha_coluna($mi, $funcao , (-1*$f), (1*$f));
                break;
            case "o" : 
                mi_valor_linha_coluna($mi, $funcao , (0*$f), (-1*$f));
                break;
            case "c" : 
                //mi_valor_linha_coluna($mi, $funcao , (0*$f), (0*$f));
                break;
            case "l" : 
                mi_valor_linha_coluna($mi, $funcao , (0*$f), (1*$f));
                break;
            case "so" : 
                mi_valor_linha_coluna($mi, $funcao , (1*$f), (-1*$f));
                break;
            case "s" : 
                mi_valor_linha_coluna($mi, $funcao , (1*$f), (0*$f));
                break;
            case "se" : 
                mi_valor_linha_coluna($mi, $funcao , (1*$f), (1*$f));
                break;
        }
    }

    //Add mi na lista mi proximos se existir no escopo do projeto
    function Add_mi_lista_proximos($mi){
        global $lista_mi_proximos;
        global $lista_mi_nao_utilizados;
        if((Existe_valor_array($mi, $lista_mi_nao_utilizados)) AND (!Existe_valor_array($mi, $lista_mi_proximos))){ 
            array_push($lista_mi_proximos, $mi);
            return true;
        }
        return false;
    }

    function Existe_valor_array($valor, &$array){
        if (in_array($valor, $array)) { 
            return true;
        }
        return false;
    }

    //Soma valor da linha e coluna do mi-funcao (mi-ligação-na direção)
    function mi_valor_linha_coluna($mi, $funcao, $linhaValorSoma, $colunaValorSoma){
        global $lista_mi_formatado;
        global $lista_final_mi;
        if(array_key_exists($lista_mi_formatado[$mi][$funcao], $lista_mi_formatado)) {
            $linha = ($lista_final_mi[$mi]["linha"] + $linhaValorSoma);
            $coluna = ($lista_final_mi[$mi]["coluna"] + $colunaValorSoma);
            Add_mi_linha_coluna($lista_mi_formatado[$mi][$funcao], $linha, $coluna);
        }
    }

    //Add Linha e Coluna ao MI
    function Add_mi_linha_coluna($mi, $linha, $coluna){
        global $lista_final_mi;
        $lista_final_mi[$mi]["linha"] = $linha;
        $lista_final_mi[$mi]["coluna"] = $coluna;
    }

    //Add funcao (direcao de crescimento (qual ligação do mi ele vai utilizar))
    function Add_funcao($mi, $funcao){
        global $lista_mi_formatado;
        $lista_mi_formatado[$mi]["funcao"] = $funcao;
    }

    //Funcao que define o mi central para iniciar o processo
    function Define_mi_central($mi_central, $linnha_central = 0, $coluna_central = 0){
        global $lista_mi_nao_utilizados;
        Add_funcao($mi_central, "c");
        if(($linnha_central != 0) AND ($coluna_central != 0)){
            Add_mi_linha_coluna($mi_central, $linnha_central, $coluna_central);
        }
        Add_mi_lista_proximos($mi_central);
        ApagarElementoArray($lista_mi_nao_utilizados, $mi_central);
    }

    //Popula as listas auxiliares (arrays)
    function Popula_listas_auxiliares(){
            
        global $row;
        global $lista_mi_formatado;
        global $lista_mi_nao_utilizados;

        for($i=0; $i < count($row); $i++){
            array_push($lista_mi_nao_utilizados, $row[$i]["mi"]);
            
            $lista_mi_formatado[$row[$i]["mi"]]["funcao"] = 0;
            $lista_mi_formatado[$row[$i]["mi"]]["no"] = $row[$i]["no"];
            $lista_mi_formatado[$row[$i]["mi"]]["n"] = $row[$i]["n"];
            $lista_mi_formatado[$row[$i]["mi"]]["ne"] = $row[$i]["ne"];
            $lista_mi_formatado[$row[$i]["mi"]]["o"] = $row[$i]["o"];
            $lista_mi_formatado[$row[$i]["mi"]]["l"] = $row[$i]["l"];
            $lista_mi_formatado[$row[$i]["mi"]]["so"] = $row[$i]["so"];
            $lista_mi_formatado[$row[$i]["mi"]]["s"] = $row[$i]["s"];
            $lista_mi_formatado[$row[$i]["mi"]]["se"] = $row[$i]["se"];
        }
    }

    function Cria_sql($mi_start = 0){
        $filtro_or = "";
        $campos = "*";
        if($mi_start != 0){
            $campos = "mi as mi_ligacao";
            $filtro_or = "
                (\"o\" = '" . $mi_start . "' OR 
                \"s\" = '" . $mi_start . "' OR 
                \"se\" = '" . $mi_start . "' OR 
                \"so\" = '" . $mi_start . "' OR 
                \"l\" = '" . $mi_start . "' OR 
                \"n\" = '" . $mi_start . "' OR 
                \"no\" = '" . $mi_start . "' OR 
                \"ne\" = '" . $mi_start . "') 
                AND ";
        }
        return "SELECT " . $campos . " FROM \"public\".\"ligacao_mi\" WHERE " . $filtro_or . "length(mi) < 9 ORDER BY \"mi\"";// AND \"regiao\" = 'Litoral'
    }

    //imprime na tela os valores do loop
    function Imprime_loop_em_tela($contador, $mi){
        global $lista_mi_nao_utilizados;
        global $lista_final_mi;
        echo "lista_mi_nao_utilizados: " . count($lista_mi_nao_utilizados) . " | " . $contador . " ) MI: " . $mi . 
        ", Linha: " . $lista_final_mi[$mi]["linha"] . ", Coluna: " . $lista_final_mi[$mi]["coluna"] . "<br>";
    }

    //Atualiza Banco de Dados com valores de linha e coluna
    function Gerar_sql_update_tabela_mi_ligacao(){
        global $lista_final_mi;
        global $row;
        $sql = "";
        for($s=0; $s < count($lista_final_mi); $s++){
            $sql .= "UPDATE \"public\".\"ligacao_mi\" SET \"linha\" = " . $lista_final_mi[$row[$s]["mi"]]["linha"] . 
                ", \"coluna\" = " . $lista_final_mi[$row[$s]["mi"]]["coluna"] . " WHERE \"mi\" = '" . $row[$s]["mi"] . "';<br>";
        }
        return $sql;
    }

    //obter valor da linha e coluna do prox mi central
    function Obter_valores_define_prox_mi_central(){
        
        global $conexao;
        global $proximo_mi_central;
        global $lista_final_mi;
        global $lista_mi_formatado;
        global $contador;
        global $permissao;
        global $lista_mi_nao_utilizados;

        $query = pg_query($conexao, Cria_sql($proximo_mi_central));
        if($query) {
            
            $row_mi_ligacao = pg_fetch_all($query);

            //retorna o primeiro item do array de ligações que existe neste loop
            $mi_ligacao = 0;
            for($q=0; $q < count($row_mi_ligacao); $q++){
                if(array_key_exists($row_mi_ligacao[$q]["mi_ligacao"], $lista_final_mi)){
                    $mi_ligacao = $row_mi_ligacao[$q]["mi_ligacao"];
                    $q = count($row_mi_ligacao);
                }
            }

            //verifica se exite ligação ao novo mi central com linha e coluna definidos
            if($mi_ligacao != 0){
                //buscar dados de direção de ligação com o mi central

                //obtem funcao do mi que ligou com o prox mi central em relacao ao mi central
                $mi_ligacao_formatado_flip = array_flip($lista_mi_formatado[$mi_ligacao]);
                $mi_ligacao_funcao = $mi_ligacao_formatado_flip[$proximo_mi_central];

                //resolve dados de linha e coluna dados novo mi central passando o mi que o liga
                Resolver_soma_linha_coluna($mi_ligacao, $mi_ligacao_funcao);
                
                //defini novo mi central
                Define_mi_central($proximo_mi_central);

                //imprime na tela os valores do loop
                echo "Fez consulta SQL -> ";
                Imprime_loop_em_tela($contador, $proximo_mi_central);

                //permite saido do while;
                $permissao = 1;
            }
            else{

                //Não existe mi que ligam com os elementos que restam e que tenha linhas e colunas definidas
                $elemento = array_shift($lista_mi_nao_utilizados);
                array_push($lista_mi_nao_utilizados, $elemento);

                echo "Não pode ser o mi-central lista_mi_nao_utilizados: " . count($lista_mi_nao_utilizados) . " | " . $contador . 
                    " ) MI: " . $proximo_mi_central . ", Linha: null, Coluna: null<br>";
            }
        }
    }

?>
<?php 

    //VARIAVEIS

    $colunas_consulta = ["qtd_mi", "qtd_usu", "qtd_dias", "mi_por_dia", "usu_por_dia", "mi_por_usu"];
    $MESES = array(
        '01' => 'Jan',
        '02' => 'Fev',
        '03' => 'Mar',
        '04' => 'Abr',
        '05' => 'Mai',
        '06' => 'Jun',
        '07' => 'Jul',
        '08' => 'Ago',
        '09' => 'Set',
        '10' => 'Out',
        '11' => 'Nov',
        '12' => 'Dez',
    );

    
    //FUNCOES

    function nr_semana(){
        return intval( date('z') / 7 ) + 1;
    }

    function array_classes(){
        //hid, plan, cobter
        return [null, null, null];
    }

    function array_colunas(){
        global $colunas_consulta;
        $array =  array();
        foreach($colunas_consulta as $col) $array[$col] = array_classes();
        return $array;
    }

    function array_mes($forpron_aq, $index, &$forpron_mes){
        global $colunas_consulta;
        for($i=0; $i < count($forpron_aq); $i++){
            $mes = $forpron_aq[$i]['mes_final'];
            if(!array_key_exists($mes, $forpron_mes)) $forpron_mes[$mes] = array_colunas(); 
            foreach($colunas_consulta as $col) $forpron_mes[$mes][$col][$index] = intval($forpron_aq[$i][$col]);
        }
    }

    function gerar_linha_grafico($col, &$forpron_mes, $ano=false){
        global $MESES;
        $linhas = [];
        foreach ($forpron_mes as $key => $value) {
            if($ano) array_push($linhas, "['".$MESES[explode('-', $key)[1]]."', ".implode(", ", $value[$col])."]");
            else array_push($linhas, "['".$MESES[$key]."', ".implode(", ", $value[$col])."]");
        }
        return "[" . implode(", ", $linhas) . "]";
    }
?>
<?php
    $con_string = "host=10.46.136.30 port=5432 dbname=Combater_2023 user=postgres password=admin";
    include_once "conexao.php";
    include_once "funcoes.php";

    /*
    //SELECIONAR TODOS
    $sql = "SELECT id, mi, 
        aq_hid, data_aq_hid_inicial, data_aq_hid_final, (data_aq_hid_final - data_aq_hid_inicial) as Delta_aq_hih, 
        aq_plan, data_aq_plan_inicial, data_aq_plan_final, (data_aq_plan_final - data_aq_plan_inicial) as Delta_aq_plan, 
        aq_cob_ter, data_aq_cob_ter_inicial, data_aq_cob_ter_final, (data_aq_cob_ter_final - data_aq_cob_ter_inicial) as Delta_aq_cob_ter 
        FROM aux_moldura_a;";
    //SELECT id, mi, aq_hid, data_aq_hid_inicial, data_aq_hid_final, (data_aq_hid_final - data_aq_hid_inicial) as Delta_aq_hih FROM aux_moldura_a;
    //SELECT COUNT(mi) AS QTD_MI, SPLIT_PART(data_aq_hid_final::TEXT, '-', 2) AS MES_FINAL, SUM(data_aq_hid_final - data_aq_hid_inicial) as sum_Delta_aq_hiD, (SUM(data_aq_hid_final - data_aq_hid_inicial) / COUNT(mi)) as Media  FROM aux_moldura_a GROUP BY MES_FINAL;
    
    SELECT 
	mi,
    bloco,
    status,
	niveis,
	densidade,
	nome_carta,
	inom,
	prioridade,
    editor,
    inicioedicao,
    terminoedicao,
    revisor1,
    inicio1rev,
    termino1rev,
    revisor2,
    inicio2rev,
    termino2rev,
    iniciocorrecao1,
    terminocorrecao1,
    iniciocorrecao2,
    terminocorrecao2,
    totalobj,
    total_p,
    total_l,
    total_a,
    txt_p,
    txt_l,
    o,
    s,
    se,
    so,
    l,
    n,
    no,
    ne,
    linha,
    coluna,
    regiao,
    "CQ1",
    "inicioCQ1",
	"terminoCQ1",
	"CQ2",
	"inicioCQ2",
    "terminoCQ2",
	"AjtHid",
    "inicioAjtHid",
	"terminoAjtHid",
	"RevHid",
	"inicioRevHid",
    "terminoRevHid",
	"AdVet",
    "inicioValida",
	"terminoValida",
    "AqHid",
    "inicioAqHid",
    "terminoAqHid",
    "AqPlan",
	"inicioAqPlan",
    "terminoAqPlan",
    "AjtPlan",
    "inicioAjtPlan",
    "terminoAjtPlan"
	FROM cartas
    
    
    */
    
    //forpron_aq_hid
    $sql = "SELECT SUM(QTD_MI) AS QTD_MI, SUM(QTD_USU) AS QTD_USU, MES_FINAL, extract(days FROM SUM(DELTA)) AS QTD_DIAS, 
        round(extract(days FROM SUM(DELTA))/SUM(QTD_MI)) AS MI_POR_DIA , 
        round(extract(days FROM SUM(DELTA))/SUM(QTD_USU)) AS USU_POR_DIA, 
        round(SUM(QTD_MI)/SUM(QTD_USU), 2) AS MI_POR_USU
        FROM  
        (SELECT SUM(QTD_MI) AS QTD_MI, COUNT(QTD_USU) AS QTD_USU, MIN(MES_FINAL) AS MES_FINAL, SUM(sum_Delta_aq_hiD) AS DELTA FROM 
            (SELECT 
                COUNT(mi) AS QTD_MI, 
                count(aq_hid) as QTD_USU, 
                SPLIT_PART(data_aq_hid_final::TEXT, '-', 2) AS MES_FINAL, 
                SUM(data_aq_hid_final - data_aq_hid_inicial) as sum_Delta_aq_hiD,
                CONCAT(count(aq_hid), '_', SPLIT_PART(data_aq_hid_final::TEXT, '-', 2)) AS USU_MES
                FROM aux_moldura_a 
                GROUP BY MES_FINAL, aq_hid) T_A
            GROUP BY USU_MES) T_B
        GROUP BY MES_FINAL;";
    $forpron_aq_hid = consulta($conexao, $sql);

    //forpron_aq_plan
    $sql = "SELECT SUM(QTD_MI) AS QTD_MI, SUM(QTD_USU) AS QTD_USU, MES_FINAL, extract(days FROM SUM(DELTA)) AS QTD_DIAS, 
        round(extract(days FROM SUM(DELTA))/SUM(QTD_MI)) AS MI_POR_DIA, 
        round(extract(days FROM SUM(DELTA))/SUM(QTD_USU)) AS USU_POR_DIA, 
        round(SUM(QTD_MI)/SUM(QTD_USU), 2) AS MI_POR_USU
        FROM 
            (SELECT SUM(QTD_MI) AS QTD_MI, COUNT(QTD_USU) AS QTD_USU, MIN(MES_FINAL) AS MES_FINAL, SUM(sum_Delta_aq_plan) AS DELTA FROM 
                (SELECT 
                    COUNT(mi) AS QTD_MI, 
                    count(aq_plan) as QTD_USU, 
                    SPLIT_PART(data_aq_plan_FINAL::TEXT, '-', 2) AS MES_FINAL, 
                    SUM(data_aq_plan_FINAL - data_aq_plan_inicial) as sum_Delta_aq_plan,
                    CONCAT(count(aq_plan), '_', SPLIT_PART(data_aq_plan_FINAL::TEXT, '-', 2)) AS USU_MES
                    FROM aux_moldura_a 
                    GROUP BY MES_FINAL, aq_plan) T_A
                GROUP BY USU_MES) T_B
            GROUP BY MES_FINAL;";
    $forpron_aq_plan = consulta($conexao, $sql);

    //forpron_aq_cob_ter
    $sql = "SELECT SUM(QTD_MI) AS QTD_MI, SUM(QTD_USU) AS QTD_USU, MES_FINAL, extract(days FROM SUM(DELTA)) AS QTD_DIAS, 
        round(extract(days FROM SUM(DELTA))/SUM(QTD_MI)) AS MI_POR_DIA, 
        round(extract(days FROM SUM(DELTA))/SUM(QTD_USU)) AS USU_POR_DIA, 
        round(SUM(QTD_MI)/SUM(QTD_USU), 2) AS MI_POR_USU
        FROM 
        (SELECT SUM(QTD_MI) AS QTD_MI, COUNT(QTD_USU) AS QTD_USU, MIN(MES_FINAL) AS MES_FINAL, SUM(sum_Delta_aq_cob_ter) AS DELTA FROM 
            (SELECT 
                COUNT(mi) AS QTD_MI, 
                count(aq_cob_ter) as QTD_USU, 
                SPLIT_PART(data_aq_cob_ter_final::TEXT, '-', 2) AS MES_FINAL, 
                SUM(data_aq_cob_ter_final - data_aq_cob_ter_inicial) as sum_Delta_aq_cob_ter,
                CONCAT(count(aq_cob_ter), '_', SPLIT_PART(data_aq_cob_ter_final::TEXT, '-', 2)) AS USU_MES
                FROM aux_moldura_a 
                GROUP BY MES_FINAL, aq_cob_ter) T_A
            GROUP BY USU_MES) T_B
        GROUP BY MES_FINAL;";
    $forpron_aq_cob_ter = consulta($conexao, $sql);

    //forpron total_progresso
    $sql = "SELECT COUNT(data_aq_hid_final), 'AqHid' AS TIPO FROM aux_moldura_a WHERE NOT data_aq_hid_inicial ISNULL AND NOT data_aq_hid_final ISNULL
        UNION
        SELECT COUNT(data_aq_plan_final), 'AqPlan' AS TIPO FROM aux_moldura_a WHERE NOT data_aq_plan_inicial ISNULL AND NOT data_aq_plan_final ISNULL
        UNION
        SELECT COUNT(data_aq_cob_ter_final), 'AqCobTer' AS TIPO FROM aux_moldura_a WHERE NOT data_aq_cob_ter_inicial ISNULL AND NOT data_aq_cob_ter_final ISNULL;";
    $forpron_total_progresso = consulta($conexao, $sql);

    //forpron media dias producao de cartas por fase 
    $sql = "SELECT (sum(data_aq_cob_ter_final::date - data_aq_cob_ter_inicial::date + 1) / count(aq_cob_ter)) AS media, 'aq_cob_ter' as tipo FROM aux_moldura_a WHERE NOT data_aq_cob_ter_inicial ISNULL AND NOT data_aq_cob_ter_final ISNULL AND NOT aq_cob_ter ISNULL
        UNION
        SELECT (sum(data_aq_hid_final::date - data_aq_hid_inicial::date + 1) / count(aq_hid)) AS media, 'aq_hid' as tipo FROM aux_moldura_a WHERE NOT data_aq_hid_inicial ISNULL AND NOT data_aq_hid_final ISNULL AND NOT aq_hid ISNULL
        UNION
        SELECT (sum(data_aq_plan_final::date - data_aq_plan_inicial::date + 1) / count(aq_plan)) AS media, 'aq_plan' as tipo FROM aux_moldura_a WHERE NOT data_aq_plan_inicial ISNULL AND NOT data_aq_plan_final ISNULL AND NOT aq_plan ISNULL;";
    $forpron_media_por_carta = consulta($conexao, $sql);


    //ARRAY
    $FORPRON = array(
        'aq_hid' => $forpron_aq_hid,
        'aq_plan' => $forpron_aq_plan,
        'aq_cob_ter' => $forpron_aq_cob_ter
    );

    $forpron_mes = array();
    array_mes($forpron_aq_hid[1], 0, $forpron_mes);
    array_mes($forpron_aq_plan[1], 1, $forpron_mes);
    array_mes($forpron_aq_cob_ter[1], 2, $forpron_mes);
    ksort($forpron_mes);
    
    $linhas_qtd_mi = gerar_linha_grafico('qtd_mi', $forpron_mes);
    $linhas_qtd_usu = gerar_linha_grafico('qtd_usu', $forpron_mes);
    $linhas_qtd_delta = gerar_linha_grafico('qtd_dias', $forpron_mes);
    $linhas_mi_por_dia = gerar_linha_grafico('mi_por_dia', $forpron_mes);
    $linhas_usu_por_dia = gerar_linha_grafico('usu_por_dia', $forpron_mes);
    $linhas_mi_por_usu = gerar_linha_grafico('mi_por_usu', $forpron_mes);

?>
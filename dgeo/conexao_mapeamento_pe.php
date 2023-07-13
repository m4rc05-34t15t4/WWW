<?php
    
    $con_string = "host=10.46.136.22 port=5432 dbname=Controle_PE user=postgres password=admin";
    include_once "conexao.php";
    include_once "funcoes.php";

    //MAPEAMENTO PE

    /*

    SELECT MI, "RevHid", "inicioRevHid", 
    CONCAT( SPLIT_PART(SPLIT_PART("inicioRevHid"::TEXT, '/', 3), ' ', 1), '-', SPLIT_PART("inicioRevHid"::TEXT, '/', 2), '-', SPLIT_PART("inicioRevHid"::TEXT, '/', 1), ' ', SPLIT_PART(SPLIT_PART("inicioRevHid"::TEXT, '/', 3), ' ', 2)) as inicio
    from cartas where "inicioRevHid" like '%/%'

    UPDATE CARTAS SET "inicioRevHid" = CONCAT( SPLIT_PART(SPLIT_PART("inicioRevHid"::TEXT, '/', 3), ' ', 1), '-', SPLIT_PART("inicioRevHid"::TEXT, '/', 2), '-', SPLIT_PART("inicioRevHid"::TEXT, '/', 1), ' ', SPLIT_PART(SPLIT_PART("inicioRevHid"::TEXT, '/', 3), ' ', 2)) 
    WHERE "inicioRevHid" like '%/%'



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

    //mapeamento_pe AqPlan
    $sql = "SELECT SUM(QTD_MI) AS QTD_MI, SUM(QTD_USU) AS QTD_USU, MES_FINAL, SUM(DELTA) AS QTD_DIAS, 
        round(SUM(DELTA)/SUM(QTD_MI)) AS MI_POR_DIA, 
        round(SUM(DELTA)/SUM(QTD_USU)) AS USU_POR_DIA, 
        round(SUM(QTD_MI)/SUM(QTD_USU), 2) AS MI_POR_USU
        FROM 
        (SELECT SUM(QTD_MI) AS QTD_MI, COUNT(QTD_USU) AS QTD_USU, MIN(MES_FINAL) AS MES_FINAL, SUM(sum_Delta_aqplan) AS DELTA FROM 
            (SELECT 
                COUNT(mi) AS QTD_MI, 
                count(\"AqPlan\") as QTD_USU, 
                CONCAT(SPLIT_PART(\"terminoAqPlan\"::TEXT, '-', 1),'-', SPLIT_PART(\"terminoAqPlan\"::TEXT, '-', 2)) AS MES_FINAL, 
                SUM(\"terminoAqPlan\"::date - \"inicioAqPlan\"::date) as sum_Delta_aqplan,
                CONCAT(count(\"AqPlan\"), '_', CONCAT(SPLIT_PART(\"terminoAqPlan\"::TEXT, '-', 1),'-', SPLIT_PART(\"terminoAqPlan\"::TEXT, '-', 2))) AS USU_MES
                FROM cartas 
                WHERE SPLIT_PART(\"terminoAqPlan\"::TEXT, '-', 1) = '2023'
                GROUP BY MES_FINAL, \"AqPlan\") T_A
            GROUP BY USU_MES) T_B
        GROUP BY MES_FINAL;";
    $mapeamento_pe_aqplan = consulta($conexao, $sql);

    //mapeamento_pe AqHid
    $sql = "SELECT SUM(QTD_MI) AS QTD_MI, SUM(QTD_USU) AS QTD_USU, MES_FINAL, SUM(DELTA) AS QTD_DIAS, 
        round(SUM(DELTA)/SUM(QTD_MI)) AS MI_POR_DIA, 
        round(SUM(DELTA)/SUM(QTD_USU)) AS USU_POR_DIA, 
        round(SUM(QTD_MI)/SUM(QTD_USU), 2) AS MI_POR_USU
        FROM 
        (SELECT SUM(QTD_MI) AS QTD_MI, COUNT(QTD_USU) AS QTD_USU, MIN(MES_FINAL) AS MES_FINAL, SUM(sum_Delta_aqhid) AS DELTA FROM 
            (SELECT 
                COUNT(mi) AS QTD_MI, 
                count(\"AqHid\") as QTD_USU, 
                CONCAT(SPLIT_PART(\"terminoAqHid\"::TEXT, '-', 1),'-', SPLIT_PART(\"terminoAqHid\"::TEXT, '-', 2)) AS MES_FINAL, 
                SUM(\"terminoAqHid\"::date - \"inicioAqHid\"::date) as sum_Delta_aqhid,
                CONCAT(count(\"AqHid\"), '_', CONCAT(SPLIT_PART(\"terminoAqHid\"::TEXT, '-', 1),'-', SPLIT_PART(\"terminoAqHid\"::TEXT, '-', 2))) AS USU_MES
                FROM cartas 
                WHERE SPLIT_PART(\"terminoAqHid\"::TEXT, '-', 1) = '2023'
                GROUP BY MES_FINAL, \"AqHid\") T_A
            GROUP BY USU_MES) T_B
        GROUP BY MES_FINAL;";
    $mapeamento_pe_aqhid = consulta($conexao, $sql);

    //mapeamento_pe RevHid
    $sql = "SELECT SUM(QTD_MI) AS QTD_MI, SUM(QTD_USU) AS QTD_USU, MES_FINAL, SUM(DELTA) AS QTD_DIAS, 
        round(SUM(DELTA)/SUM(QTD_MI)) AS MI_POR_DIA, 
        round(SUM(DELTA)/SUM(QTD_USU)) AS USU_POR_DIA, 
        round(SUM(QTD_MI)/SUM(QTD_USU), 2) AS MI_POR_USU
        FROM 
        (SELECT SUM(QTD_MI) AS QTD_MI, COUNT(QTD_USU) AS QTD_USU, MIN(MES_FINAL) AS MES_FINAL, SUM(sum_Delta_RevHid) AS DELTA FROM 
            (SELECT 
                COUNT(mi) AS QTD_MI, 
                count(\"RevHid\") as QTD_USU, 
                CONCAT(SPLIT_PART(\"terminoRevHid\"::TEXT, '-', 1),'-', SPLIT_PART(\"terminoRevHid\"::TEXT, '-', 2)) AS MES_FINAL, 
                SUM(\"terminoRevHid\"::date - \"inicioRevHid\"::date) as sum_Delta_RevHid,
                CONCAT(count(\"RevHid\"), '_', CONCAT(SPLIT_PART(\"terminoRevHid\"::TEXT, '-', 1),'-', SPLIT_PART(\"terminoRevHid\"::TEXT, '-', 2))) AS USU_MES
                FROM cartas
			 	WHERE SPLIT_PART(\"terminoRevHid\"::TEXT, '-', 1) = '2023' AND NOT \"inicioRevHid\" ISNULL
                GROUP BY MES_FINAL, \"RevHid\") T_A
            GROUP BY USU_MES) T_B
        GROUP BY MES_FINAL;";
    $mapeamento_pe_revhid = consulta($conexao, $sql);

    //mapeamento_pe total_progresso //625
    $sql = "SELECT COUNT(\"terminoRevHid\"), 'RevHid' AS TIPO FROM CARTAS WHERE NOT \"inicioRevHid\" ISNULL AND NOT \"terminoRevHid\" ISNULL
        UNION
        SELECT COUNT(\"terminoAqPlan\"), 'AqPlan' AS TIPO FROM CARTAS WHERE NOT \"inicioAqPlan\" ISNULL AND NOT \"terminoAqPlan\" ISNULL
        UNION
        SELECT COUNT(\"terminoAqHid\"), 'AqHid' AS TIPO FROM CARTAS WHERE NOT \"inicioAqHid\" ISNULL AND NOT \"terminoAqHid\" ISNULL;";
    $mapeamento_totais = consulta($conexao, $sql);

    //mapeamento_pe media dias producao de cartas por fase RevHid 7 dias, APlan 2 Dias, AqHid 6 Dias
    $sql = "SELECT (sum(\"terminoRevHid\"::date - \"inicioRevHid\"::date + 1) / count(\"RevHid\")) AS media, 'RevHid' as tipo FROM CARTAS WHERE NOT \"inicioRevHid\" ISNULL AND NOT \"terminoRevHid\" ISNULL AND NOT \"RevHid\" ISNULL
        UNION
        SELECT (sum(\"terminoAqHid\"::date - \"inicioAqHid\"::date + 1) / count(\"AqHid\")) AS media, 'AqHid' as tipo FROM CARTAS WHERE NOT \"inicioAqHid\" ISNULL AND NOT \"terminoAqHid\" ISNULL AND NOT \"AqHid\" ISNULL
        UNION
        SELECT (sum(\"terminoAqPlan\"::date - \"inicioAqPlan\"::date + 1) / count(\"AqPlan\")) AS media, 'AqPlan' as tipo FROM CARTAS WHERE NOT \"inicioAqPlan\" ISNULL AND NOT \"terminoAqPlan\" ISNULL AND NOT \"AqPlan\" ISNULL;";
    //$mapeamento_media_por_carta = consulta($conexao, $sql);

    //ARRAY
    $MAPEAMENTO_PE = array(
        'aq_hid' => $mapeamento_pe_aqhid,
        'aq_plan' => $mapeamento_pe_aqplan,
        'revHid' => $mapeamento_pe_revhid
    );

    $mapeamento_pe_mes = array();
    array_mes($mapeamento_pe_aqhid[1], 0, $mapeamento_pe_mes);
    array_mes($mapeamento_pe_aqplan[1], 1, $mapeamento_pe_mes);
    array_mes($mapeamento_pe_revhid[1], 2, $mapeamento_pe_mes);
    ksort($mapeamento_pe_mes);
    
    $linhas_qtd_mi = gerar_linha_grafico('qtd_mi', $mapeamento_pe_mes, true);
    $linhas_qtd_usu = gerar_linha_grafico('qtd_usu', $mapeamento_pe_mes, true);
    $linhas_qtd_delta = gerar_linha_grafico('qtd_dias', $mapeamento_pe_mes, true);
    $linhas_mi_por_dia = gerar_linha_grafico('mi_por_dia', $mapeamento_pe_mes, true);
    $linhas_usu_por_dia = gerar_linha_grafico('usu_por_dia', $mapeamento_pe_mes, true);
    $linhas_mi_por_usu = gerar_linha_grafico('mi_por_usu', $mapeamento_pe_mes, true);

?>
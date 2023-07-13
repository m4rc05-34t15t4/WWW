<?php 
    include_once "base.php";
    include_once "conexao_mapeamento_pe.php";

    $qtd_sem = 52; //total de semanas (prazo)
    $perc = nr_semana() / $qtd_sem * 100; 
    $sem_res = $qtd_sem - nr_semana();
    $totais = $mapeamento_totais[1];
    $t = 625;//448; //total cartas forpron
    $val_p = "'" . $totais[0]['tipo'] . " (" . $t . ")', '" . $totais[1]['tipo'] . " (" . $t . ")', '" . $totais[2]['tipo'] . " (" . $t . ")'";
    $val_t = ($totais[1]['count']/$t*100) . ', ' . ($totais[1]['count']/$t*100) . ', ' . ($totais[2]['count']/$t*100);
?>
    </head>
    <body>
        <main pagina="dgeo" class="contaiter-fluid w-100 p-0 m-0">
            <div id="mapeamento_pe-estatisticas" class="div-estatistica w-100">
                <div class="divisao-cabecalho w-100 m-0 p-3 bg-primary bg-gradient shadow">
                    <h1 class="w-100 text-center text-white">MAPEAMENTO PE - 2023</h1>
                    <h3 class="w-100 text-center text-light">Estatísticas de mapeamento</h3>
                    <a href="forpron.php" class="link-cabecalho">FORPRON</a>
                </div>
                <div class="p-3 d-flex flex-rown flex-wrap justify-content-around text-center pt-5">
                    <div id="progresso_total" class="graficos m-1"></div>
                    <div id="media_total" class="graficos m-1"></div>
                    <div id="container" class="graficos m-1"></div>
                    <div id="qtd_mi_grafico" class="graficos m-1"></div>
                    <div id="qtd_usu_grafico" class="graficos m-1"></div>
                    <div id="qtd_dias_grafico" class="graficos m-1"></div>
                    <div id="mi_por_dia_grafico" class="graficos m-1"></div>
                    <div id="usu_por_dia_grafico" class="graficos m-1"></div>
                    <div id="mi_por_usu_grafico" class="graficos m-1"></div>
                </div>
            </div>
        </main>
    </body>
    <script>
        var titulo = 'Progresso Total / Fase';
        var tit_bat = '<span style="color: #212121; font-size: 24px"><?php echo $sem_res ?> Semanas Restantes</span>';
        var desc_bat = '<span style="color: #212121; font-size: 12px">Restando '+String(<?php echo $perc; ?>)+'% do prazo</span>';
        grafico_bateria('container', <?php echo  $perc ?>, tit_bat, desc_bat);
        grafico_circular("progresso_total", titulo, [<?php echo $val_p; ?>], [ <?php echo $val_t; ?>]);
        grafico_barra("media_total", "Média Cartas / Classe", "Nr Dias", linhas=[['Fases', 6, 2, 7]], headers=['#', 'AqHid', 'AqPlan', 'Revhid']);
        grafico_barra("qtd_mi_grafico", "Total Cartas / Classe", "Nr Cartas", <?php echo $linhas_qtd_mi; ?>, headers=['#', 'AqHid', 'AqPlan', 'Revhid']);
        grafico_barra("qtd_usu_grafico", "Total usuários / Classe", "Nr Usuários", <?php echo $linhas_qtd_usu; ?>, headers=['#', 'AqHid', 'AqPlan', 'Revhid']);
        grafico_barra("qtd_dias_grafico", "Total Dias / Classes", "Nr Dias", <?php echo $linhas_qtd_delta; ?>, headers=['#', 'AqHid', 'AqPlan', 'Revhid']);
        grafico_barra("mi_por_dia_grafico", "Dia Médio por MI", "Nr Dias / MI", <?php echo $linhas_mi_por_dia; ?>, headers=['#', 'AqHid', 'AqPlan', 'Revhid']);
        grafico_barra("usu_por_dia_grafico", "Qtd Dias por Usuário", "Nr Dias / Usuário", <?php echo $linhas_usu_por_dia; ?>, headers=['#', 'AqHid', 'AqPlan', 'Revhid']);
        grafico_barra("mi_por_usu_grafico", "Qtd MI por Usuário", "Nr MI / Usuário", <?php echo $linhas_mi_por_usu; ?>, headers=['#', 'AqHid', 'AqPlan', 'Revhid']);
    </script>
</html>

<?php 
    include_once "base.php";
    include_once "conexao_forpron.php";
    
    $qtd_sem = 52; //total de semanas (prazo)
    $perc = nr_semana() / $qtd_sem * 100; 
    $sem_res = $qtd_sem - nr_semana();
    $totais = $forpron_total_progresso[1];
    $t = 36; //total cartas forpron
    $val_p = "'" . $totais[0]['tipo'] . " (" . $t . ")', '" . $totais[1]['tipo'] . " (" . $t . ")', '" . $totais[2]['tipo'] . " (" . $t . ")'";
    $val_t = ($totais[1]['count']/$t*100) . ', ' . ($totais[1]['count']/$t*100) . ', ' . ($totais[2]['count']/$t*100);
?>
    </head>
    <body>
        <main pagina="dgeo" class="contaiter-fluid w-100 p-0 m-0">
            <div id="forpron-estatisticas" class="div-estatistica w-100">
                <div class="divisao-cabecalho w-100 m-0 p-3 bg-primary bg-gradient shadow">
                    <h1 class="w-100 text-center text-white">FORPRON - Força de Prontidão 2023</h1>
                    <h3 class="w-100 text-center text-light">Estatísticas de mapeamento</h3>
                    <a href="mapeamento_pe.php" class="link-cabecalho">MAPEAMENTO PE</a>
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
        grafico_barra("media_total", "Média Cartas / Classe", "Nr Dias", linhas=[['Fases', 14, 10, 15]], headers=['#', 'AqPlan', 'AqHid', 'AqCobTer']);
        grafico_barra("qtd_mi_grafico", "Total Cartas / Classe", "Nr Cartas", <?php echo $linhas_qtd_mi; ?>);
        grafico_barra("qtd_usu_grafico", "Total usuários / Classe", "Nr Usuários", <?php echo $linhas_qtd_usu; ?>);
        grafico_barra("qtd_dias_grafico", "Total Dias / Classes", "Nr Dias", <?php echo $linhas_qtd_delta; ?>);
        grafico_barra("mi_por_dia_grafico", "Dia Médio por MI", "Nr Dias / MI", <?php echo $linhas_mi_por_dia; ?>);
        grafico_barra("usu_por_dia_grafico", "Qtd Dias por Usuário", "Nr Dias / Usuário", <?php echo $linhas_usu_por_dia; ?>);
        grafico_barra("mi_por_usu_grafico", "Qtd MI por Usuário", "Nr MI / Usuário", <?php echo $linhas_mi_por_usu; ?>);
    </script>
</html>

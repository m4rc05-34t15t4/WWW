<?php 
    if(!isset($link)) $link = "../";
    
    include_once $link."php/base.php";
?>
    <script src="<?php echo $link."js/mi_informacoes.js$Versao"; ?>"></script>

    </head>
    <body>
        
        <?php 
            include_once $link."php/Cabecalho.php";
            include_once $link."php/Rodape.php";
        ?>
        
        <div class="informacoes-mi">

            <div class="informacoes-mi-descricao">
                <div class="titulo">INFORMAÇÕES</div>
                <hr><!--
                BLOCO: C2<br>
                INOM: SC-24-V-C-I-1-SE<br>
                FUSO: 23S<br> 
                EPSG: 31983<br>
                SRV-GOTHIC: 01<br>
                DIFICULDADE: Fácil<br>
                DENSIDADE: 789<br>
                FASE: Em Edição<br>
                <hr>
                EDITOR: 3º Sgt Marcos Batista<br>
                Início Edição: 10/10/2020 SEG<br>
                Término Edição: 15/10/2020 TER<br>
                <hr>
                1º REVISOR: Sgt Alves N.<br>
                Início 1ª Rev: 20/10/2020 QUA<br>
                Término 1ª Rev: 25/10/2020 QUI<br>
                <hr>
                Início Correção 1: 10/10/2020 SEG<br>
                Término Correção 1: 15/10/2020 TER<br>
                <hr>
                2º REVISOR: ST Campos.<br>
                Início 2ª Rev: 20/10/2020 QUA<br>
                Término 2ª Rev: 25/10/2020 QUI<br>
                <hr>
                Início Correção 2: 10/10/2020 SEG<br>
                Término Correção 2: 15/10/2020 TER<br>-->
            </div>

            <div class="mi">
                <div class="div-text">
                    <!--1015-1-NE-->
                </div>
            </div>

            <table class="mi-ligacao">
                <tr>
                    <td id="mi-ligacao_no" class="mi-ligacao-individuais"><!--1015-1-NO--></td>
                    <td id="mi-ligacao_n" class="mi-ligacao-individuais"><!--1015-1-NE--></td>
                    <td id="mi-ligacao_ne" class="mi-ligacao-individuais"><!--1015-2-NO--></td>
                </tr>
                <tr>
                    <td id="mi-ligacao_o" class="mi-ligacao-individuais"><!--1015-1-SO--></td>
                    <td id="mi-ligacao_c" class="mi-ligacao-individuais"><!--1015-1-SE--></td>
                    <td id="mi-ligacao_l" class="mi-ligacao-individuais"><!--1015-2-SO--></td>
                </tr>
                <tr>
                    <td id="mi-ligacao_so" class="mi-ligacao-individuais"><!--1015-3-NO--></td>
                    <td id="mi-ligacao_s" class="mi-ligacao-individuais"><!--1015-3-NE--></td>
                    <td id="mi-ligacao_se" class="mi-ligacao-individuais"><!--1015-4-NO--></td>
                </tr>
            </table>

            <table class="conteudo-direita">
                <tr>
                    <td class="nome-mi" colspan="4">
                        Nome da Carta:
                        <div class="nome-carta">
                            <!--Veredas Carnaibas-->
                        </div>
                        <br>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td class="conteudo-direita-titulo" colspan="4">
                        <div>Legenda:</div>
                    </td>
                </tr>
                <tr>
                    <td id="fase_0" class="mi-fases fase_0">0</td>
                    <td class="mi-fases-descricao">Fora do Projeto</td>
                    <td id="fase_60" class="mi-fases fase_60">60</td>
                    <td class="mi-fases-descricao">Em 1ª Correção</td>
                </tr>
                <tr>
                    <td id="fase_1" class="mi-fases fase_1">1</td>
                    <td class="mi-fases-descricao">Validada </td>
                    <td id="fase_61" class="mi-fases fase_61">61</td>
                    <td class="mi-fases-descricao">Corrigida 1ª</td>
                </tr>
                <tr>
                    <td id="fase_2" class="mi-fases fase_2">2</td>
                    <td class="mi-fases-descricao">No Gothic</td>
                    <td id="fase_7" class="mi-fases fase_7">7</td>
                    <td class="mi-fases-descricao">Em 2ª Rev</td>
                </tr>
                <tr>
                    <td id="fase_3" class="mi-fases fase_3">3</td>
                    <td class="mi-fases-descricao">Em Edição</td>
                    <td id="fase_8" class="mi-fases fase_8">8</td>
                    <td class="mi-fases-descricao">Revisada (2ª)</td>
                </tr>
                <tr>
                    <td id="fase_4" class="mi-fases fase_4">4</td>
                    <td class="mi-fases-descricao">Editada</td>
                    <td id="fase_80" class="mi-fases fase_80">80</td>
                    <td class="mi-fases-descricao">Em 2ª Correção</td>
                </tr>
                <tr>
                    <td id="fase_5" class="mi-fases fase_5">5</td>
                    <td class="mi-fases-descricao">Em 1ª Rev</td>
                    <td id="fase_81" class="mi-fases fase_81">81</td>
                    <td class="mi-fases-descricao">Corrigida 2ª</td>
                </tr>
                <tr>
                    <td id="fase_6" class="mi-fases fase_6">6</td>
                    <td class="mi-fases-descricao">Revisada (1ª)</td>
                    <td id="fase_9" class="mi-fases fase_9">9</td>
                    <td class="mi-fases-descricao">Entregue</td>
                </tr>
                <tr>
                    <td class="mi_informacoes_subtitulo_legenda" colspan="3">Em outras OM:</td><td></td>
                </tr>
                <tr>
                    <td id="fase_10" class="mi-fases fase_10">10</td>
                    <td class="mi-fases-descricao">4º CGEO</td>
                    <td id="fase_11" class="mi-fases fase_11">11</td>
                    <td class="mi-fases-descricao">5º CGEO</td>
                </tr>
            </table>

        </div>
        
    </body>
</html>
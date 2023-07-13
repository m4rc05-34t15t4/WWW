<?php 
    include_once "base.php";
?>
    <script src="<?php echo "../js/ficha_auxiliar.js$Versao"; ?>"></script>
</head>
    <body>
        <div id="cabecalho">
            <div id="titulo">Ficha Auxiliar Exame de Pagamento - Versão: <?php echo $V ?></div>
            <div id="nome">
                <!--
                <select id="select_nome">
                    <option>3º Sgt Marcos Batista</option>
                    <option>...</option>
                </select>-->
            </div>
            <button id="btnSalvar" type="button">Salvar</button>
        </div>
        <div id="conteudo">
            <div id="tabela_contracheque">
                <table id="ficha_auxiliar">
                    <tr class="cabecalho">
                        <td colspan="2">UG: 160179</td>
                        <td colspan="2" id="precp">Prec-CP: <!--126064950--></td>
                        <td colspan="2"><div id="mes">
                        <!--MÊS:
                        <select  class="inp_mes">
                            <option>JANEIRO</option>
                            <option>FEVEREIRO</option>
                            <option>MARÇO</option>
                            <option>ABRIL</option>
                            <option>MAIO</option>
                            <option>JUNHO</option>
                            <option>JULHO</option>
                            <option>AGOSTO</option>
                            <option>SETEMBRO</option>
                            <option>OUTUBRO</option>
                            <option>NOVEMBRO</option>
                            <option>DEZEMBRO</option>
                        </select>
                        -->
                    </tr>
                    <tr class="cabecalho">
                        <td colspan="3">POST/GRAD/MATR NOME: </td>
                        <td colspan="3" id="nome_ident"><!--3º Sgt MARCOS BATISTA DA SILVA JÚNIOR--></td>
                    </tr>
                    <tr class="cabecalho">
                        <td colspan="3" id="idt">IDT: <!--070084937-5--></td>
                        <td colspan="3" id="cpf">CPF: <!--094437294-58--></td>
                    </tr>
                    <tr id="tr_receita">
                        <td class="dados_tipo">R<br>E<br>C<br>E<br>I<br>T<br>A</td>
                        <td colspan="5" class="dados_contra_cheque">
                            <table id="receita">
                                <tr>
                                    <td>DISCRIMININAÇÃO</td>
                                    <td>%</td>
                                    <td>VALOR<br>PESQUISADO</td>
                                    <td><div id="div_botao_clonar"><div>VALOR<br>CONTRACHEQUE</div><div><span data-tooltip="Clonar Valores Pesquisados"><div id="clonar_val_pesquisado"></div></span></div></div></td>
                                    <td><div id="div_botao_observacoes"><div>OBSERVAÇÕES<br></div><div><span data-tooltip="Limpar Dados Coluna Observações"><div id="limpar_dados_observacoes"></div></span></div></div></td>
                                </tr>
                                <tr id="soldo">
                                    <td><input class="inp_titulo" type="text" placeholder="SOLDO"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_militar">
                                    <td><input class="inp_titulo" type="text" placeholder="ADIC MIL"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_hab">
                                    <td><input class="inp_titulo" type="text" placeholder="ADC HAB"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_disp">
                                    <td><input class="inp_titulo" type="text" placeholder="ADIC DISP"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_pqdt">
                                    <td><input class="inp_titulo" type="text" placeholder="ADIC C ORG PQDT"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_perm">
                                    <td><input class="inp_titulo" type="text" placeholder="ADIC PERMAN"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_grat_loc_esp_tip_a">
                                    <td><input class="inp_titulo" type="text" placeholder="GRAT LOC ESP TIP A"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_grat_rep_2">
                                    <td><input class="inp_titulo" type="text" placeholder="GRAT REP 2%"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="salario_familia">
                                    <td><input class="inp_titulo" type="text" placeholder="SALÁRIO FAMÍLIA"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="assist_pre_escolar">
                                    <td><input class="inp_titulo" type="text" placeholder="ASSIST. PRÉ-ESCOLAR"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_aux_trasnp">
                                    <td><input class="inp_titulo" type="text" placeholder="AUX. TRANSP."></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_ferias">
                                    <td><input class="inp_titulo" type="text" placeholder="ADIC FÉRIAS"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_nat_jun">
                                    <td><input class="inp_titulo" type="text" placeholder="ADIC NATALINO JUN"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="adc_nat_nov">
                                    <td><input class="inp_titulo" type="text" placeholder="ADIC NATALINO NOV"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="aux_fard">
                                    <td><input class="inp_titulo" type="text" placeholder="AUX FARD 1 SOLD"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="aux_nat">
                                    <td><input class="inp_titulo" type="text" placeholder="AUX NATALIDADE"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr id="tr_despesa">
                        <td class="dados_tipo">D<br>E<br>S<br>P<br>E<br>S<br>A</td>
                        <td colspan="5" class="dados_contra_cheque">
                            <table id="despesa">
                                <tr id="p_mil_105">
                                    <td><input class="inp_titulo" type="text" placeholder="P MIL 10.5%"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="p_mil_15">
                                    <td><input class="inp_titulo" type="text" placeholder="P MIL DEP 1,5%"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="fusex_3">
                                    <td><input class="inp_titulo" type="text" placeholder="FUSEX 3%"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="desc_dep_fusex">
                                    <td><input class="inp_titulo" type="text" placeholder="DESC DEP FUSEX"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="imposto_renda">
                                    <td><input class="inp_titulo" type="text" placeholder="IMPOSTO RENDA"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="pnr_gestora">
                                    <td><input class="inp_titulo" type="text" placeholder="PNR (UN. GESTORA)"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="pnr_manut">
                                    <td><input class="inp_titulo" type="text" placeholder="PNR (F Ex - Manut)"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="pnr_const">
                                    <td><input class="inp_titulo" type="text" placeholder="PNR (F Ex - Const)"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="imp_renda_13">
                                    <td><input class="inp_titulo" type="text" placeholder="IMPOSTO RENDA 13ª"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="da_aux_transp">
                                    <td><input class="inp_titulo" type="text" placeholder="DA AUX. TRANSP."></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                                <tr id="da_ad_nat_n_ded">
                                    <td><input class="inp_titulo" type="text" placeholder="DA AD NAT N DED"></td>
                                    <td>-</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td id="rodape_data" class="rodape" colspan="6"><input name="rodape_data" type="text"></td>
                    </tr>
                    <tr>
                        <td id="rodape_responsavel" class="rodape" colspan="6"><input name="rodape_responsavel" type="text"></td>
                    </tr>
                </table>

                <div id="historico-fichas">
                    <h2>Histórico de Fichas auxiliares do militar</h2>
                    <div id="historico-fichas-conteudo">
                    </div>
                </div>
            </div>
            
            <div id="dados_auxiliares">
                <div id="dados_cabecalho">
                    <div id="dados">
                        <div id="dados_radio">
                            <div id="militar_tipo">
                                <p>Militar Tipo:</p><br>
                                <input type="radio" id="r_tipo_qao" name="militar_tipo" value="QAO"> <label for="qao">QAO</label><br>
                                <input type="radio" id="r_tipo_qe" name="militar_tipo" value="QE"> <label for="qe">QE</label><br>
                                <input type="radio" id="r_tipo_temp" name="militar_tipo" value="Temporário"> <label for="temp">Temporário</label><br>
                                <input type="radio" id="r_tipo_carr" name="militar_tipo" value="Carreira"> <label for="carr">Carreira</label><br>
                            </div>
                            <div id="curso">
                                <p>Curso:</p><br>
                                <input type="radio" id="r_curso_alt_est_cat1" name="curso" value="Altos Estudos Cat 1"> <label for="r_curso_alt_est_cat1">Altos Estudos Cat 1</label><br>
                                <input type="radio" id="r_curso_alt_est_cat2" name="curso" value="Altos Estudos Cat 2"> <label for="r_curso_alt_est_cat2">Altos Estudos Cat 2</label><br>
                                <input type="radio" id="r_curso_aperfeicoamento" name="curso" value="Aperfeiçoamento"> <label for="r_curso_aperfeicoamento">Aperfeiçoamento</label><br>
                                <input type="radio" id="r_curso_especializacao" name="curso" value="Especialização"> <label for="r_curso_especializacao">Especialização</label><br>
                                <input type="radio" id="r_curso_formacao" name="curso" value="Formação"> <label for="r_curso_formacao">Formação</label><br>
                                <input type="radio" id="r_curso_sem_curso" name="curso" value="Sem Curso"> <label for="r_curso_sem_curso">Sem Curso</label><br>
                            </div>
                        </div>
                        <hr>
                        <p>Receitas:</p><br>
                        <div> <input id="cb_adc_ferias" type="checkbox"> Adicional Férias </div>
                        <div>
                            <input id="cb_adc_nat" type="checkbox">
                            <select id="select_adc_nat">
                                <option>JUN</option>
                                <option>NOV</option>
                            </select>
                            Adicional Natalino
                        </div>
                        <div> <input id="cb_aux_fard" type="checkbox"> Auxilio Fardamento </div>
                        <div> <input id="cb_aux_natalidade" type="checkbox"> Auxilio Natalidade </div>
                        <input id="val_adc_pqdt" type="text"> R$, ADC C ORG PQDT<br>
                        <input id="val_adc_perm" type="text"> R$, ADC PERMAN<br>
                        <input id="val_adc_grat_loc_esp_tip_a" type="text"> R$, GRAT LOC ESP TIP A<br>
                        <input id="val_adc_grat_rep_2" type="text"> R$, GRAT REP 2%<br>
                        <hr>
                        <p>Despesas:</p><br>
                        <div> <input id="cb_p_mil_dep" type="checkbox"> Pensão Militar DEP 1,5% </div>
                        <input id="val_pj" type="text"> R$, PENSÃO JUDICIAL<br>
                    </div>
                    <div id="dados_fixo">
                        <div id="foto"></div>
                        <div id="dados_usuario">
                            <b>TURMA:</b> 2013<br><br>
                            <b>DATA DE PRAÇA:</b> 12/04/2012<br><br>
                            <b>ULTIMA PROMOÇÃO:</b> 29/11/2013<br><br>
                        </div>
                    </div>
                </div>
                <div id="dados_informacoes">
                    <div id="div_imposto">
                        <!--
                    <table id="imposto_de_renda">
                        <tr><td colspan="2">Faixa Salarial R$</td><td colspan="4">Imposto de Renda</td></tr>
                        <tr><td>De (>=)</td><td>Até (<=)</td><td>Alíquota %</td><td>Valor Máximo</td><td>Valor Usado</td><td>Rendimentos</td></tr>
                        <tr id="fx1"><td>...</td><td>1903,98</td><td>00,0</td><td>0,00</td><td>-</td>
                            <td rowspan="5" id="rendimentos"> 
                                <input id="imp_rend_tributaveis" type="text"> Rend. Tributáveis<br>
                                <input id="imp_deducoes" type="text"> Deduções<br>
                                <input id="imp_base_calculo" type="text"> Base de Cálculo
                            </td>
                        </tr>
                        <tr id="fx2"><td>1903,99</td><td>2826,65</td><td>07,5</td><td>922,67</td><td>-</td></tr>
                        <tr id="fx3"><td>2826,66</td><td>3751,05</td><td>15,0</td><td>924,40</td><td>-</td></tr>
                        <tr id="fx4"><td>3751,06</td><td>4664,68</td><td>22,5</td><td>913,63</td><td>-</td></tr>
                        <tr id="fx5"><td>4664,69</td><td>...</td><td>27,5</td><td>...</td><td>-</td></tr>
                    </table>
                    -->
                    </div>
                    <hr>
                    <p>Informações:</p><br>
                    <div id="dados_informacoes_div">
                        <div><input id="nr_dep_irpf" type="number" min=0>Nr Dependentes p/ Fins IRPF</div>
                        <div><input id="nr_dep_fam" type="number" min=0> Nr Dependentes p/ Fins Salário Família</div>
                        <div><input id="nr_filhos" type="number" min=0> Nr Filhos</div>
                        <div><input id="nr_filhos_menor_6" type="number" min=0> Nr Filhos menores de 6 anos</div>
                        <div><input id="val_diario_transporte" type="text"> R$, Valor diário do Vale Transporte</div>
                        <div><input id="cb_perc_pnr_gestoria" type="checkbox"> <input id="perc_pnr_gestoria" type="text" value="3,5"> %, Desconto PNR (UN. Gestoria)</div>
                        <div><input id="cb_perc_pnr_manut" type="checkbox"> <input id="perc_pnr_manut" type="text" value="0,5"> %, Desconto PNR (F Ex - Manut)</div>
                        <div><input id="cb_perc_pnr_const" type="checkbox"> <input id="perc_pnr_const" type="text" value="1,0"> %, Desconto PNR (F Ex - Const)</div>
                        <span id="info-sal-familia"></span>
                    </div>
                </div>
                Responsável pelo Exame de Pagamento:<br>
                <span id="resp_exame"></span>
                <hr>
                <p>Editar Abas:</p><br>
                <div id="add_aba">
                    <button id="add_aba_new">Add Aba</button>
                    <select id="select_tipo_aba">
                        <option>RECEITA</option>
                        <option>DESPESA</option>
                    </select>
                    <input id="add_aba_titulo" name="titulo" type="text" value="" placeholder="TÍTULO">
                    <input id="add_aba_porcento" name="percent" type="text" value="" placeholder="%">
                    <input id="add_aba_valor_pesquisado" type="text" value="" placeholder="VALOR PESQUISADO">
                    <input id="add_aba_valor_contra_cheque" type="text" value="" placeholder="VALOR CONTRACHEQUE">
                    <input id="add_aba_observacoes" type="text" value="" placeholder="OBSERVAÇÕES">
                </div>
                <div id="remove_aba">
                    <button id="remove_aba_del">Remover Aba</button>
                    <select id="select_remove_aba">
                    </select>
                </div>
            </div>
        </div>
    </body>
</html>
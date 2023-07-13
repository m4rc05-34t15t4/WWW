<?php 
    include_once "base.php";
    $ficha = $_GET["ficha_aux"];
    $conteudo = '<tr class="cabecalho">
    <td colspan="2">UG: 160179</td>
    <td colspan="2" id="precp">Prec-CP: 602914091</td>
    <td colspan="2"><div id="mes">MÊS: <select class="inp_mes"><option value="JANEIRO">JANEIRO</option><option value="FEVEREIRO">FEVEREIRO</option><option value="MARÇO">MARÇO</option><option value="ABRIL">ABRIL</option><option value="MAIO">MAIO</option><option value="JUNHO">JUNHO</option><option value="JULHO">JULHO</option><option value="AGOSTO">AGOSTO</option><option value="SETEMBRO">SETEMBRO</option><option value="OUTUBRO">OUTUBRO</option><option value="NOVEMBRO">NOVEMBRO</option><option value="DEZEMBRO" selected="">DEZEMBRO</option></select></div></td></tr>
<tr class="cabecalho">
    <td colspan="3">POST/GRAD/MATR NOME: </td>
    <td colspan="3" id="nome_ident">Ten Cel <b>ROGÉRIO</b> RICARDO DA SILVA</td>
</tr>
<tr class="cabecalho">
    <td colspan="3" id="idt">IDT: 0115380347</td>
    <td colspan="3" id="cpf">CPF: 7022914710</td>
</tr>
<tr id="tr_receita">
    <td class="dados_tipo">R<br>E<br>C<br>E<br>I<br>T<br>A</td>
    <td colspan="5" class="dados_contra_cheque">
        <table id="receita">
            <tbody><tr>
                <td>DISCRIMININAÇÃO</td>
                <td>%</td>
                <td>VALOR<br>PESQUISADO</td>
                <td><div id="div_botao_clonar"><div>VALOR<br>CONTRACHEQUE</div><div><span data-tooltip="Clonar Valores Pesquisados"><div id="clonar_val_pesquisado"></div></span></div></div></td>
                <td><div id="div_botao_observacoes"><div>OBSERVAÇÕES<br></div><div><span data-tooltip="Limpar Dados Coluna Observações"><div id="limpar_dados_observacoes"></div></span></div></div></td>
            </tr>
            <tr id="soldo">
                <td><input class="inp_titulo" type="text" placeholder="SOLDO"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_militar">
                <td><input class="inp_titulo" type="text" placeholder="ADIC MIL"></td>
                <td>25</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_hab">
                <td><input class="inp_titulo" type="text" placeholder="ADC HAB"></td>
                <td>0</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_disp">
                <td><input class="inp_titulo" type="text" placeholder="ADIC DISP"></td>
                <td>26</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_pqdt">
                <td><input class="inp_titulo" type="text" placeholder="ADIC C ORG PQDT"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_perm">
                <td><input class="inp_titulo" type="text" placeholder="ADIC PERMAN"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_grat_loc_esp_tip_a">
                <td><input class="inp_titulo" type="text" placeholder="GRAT LOC ESP TIP A"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_grat_rep_2">
                <td><input class="inp_titulo" type="text" placeholder="GRAT REP 2%"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="salario_familia">
                <td><input class="inp_titulo" type="text" placeholder="SALÁRIO FAMÍLIA"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="assist_pre_escolar">
                <td><input class="inp_titulo" type="text" placeholder="ASSIST. PRÉ-ESCOLAR"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_aux_trasnp">
                <td><input class="inp_titulo" type="text" placeholder="AUX. TRANSP."></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_ferias">
                <td><input class="inp_titulo" type="text" placeholder="ADIC FÉRIAS"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_nat_jun">
                <td><input class="inp_titulo" type="text" placeholder="ADIC NATALINO JUN"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="adc_nat_nov">
                <td><input class="inp_titulo" type="text" placeholder="ADIC NATALINO NOV"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="aux_fard">
                <td><input class="inp_titulo" type="text" placeholder="AUX FARD 1 SOLD"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="aux_nat">
                <td><input class="inp_titulo" type="text" placeholder="AUX NATALIDADE"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
        </tbody></table>
    </td>
</tr>
<tr id="tr_despesa">
    <td class="dados_tipo">D<br>E<br>S<br>P<br>E<br>S<br>A</td>
    <td colspan="5" class="dados_contra_cheque">
        <table id="despesa">
            <tbody><tr id="p_mil_105">
                <td><input class="inp_titulo" type="text" placeholder="P MIL 10.5%"></td>
                <td>10,5</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="p_mil_15">
                <td><input class="inp_titulo" type="text" placeholder="P MIL DEP 1,5%"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="fusex_3">
                <td><input class="inp_titulo" type="text" placeholder="FUSEX 3%"></td>
                <td>3</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="desc_dep_fusex">
                <td><input class="inp_titulo" type="text" placeholder="DESC DEP FUSEX"></td>
                <td>0,5</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="imposto_renda">
                <td><input class="inp_titulo" type="text" placeholder="IMPOSTO RENDA"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="pnr_gestora">
                <td><input class="inp_titulo" type="text" placeholder="PNR (UN. GESTORA)"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="pnr_manut">
                <td><input class="inp_titulo" type="text" placeholder="PNR (F Ex - Manut)"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="pnr_const">
                <td><input class="inp_titulo" type="text" placeholder="PNR (F Ex - Const)"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="imp_renda_13">
                <td><input class="inp_titulo" type="text" placeholder="IMPOSTO RENDA 13ª"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="da_aux_transp">
                <td><input class="inp_titulo" type="text" placeholder="DA AUX. TRANSP."></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
            <tr id="da_ad_nat_n_ded">
                <td><input class="inp_titulo" type="text" placeholder="DA AD NAT N DED"></td>
                <td>-</td>
                <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                <td><input class="inp_descricao" type="text"></td>
            </tr>
        </tbody></table>
    </td>
</tr>
<tr>
    <td id="rodape_data" class="rodape" colspan="6"><input name="rodape_data" type="text"></td>
</tr>
<tr>
    <td id="rodape_responsavel" class="rodape" colspan="6"><input name="rodape_responsavel" type="text"></td>
</tr>
</tbody>';
$dados = '{"#mes select":"DEZEMBRO","#select_adc_nat":"JUN","#select_resp":"0","#soldo .inp_titulo":"SOLDO","#soldo .inp_valpesquisado":"11.250,00","#soldo .inp_contracheque":"","#soldo .inp_descricao":"","#adc_militar .inp_titulo":"ADIC MIL","#adc_militar .inp_valpesquisado":"2.812,50","#adc_militar .inp_contracheque":"","#adc_militar .inp_descricao":"","#adc_hab .inp_titulo":"ADC HAB","#adc_hab .inp_valpesquisado":"0,00","#adc_hab .inp_contracheque":"","#adc_hab .inp_descricao":"","#adc_disp .inp_titulo":"ADIC DISP","#adc_disp .inp_valpesquisado":"2.925,00","#adc_disp .inp_contracheque":"","#adc_disp .inp_descricao":"","#adc_pqdt .inp_titulo":"ADIC C ORG PQDT","#adc_pqdt .inp_valpesquisado":"1,00","#adc_pqdt .inp_contracheque":"","#adc_pqdt .inp_descricao":"","#adc_perm .inp_titulo":"ADIC PERMAN","#adc_perm .inp_valpesquisado":"11","#adc_perm .inp_contracheque":"","#adc_perm .inp_descricao":"","#adc_grat_loc_esp_tip_a .inp_titulo":"GRAT LOC ESP TIP A","#adc_grat_loc_esp_tip_a .inp_valpesquisado":"1,11","#adc_grat_loc_esp_tip_a .inp_contracheque":"","#adc_grat_loc_esp_tip_a .inp_descricao":"","#adc_grat_rep_2 .inp_titulo":"GRAT REP 2%","#adc_grat_rep_2 .inp_valpesquisado":"11,11","#adc_grat_rep_2 .inp_contracheque":"","#adc_grat_rep_2 .inp_descricao":"","#salario_familia .inp_titulo":"SALÁRIO FAMÍLIA","#salario_familia .inp_valpesquisado":"0,64","#salario_familia .inp_contracheque":"","#salario_familia .inp_descricao":"","#assist_pre_escolar .inp_titulo":"ASSIST. PRÉ-ESCOLAR","#assist_pre_escolar .inp_valpesquisado":"1.155,60","#assist_pre_escolar .inp_contracheque":"","#assist_pre_escolar .inp_descricao":"","#adc_aux_trasnp .inp_titulo":"AUX. TRANSP.","#adc_aux_trasnp .inp_valpesquisado":"0,00","#adc_aux_trasnp .inp_contracheque":"","#adc_aux_trasnp .inp_descricao":"","#adc_ferias .inp_titulo":"ADIC FÉRIAS","#adc_ferias .inp_valpesquisado":"5.666,50","#adc_ferias .inp_contracheque":"","#adc_ferias .inp_descricao":"","#adc_nat_jun .inp_titulo":"ADIC NATALINO JUN","#adc_nat_jun .inp_valpesquisado":"8.505,31","#adc_nat_jun .inp_contracheque":"","#adc_nat_jun .inp_descricao":"","#adc_nat_nov .inp_titulo":"ADIC NATALINO NOV","#adc_nat_nov .inp_valpesquisado":"","#adc_nat_nov .inp_contracheque":"","#adc_nat_nov .inp_descricao":"","#aux_fard .inp_titulo":"AUX FARD 1 SOLD","#aux_fard .inp_valpesquisado":"11.250,00","#aux_fard .inp_contracheque":"","#aux_fard .inp_descricao":"","#aux_nat .inp_titulo":"AUX NATALIDADE","#aux_nat .inp_valpesquisado":"","#aux_nat .inp_contracheque":"","#aux_nat .inp_descricao":"","#p_mil_105 .inp_titulo":"P MIL 10.5%","#p_mil_105 .inp_valpesquisado":"1.784,95","#p_mil_105 .inp_contracheque":"","#p_mil_105 .inp_descricao":"","#p_mil_15 .inp_titulo":"P MIL DEP 1,5%","#p_mil_15 .inp_valpesquisado":"","#p_mil_15 .inp_contracheque":"","#p_mil_15 .inp_descricao":"","#fusex_3 .inp_titulo":"FUSEX 3%","#fusex_3 .inp_valpesquisado":"509,98","#fusex_3 .inp_contracheque":"","#fusex_3 .inp_descricao":"","#desc_dep_fusex .inp_titulo":"DESC DEP FUSEX","#desc_dep_fusex .inp_valpesquisado":"85,00","#desc_dep_fusex .inp_contracheque":"","#desc_dep_fusex .inp_descricao":"","#imposto_renda .inp_titulo":"IMPOSTO RENDA","#imposto_renda .inp_valpesquisado":"2.840,98","#imposto_renda .inp_contracheque":"","#imposto_renda .inp_descricao":"","#pnr_gestora .inp_titulo":"PNR (UN. GESTORA)","#pnr_gestora .inp_valpesquisado":"","#pnr_gestora .inp_contracheque":"","#pnr_gestora .inp_descricao":"","#pnr_manut .inp_titulo":"PNR (F Ex - Manut)","#pnr_manut .inp_valpesquisado":"","#pnr_manut .inp_contracheque":"","#pnr_manut .inp_descricao":"","#pnr_const .inp_titulo":"PNR (F Ex - Const)","#pnr_const .inp_valpesquisado":"","#pnr_const .inp_contracheque":"","#pnr_const .inp_descricao":"","#imp_renda_13 .inp_titulo":"IMPOSTO RENDA 13ª","#imp_renda_13 .inp_valpesquisado":"2.840,98","#imp_renda_13 .inp_contracheque":"","#imp_renda_13 .inp_descricao":"","#da_aux_transp .inp_titulo":"DA AUX. TRANSP.","#da_aux_transp .inp_valpesquisado":"","#da_aux_transp .inp_contracheque":"","#da_aux_transp .inp_descricao":"","#da_ad_nat_n_ded .inp_titulo":"DA AD NAT N DED","#da_ad_nat_n_ded .inp_valpesquisado":"","#da_ad_nat_n_ded .inp_contracheque":"","#da_ad_nat_n_ded .inp_descricao":""}';
?>
</head>
    <body>
        <div id="cabecalho">
            <div id="titulo"><span id="nome_copia"><?php echo $ficha; ?></span>
            <button id="btnSalvar" type="button">Salvar</button></div>
        </div>
        <div id="conteudo_2">
            <table id="ficha_auxiliar" dados='<?php echo $dados ?>'>
                <?php echo $conteudo; ?>
            </table>
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
    </body>
    <script type="text/javascript">
        $json_valores = JSON.parse($("#ficha_auxiliar").attr("dados"));
        console.log("json_valores", $json_valores);
        for (key in $json_valores) {
            $(key).val($json_valores[key]);
        }

        function RemoveCaracteresEspeciais(string){
            return string.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        }

        //click

        $("#add_aba_new").click(function (e) {
        $select_tipo_aba = $("#select_tipo_aba").val().toLowerCase();
        $add_aba_titulo = $("#add_aba_titulo").val();
        $add_aba_porcento = $("#add_aba_porcento").val();
        $add_aba_valor_pesquisado = $("#add_aba_valor_pesquisado").val();
        $add_aba_valor_contra_cheque = $("#add_aba_valor_contra_cheque").val();
        $add_aba_observacoes = $("#add_aba_observacoes").val();
        if($add_aba_porcento == "") $add_aba_porcento = "-";
        $html = `    <tr id="${$select_tipo_aba[0]+"_"+RemoveCaracteresEspeciais($add_aba_titulo)}">
                                    <td><input class="inp_titulo" type="text" placeholder="${$add_aba_titulo}"></td>
                                    <td>${$add_aba_porcento}</td>
                                    <td><input class="inp_valpesquisado" type="text"></td>
                                    <td><input class="inp_contracheque" type="text"></td>
                                    <td><input class="inp_descricao" type="text"></td>
                                </tr>`;
        $("#"+$select_tipo_aba+" tbody").append($html);
        $("#select_remove_aba").append(`<option value="${$select_tipo_aba[0]+"_"+RemoveCaracteresEspeciais($add_aba_titulo)}">${$select_tipo_aba[0]+"_"+$add_aba_titulo}</option>`);
        $("#"+$select_tipo_aba[0]+"_"+RemoveCaracteresEspeciais($add_aba_titulo)+" .inp_titulo").val($add_aba_titulo);
        $("#"+$select_tipo_aba[0]+"_"+RemoveCaracteresEspeciais($add_aba_titulo)+" .inp_valpesquisado").val($add_aba_valor_pesquisado);
        $("#"+$select_tipo_aba[0]+"_"+RemoveCaracteresEspeciais($add_aba_titulo)+" .inp_contracheque").val($add_aba_valor_contra_cheque);
        $("#"+$select_tipo_aba[0]+"_"+RemoveCaracteresEspeciais($add_aba_titulo)+" .inp_descricao").val($add_aba_observacoes);
        $("#add_aba_titulo, #add_aba_porcento, #add_aba_valor_pesquisado, #add_aba_valor_contra_cheque, #add_aba_observacoes").val("");
        $(".inp_contracheque, .inp_valpesquisado").mask('000.000,00', {reverse: true});

        $("#remove_aba_del").click(function (e) {
            $('#'+$("#select_remove_aba").val()).remove();
            $('#select_remove_aba option:selected').remove();
        });

        $("#div_botao_clonar #clonar_val_pesquisado").click(function (e) {
            if($(this).hasClass("ativado")){
                $(this).removeClass("ativado");
                $("#receita tr .inp_contracheque, #despesa .inp_contracheque").val("");
            }
            else {
                $(this).addClass("ativado");
                $elementos = $("#receita tr:not(tr:nth-child(1)) .inp_valpesquisado, #despesa .inp_valpesquisado");
                for($i=0; $i < $elementos.length; $i++){
                    //console.log($elementos[$i].value, $elementos[$i].parentElement.parentElement.attributes.id.value);
                    $("#"+$elementos[$i].parentElement.parentElement.attributes.id.value+" .inp_contracheque").val($elementos[$i].value);
                }
            }
        });

        function Get_table_contracheque(post_grad, nome){

            $body = $("#ficha_auxiliar").html();
            $elementos = {"#mes select" : $("#mes select").val(), "#select_adc_nat" : $("#select_adc_nat").val(), "#select_resp" : $("#select_resp").val(), 
                "#rodape_responsavel input" : $("#rodape_responsavel input").val(), "#rodape_data input" : $("#rodape_data input").val()};
            $tr_inp = $("#receita tr:has(input), #despesa tr:has(input)");
            for($i=0; $i < $tr_inp.length; $i++){
                $elementos["#"+$tr_inp[$i].id+" .inp_titulo"] = $("#"+$tr_inp[$i].id+" .inp_titulo").val();
                $elementos["#"+$tr_inp[$i].id+" .inp_valpesquisado"] = $("#"+$tr_inp[$i].id+" .inp_valpesquisado").val();
                $elementos["#"+$tr_inp[$i].id+" .inp_contracheque"] = $("#"+$tr_inp[$i].id+" .inp_contracheque").val();
                $elementos["#"+$tr_inp[$i].id+" .inp_descricao"] = $("#"+$tr_inp[$i].id+" .inp_descricao").val();
            }
            //console.log("elementos", $elementos);

            $tabela = '<div id="content"><div id="content-contracheque"><div>'+post_grad+' '+nome+'</div>';

            $tabela += $("#tabela_contracheque").html();

            //console.log("entrada", $tabela);

            //tabela histórico
            $tabela = $tabela.replace($("#historico-fichas").html(), '');
            $tabela = $tabela.replace('<div id="historico-fichas"></div>', '');

            ///(<select class="inp_mes">).*(</select>)/g;
            var myRe = new RegExp('(<select class="inp_mes">).*(</select>)', 'g');
            $tabela = $tabela.replace(myRe, $("#mes .inp_mes").val());

            ///(<div id="div_botao_clonar"><div>)|(<\/div><div><span data-tooltip="Clonar Valores Pesquisados"><div id="clonar_val_pesquisado"><\/div><\/span><\/div><\/div>)|(<div id="div_botao_observacoes"><div>)|(<br><\/div><div><span data-tooltip="Limpar Dados Coluna Observações"><div id="limpar_dados_observacoes"><\/div><\/span><\/div><\/div>)/g
            myRe = new RegExp('(<div id="div_botao_clonar"><div>)|(<\/div><div><span data-tooltip="Clonar Valores Pesquisados"><div id="clonar_val_pesquisado"><\/div><\/span><\/div><\/div>)|(<\/div><div><span data-tooltip="Clonar Valores Pesquisados"><div id="clonar_val_pesquisado" class=""><\/div><\/span><\/div><\/div>)|(<\/div><div><span data-tooltip="Clonar Valores Pesquisados"><div id="clonar_val_pesquisado" class="ativado"><\/div><\/span><\/div><\/div>)|(<div id="div_botao_observacoes"><div>)|(<br><\/div><div><span data-tooltip="Limpar Dados Coluna Observações"><div id="limpar_dados_observacoes"><\/div><\/span><\/div><\/div>)', 'g');
            $tabela = $tabela.replace(myRe, '');

            $input_titulo = $(".inp_titulo");
            for($i=0; $i<$input_titulo.length; $i++){
                $attr_id_pai = $input_titulo[$i].parentElement.parentElement.attributes.id.value;
                $percentual = $("#"+$attr_id_pai+" td:nth-child(2)").html();
                $valpesquisado = $("#"+$attr_id_pai+" .inp_valpesquisado").val();
                $contracheque = $("#"+$attr_id_pai+" .inp_contracheque").val();
                $descricao = $("#"+$attr_id_pai+" .inp_descricao").val();
                $tex_ant = `<input class="inp_titulo" type="text" placeholder="${$input_titulo[$i].attributes.placeholder.value}"></td>
                                        <td>${$percentual}</td>
                                        <td><input class="inp_valpesquisado" type="text" maxlength="10"></td>
                                        <td><input class="inp_contracheque" type="text" maxlength="10"></td>
                                        <td><input class="inp_descricao" type="text"></td>`;
                $text_pos = `${$('.inp_titulo[placeholder="'+$input_titulo[$i].attributes.placeholder.value+'"]').val()}</td>
                                        <td>${$percentual}</td>
                                        <td>${$valpesquisado}</td>
                                        <td>${$contracheque}</td>
                                        <td>${$descricao}</td>`;
                ;
                $tabela = $tabela.replace($tex_ant, $text_pos);

                //console.log($tex_ant, $text_pos, $input_titulo[$i], $attr_id_pai, $percentual, $valpesquisado, $contracheque, $descricao);                
            }

            //Rodape
            $tabela = $tabela.replace('<input name="rodape_data" type="text">', $("#rodape_data input").val());
            $tabela = $tabela.replace('<input name="rodape_responsavel" type="text">', '<span>'+$("#rodape_responsavel input").val()+'</span>');

            $tabela += '</div></div>'+"<!--"+$VERSAO+"#body#" + $body + "#body#" + JSON.stringify($elementos) + "#body#-->";

            //var myArray = myRe.exec($tabela); console.log("Regex: " + myRe.lastIndex, myArray);
            //console.log("saida", $tabela);
            return String($tabela);
        }

        $("#btnSalvar").click(function (e) {
            $post_grad = "";
            $n = $("#select_nome").split("_");
            $nome_arq = $n[0]+"_"+String(Date.now())+"_"+$n[2];
            $.post("../php/criar_html.php", {
                tabela: Get_table_contracheque($post_grad, $nome),
                nome_arq : $nome_arq,
                post_grad: $post_grad
                },
                function(result){
                    console.log(result);
                    if(result == ' arquivo criado ') window.open("export.php?ficha_auxiliar="+$nome_arq, '_blank');
                    else alert("Erro ao Salvar Arquivo, tente novamente, se o erro persistir fale com Responsável.");   
                }
            );
        });
    });
    </script>
</html>
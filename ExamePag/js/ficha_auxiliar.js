$(document).ready(function(){
    //Variáveis Globais

    let $VERSAO = "2.0.1"; //2023-03-28 13:18

    $USUARIOS = [];
    $ADICIONAIS = [];
    $OUTROS = {};
    $IMPOSTO_RENDA = [];

    //AÇÕES

    var sBrowser, sUsrAg = navigator.userAgent;

    if(sUsrAg.indexOf("Chrome") > -1) {
        sBrowser = "Google Chrome";
    } else if (sUsrAg.indexOf("Safari") > -1) {
        sBrowser = "Apple Safari";
    } else if (sUsrAg.indexOf("Opera") > -1) {
        sBrowser = "Opera";
    } else if (sUsrAg.indexOf("Firefox") > -1) {
        sBrowser = "Mozilla Firefox";
    } else if (sUsrAg.indexOf("MSIE") > -1) {
        sBrowser = "Microsoft Internet Explorer";
    }

    //alert("Você está utilizando: " + sBrowser);
    
    //dados imp rend            faixas salario (ate)                aliquotas (das faixas salariais)            
    Faixas_imposto_renda([1903.98, 2826.65, 3751.05, 4664.68], [0, 7.5, 15, 22.5, 27.5]);
    ImpostoRenda_Table();
    
    LerCSVAdicionais();
    LerCSVOutros();
    LerUsuarios();

    console.log("USUARIOS", $USUARIOS);
    console.log("ADICIONAIS", $ADICIONAIS);
    console.log("OUTROS", $OUTROS);
    console.log("IMPOSTO_RENDA", $IMPOSTO_RENDA);

    Valida_Usuarios($USUARIOS);

    PopulaSelect();

    Input_Titulo();

    //VALIDAÇÃO DE CARACTERES TIPO REAL R$
    $("#val_adc_pqdt, #val_adc_perm, #val_adc_grat_loc_esp_tip_a, #val_adc_grat_rep_2, #val_pj, #val_diario_transporte, #add_aba_valor_pesquisado, #add_aba_valor_contra_cheque, .inp_contracheque, .inp_valpesquisado, #imp_rend_tributaveis, #imp_deducoes, #imp_base_calculo").mask('000.000,00', {reverse: true});
    $("#perc_pnr_gestoria, #perc_pnr_manut, #perc_pnr_const, #add_aba_porcento").mask('000,0', {reverse: true});

    //EVENTOS

    $("input:not(.inp_contracheque, .inp_valpesquisado, .inp_descricao, #add_aba input, #imp_rend_tributaveis, #imp_deducoes, #imp_base_calculo, #rodape_data input, .inp_titulo), #select_adc_nat, radio, #val_pj").change(function() {
        PopularValores();
    });

    $("#imp_base_calculo").change(function() {
        Valor_pago_imposto(Moeda_Float($(this).val()));
    });

    $("#imp_rend_tributaveis, #imp_deducoes").change(function() {
        ImpostoRenda(Moeda_Float($("#imp_rend_tributaveis").val()), Moeda_Float($("#imp_deducoes").val()));
    });

    $("#dados_auxiliares #resp_exame select").change(function() {
        $("#ficha_auxiliar #rodape_responsavel input").val(NomeGuerra($USUARIOS[$(this).val()])+' - '+$USUARIOS[$(this).val()]["post_grad"].split(" | ")[0]);
    });

    $("#nr_dep_irpf, #nr_dep_fam, #nr_filhos, #nr_filhos_menor_6").on("keypress", function(e) { if(!checkChar(e, "[0-9]", 2, $(this).val())) e.preventDefault(); });
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
    });
    
    $("#remove_aba_del").click(function (e) {
        $('#'+$("#select_remove_aba").val()).remove();
        $('#select_remove_aba option:selected').remove();
    });

    $("#clonar_val_pesquisado").click(function (e) {
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

    $("#limpar_dados_observacoes").click(function (e) {
        $("#receita tr .inp_descricao, #despesa .inp_descricao").val("");
    });

    $("#btnSalvar").click(function (e) {
        $id = $("#select_nome").val();
        $nome = $USUARIOS[$id]["nome_guerra"];
        $post_grad = $USUARIOS[$id]["post_grad"].split(" | ")[0];
        if($nome == "" || $nome == undefined) $nome = $USUARIOS[$id]["nome"];
        $nome_arq = Idt_mil($USUARIOS[$id]["idt_mil"])+"_"+String(Date.now())+"_"+$nome;
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
    
    //FUNÇÕES

    function valida_text(usu, msg_erro, dict_erro = $msg_erro){
        try { 
            if(usu !== "") {
                if(usu.indexOf("/") == -1) {
                    try{
                        if(parseInt(usu) >= 0)  dict_erro.push(msg_erro);
                    } catch (d) { 
                        console.log(d);
                    }
                }
                else throw true;
            }
        } catch (e) { dict_erro.push(msg_erro); }
    }

    function valida_int(usu, msg_erro, dict_erro = $msg_erro){
        try { 
            if(usu.length > 0) {
                if(!(parseInt(usu) >= 0)) throw true;
            }
        } catch (e) { dict_erro.push(msg_erro); }
    }

    function valida_data(usu, msg_erro, dict_erro = $msg_erro){
        try { 
            if(usu != '') {
                $aux = usu.split("/");
                $dia = parseInt($aux[0]);
                $mes = parseInt($aux[1]);
                $ano = parseInt($aux[2]);
                if( !( $dia <= 31 && $dia >=1 && $mes <= 12 && $mes >=1 && $ano <= 2050 && $ano >= 1900) ) {
                    throw true;
                }
            }
        } catch (e) { dict_erro.push(msg_erro); }
    }

    function valida_postgrad(post_grad, dict_erro = $msg_erro){
        $graduacoes = [
            "Gen Ex",
            "Gen Div",
            "Gen Bri",
            "Cel",
            "Ten Cel",
            "Maj",
            "Cap",
            "Cap | QAO",
            "1º Ten",
            "1º Ten | QAO",
            "1º Ten | Temp",
            "2º Ten",
            "2º Ten | QAO",
            "2º Ten | Temp",
            "Asp Of",
            "Asp Of | Temp",
            "S Ten",
            "1º Sgt",
            "2º Sgt",
            "2º Sgt | QE",
            "3º Sgt",
            "3º Sgt | QE",
            "3º Sgt | Temp",
            "Cb",
            "Cb Ev",
            "Sd Ep",
            "Sd Ev"
        ]
        
        if($graduacoes.indexOf(post_grad) == -1) dict_erro.push("Erro no posto e graduação!");
    }

    function Valida_Usuarios(usuarios){
        $erros = [];
        for ($i=0; $i < usuarios.length; $i++){
            $usu = usuarios[$i];
            $msg_erro = [];
            valida_int($usu["Nascimento"], "Data do dia de nascimento inválida!");
            valida_int($usu["cpf"], "CPF inválido!");
            valida_text($usu["curso"], "Curso inválido!");
            valida_data($usu["data_praca"], "Data de Praça inválida!");
            valida_int($usu["idt_mil"], "Idt Militar inválida!");
            valida_text($usu["nome"], "Nome inválido!");
            valida_text($usu["nome_guerra"], "Nome de Guerra inválido!");
            valida_int($usu["nr_dep_irpf"], "Número de dependentes para imposto de renda inválido!");
            valida_int($usu["nr_dep_sal_fam"], "Número de dependentes para salário família inválido!");
            valida_int($usu["nr_filhos"], "Número de filhos inválido!");
            valida_int($usu["nr_filhos_menos_6"], "Número de filhos menores de 6 anos inválido!");
            valida_int($usu["precp"], "PREC inválido!");
            valida_data($usu["turma"], "Data de turma inválida!");
            valida_data($usu["ult_promo"], "Data de ultima promoção inválida!");
            valida_postgrad($usu["post_grad"]);

            if($msg_erro.length > 0) $erros.push($usu["nome"]+" "+$usu["post_grad"]+" - "+$msg_erro.join(","));
        }
        if($erros.length > 0) {
            console.log("Valida Erros Usuários: ", $erros);
            alert($erros.join("\n"));
        }
    }

    function Get_historico_fichas_auxiliares($idt_mil){
        $.get("../php/listar_historico_fichas.php", {
            idt_mil: $idt_mil
            },
            function(result){
                //console.log("listar_fichas: ",result.sort());
                $conteudo = "Não há histórico de fichas auxiliares para este militar.";
                if(result.length > 0){
                    $historico = result.sort();
                    $conteudo = '<ul>';
                    for($i=$historico.length-1; $i>=0; $i--){
                        var date = new Date(parseInt($historico[$i].split("_")[1]));
                        $data_hora = formataData(date)+" "+DuasCasas(date.getHours())+":"+DuasCasas(date.getMinutes())+":"+DuasCasas(date.getSeconds());
                        $conteudo += `<li><a href="export.php?ficha_auxiliar=${$historico[$i].replace(".html", "")}" target="_blank">${$historico[$i]} | ${$data_hora}</a> <button class="editar_historico" ficha="${$historico[$i]}">Clonar</button></li>`;
                    }
                    $conteudo += '</ul>';
                }

                $("#historico-fichas-conteudo").html($conteudo);
                
                //click

                //clonar
                $(".editar_historico").click(function (e) {
                    window.open("edicao.php?ficha_aux="+$(this).attr("ficha")); 
                });
            }
        );
    }

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

    function Input_Titulo(){
        $elementos = $("#receita tr .inp_titulo, #despesa .inp_titulo");
        //console.log($elementos);
        for($i=0; $i < $elementos.length; $i++){
            //console.log($("#"+$elementos[$i].parentElement.parentElement.attributes.id.value+" .inp_titulo"), $elementos[$i].attributes.placeholder.value);
            $("#"+$elementos[$i].parentElement.parentElement.attributes.id.value+" .inp_titulo").val($elementos[$i].attributes.placeholder.value);
        }
    }

    function ImpostoRenda_Table(){
        $imposto_table = `
            <table id="imposto_de_renda">
                <tr><td colspan="2">Faixa Salarial R$</td><td colspan="5">Imposto de Renda</td></tr>
                <tr><td>De (>=)</td><td>Até (<=)</td><td>Alíquota</td><td>Valor<br>Máx</td><td>Valor<br>Usado</td><td>Imposto</td><td>Rendimentos</td></tr>`;
        for($i=0; $i < $IMPOSTO_RENDA.length; $i++){
            $imposto_table += `<tr id="fx${$i+1}"><td>${Moeda($IMPOSTO_RENDA[$i]["faixa"]["de"])}</td><td>${Moeda($IMPOSTO_RENDA[$i]["faixa"]["ate"])}</td><td>${String($IMPOSTO_RENDA[$i]["aliquota"]).replace(".",",")} %</td><td>${$IMPOSTO_RENDA[$i]["valor_max"]}</td><td>-</td><td>-</td>`;
            if($i == 0){
                $imposto_table += 
                    `<td rowspan="${$IMPOSTO_RENDA.length}" id="rendimentos"> 
                        <input id="imp_rend_tributaveis" type="text"> Rend. Tributáveis<br>
                        <input id="imp_deducoes" type="text"> Deduções<br>
                        <input id="imp_base_calculo" type="text"> Base de Cálculo
                    </td>`;
            }
            $imposto_table += '</tr>';
        }
        $imposto_table += '</table>';
        $("#div_imposto").html($imposto_table);
    }

    function Faixas_imposto_renda(faixas, aliquotas){
        for($i=0; $i < aliquotas.length; $i++){
            if($i == 0) $IMPOSTO_RENDA[$i] = ({"faixa" : { "de" : "...", "ate" : faixas[0]},   "aliquota" : aliquotas[0], "valor_max" : faixas[0]});
            else if($i == aliquotas.length-1) $IMPOSTO_RENDA[$i] = ({"faixa" : { "de" : parseFloat((faixas[$i-1]+0.01).toFixed(2)), "ate" : "..."},   "aliquota" : aliquotas[$i], "valor_max" : "..."});
            else $IMPOSTO_RENDA[$i] = ({"faixa" : { "de" : parseFloat((faixas[$i-1]+0.01).toFixed(2)), "ate" : faixas[$i]},   "aliquota" : aliquotas[$i], "valor_max" : parseFloat((faixas[$i] - parseFloat((faixas[$i-1]+0.01).toFixed(2))).toFixed(2))});
        }
    }

    function RemoveCaracteresEspeciais(string){
        return string.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
    }

    function PopulaSelect(){
        //POPULA SELECT NOME
        $select_resp = '<select id="select_resp">';
        $select = '<select id="select_nome">';
        for ($i=0; $i<$USUARIOS.length; $i++) {
            $select += '<option value="'+$i+'">'+$USUARIOS[$i]["post_grad"].split(" | ")[0]+" "+$USUARIOS[$i]["nome"]+'</option>';
            if($ADICIONAIS[$USUARIOS[$i]["post_grad"]]["circulo_hierarquico"].indexOf("ciais") > 0 ) $select_resp += '<option value="'+$i+'">'+$USUARIOS[$i]["nome"]+' - '+$USUARIOS[$i]["post_grad"].split(" | ")[0]+'</option>';
        }
        $select += '</select>';
        $select_resp += '</select>';
        $("#nome").html($select);
        
        //resp exame
        $("#resp_exame").html($select_resp);
        $("#ficha_auxiliar #rodape_responsavel input").val(NomeGuerra($USUARIOS[$("#dados_auxiliares #resp_exame select").val()])+' - '+$USUARIOS[$("#dados_auxiliares #resp_exame select").val()]["post_grad"].split(" | ")[0]);
        
        //Popula Select Mês
        var d = new Date();
        var month = d.getMonth();
        $meses = ["JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DEZEMBRO"];
        $select = '<select class="inp_mes">';
        for ($i=0; $i<$meses.length; $i++) {
            $selected = ""
            if(month == $i){
                $selected = " selected";
            }
            $select += '<option value="'+$meses[$i]+'" '+$selected+'>'+$meses[$i]+'</option>';
        }
        $select += '</select>';
        $("#mes").html("MÊS: "+$select);

        //Popula Histórico
        Get_historico_fichas_auxiliares(Idt_mil($USUARIOS[0]["idt_mil"]));

        //Data documento
        var d = new Date();
        var anoC = d.getFullYear();
        var mesC = d.getMonth();
        
        //var d1 = new Date (anoC, mesC, 1);
        var d2 = new Date (anoC, mesC+1, 0);
        
        //console.log(formataData(d1));
        $("#rodape_data input").val("Olinda-PE, "+formataData(d2));

        PopulaDados($USUARIOS[$("#select_nome").val()]);
        //EVENTOS
        $("#select_nome").on('change', function() {
            PopulaDados($USUARIOS[this.value]);
            Get_historico_fichas_auxiliares(Idt_mil($USUARIOS[this.value]["idt_mil"]));
            $("#receita tr .inp_contracheque, #despesa .inp_contracheque").val("");
            $("#clonar_val_pesquisado").removeClass("ativado");
            $("#receita tr .inp_descricao, #despesa .inp_descricao").val("");
        });

    }

    function DuasCasas(valor){
        if(parseInt(valor) < 10) valor = "0"+valor;
        return valor;
    }

    function formataData(data, separador = " de ", diasemana = false) {
        var diaS = data.getDay();
        var diaM = data.getDate();
        var mes = data.getMonth();
        var ano = data.getFullYear();
        
        switch (diaS) { //converte o numero em nome do dia
            case 0:
                diaS = "Domingo";
                break;
            case 1: 
                diaS = "Segunda-feira";
                break;
            case 2:
                diaS = "Terça-feira";
                break;
            case 3:
                diaS = "Quarta-feira";
                break;
            case 4:
                diaS = "Quinta-feira";
                break;
            case 5:
                diaS = "Sexta-feira";
                break;
            case 6:
                diaS = "Sabado";
                break;
        }
       
        switch (mes) { //converte o numero em nome do mês
            case 0:
                mes = "Janeiro";
                break;
            case 1:
                mes = "Fevereiro";
                break;
            case 2:
                mes = "Março";
                break;
            case 3:
                mes = "Abril";
                break;
            case 4:
                mes = "Maio";
                break;
            case 5:
                mes = "Junho";
                break;
            case 6:
                mes = "Julho";
                break;
            case 7:
                mes = "Agosto";
                break;
            case 8:
                mes = "Setembro";
                break;
            case 9:
                mes = "Outubro";
                break;
            case 10:
                mes = "Novembro";
                break;
            case 11:
                mes = "Dezembro";
                break;
        }
        
        if (diaM.toString().length == 1)
            diaM = "0"+diaM;
        if (mes.toString().length == 1)
            mes = "0"+mes;
        
        $dia_semana = "";
        if(diasemana) $dia_semana = diaS + ", ";

        return  $dia_semana + diaM + separador + mes + separador + ano;
    }
       

    function PopulaDados(usuario){
        $("#precp").html("Prec-CP: "+usuario["precp"]);
        $("#cpf").html("CPF: "+usuario["cpf"]);
        $("#idt").html("IDT: "+Idt_mil(usuario["idt_mil"]));
        if(usuario["post_grad"].indexOf(" | ") > 0){
            $militar_tipo_valor = usuario["post_grad"].split(" | ")
            $("#nome_ident").html($militar_tipo_valor[0]+" "+NomeGuerra(usuario));
            $militar_tipo = document.getElementsByName("militar_tipo");
            for($i=0; $i < $militar_tipo.length; $i++){
                if($militar_tipo[$i].value == $militar_tipo_valor[1] || ($militar_tipo[$i].value == "Temporário" && $militar_tipo_valor[1] == "Temp")){
                    $militar_tipo[$i].checked = true;
                }
            }
        }
        else{
            $("#nome_ident").html(usuario["post_grad"]+" "+NomeGuerra(usuario));
            $("#r_tipo_carr")[0].checked = true;
        }
        $curso = document.getElementsByName("curso");
        for($i=0; $i < $curso.length; $i++){
            if($curso[$i].value == usuario["curso"] || ($curso[$i].value == "Sem Curso" && usuario["curso"] == "")){
                $curso[$i].checked = true;
            }
        }
        $("#foto").css("background", "url('../img/militares/"+Idt_mil(usuario["idt_mil"])+".jpg'), url('../img/usuario.png')");
        $("#foto").css("background-repeat", "no-repeat");
        $("#foto").css("background-size", "cover");
        $("#foto").css("background-position", "center");
        $("#dados_usuario").html("<b>TURMA:</b> "+usuario["turma"]+"<br><br><b>DATA DE PRAÇA:</b> "+usuario["data_praca"]+"<br><br><b>ULTIMA PROMOÇÃO:</b> "+usuario["ult_promo"]+"<br><br>");
        $mes = $(".inp_mes").val();
        if($mes == "JUNHO") $("#select_adc_nat")[0][0].selected = true;
        else if($mes == "NOVEMBRO") $("#select_adc_nat")[0][1].selected = true;
        if($mes == "JUNHO" || $mes == "NOVEMBRO") $("#cb_adc_nat")[0].checked = true;
        $soldo = parseFloat($ADICIONAIS[usuario["post_grad"]]["soldo"]);
        $("#soldo .inp_valpesquisado").val(Moeda($soldo));
        PopularValores();
    }

    function NomeGuerra(usuario){
        $nomes_guerra = usuario["nome_guerra"].split(" ");
        $nomes = usuario["nome"].split(" ");
        $j = 0;
        for($i=0; $i < $nomes.length; $i++){
            while($j < $nomes_guerra.length){
                if(String($nomes_guerra[$j]).length == 1){
                    if($nomes[$i][0].indexOf($nomes_guerra[$j]) >= 0){
                        $n = "<b>"+$nomes[$i][0]+"</b>";
                        for($x=1;$x < $nomes[$i].length; $x++){
                            $n += $nomes[$i][$x];
                        }
                        $nomes[$i] = $n;
                        //console.log("1)", $n, "j: ", $j, "i: ", $i);
                        $j++;
                        break;
                    }
                    else{
                        $j++; 
                    }
                    
                }
                else if($nomes[$i].indexOf($nomes_guerra[$j]) >= 0 && $nomes[$i].length == $nomes_guerra[$j].length){
                    $nomes[$i] = "<b>"+$nomes[$i]+"</b>";
                    //console.log("2)", $nomes[$i], "j: ", $j, "i: ", $i);
                    $j++;
                    break;
                }
                else {
                    //console.log("Erro nome de guerra: ",$nomes[$i], $nomes_guerra[$j], $j, $i, $nomes, $nomes_guerra);
                    break;
                }
                
            }
        }
        //console.log($nomes.join(' '));
        return $nomes.join(' ');
    }

    function Idt_mil(idt){
        $idt = String(idt);
        if($idt.length < 8) $idt = "000"+$idt;
        else if($idt.length < 9) $idt = "00"+$idt;
        else if($idt.length < 10) $idt = "0"+$idt;

        return $idt;
    }

    function PopularValores(){
        var usuario = $USUARIOS[$("#select_nome").val()];
        $("#adc_militar td:nth-child(2)").html(usuario["post_grad"].indexOf("Sd Ev") >= 0 ? '-' : $ADICIONAIS[usuario["post_grad"]]["adc_militar"]);
        $("#adc_militar .inp_valpesquisado").val(Moeda(usuario["post_grad"].indexOf("Sd Ev") >= 0 ? 0.00 : parseFloat($ADICIONAIS[usuario["post_grad"]]["adc_militar"]) * $soldo / 100));
        $("#adc_disp td:nth-child(2)").html($ADICIONAIS[usuario["post_grad"]]["adc_disp"]);
        $("#adc_disp .inp_valpesquisado").val(Moeda(parseFloat($ADICIONAIS[usuario["post_grad"]]["adc_disp"]) * $soldo / 100));
        $percadc_hab = parseFloat($OUTROS["curso"][$('#curso input[name="curso"]:checked').val()]);
        $("#adc_hab td:nth-child(2)").html($percadc_hab);
        $("#adc_hab .inp_valpesquisado").val(Moeda($percadc_hab * $soldo / 100));
        //valores
        $("#adc_perm .inp_valpesquisado").val($("#val_adc_perm").val());
        $("#adc_perm .inp_valpesquisado").val($("#val_adc_perm").val());
        $("#adc_pqdt .inp_valpesquisado").val($("#val_adc_pqdt").val());
        $("#adc_grat_loc_esp_tip_a .inp_valpesquisado").val($("#val_adc_grat_loc_esp_tip_a").val());
        $("#adc_grat_rep_2 .inp_valpesquisado").val($("#val_adc_grat_rep_2").val());
        $("#salario_familia .inp_valpesquisado").val(Moeda($("#nr_dep_fam").val() * 0.16));
        Assist_Pre_Escolar();
        ValeTransporte();
        Adc_Ferias();
        if($("#cb_aux_fard").is(":checked")) $("#aux_fard .inp_valpesquisado").val($("#soldo .inp_valpesquisado").val());
        else $("#aux_fard .inp_valpesquisado").val("");
        if($("#cb_aux_natalidade").is(":checked")) $("#aux_nat .inp_valpesquisado").val($("#soldo .inp_valpesquisado").val());
        else $("#aux_nat .inp_valpesquisado").val("");
        Despesas();
        PNR();
        Adc_Natalino();
    }

    function Assist_Pre_Escolar(){

        $base = parseFloat($ADICIONAIS["Sd Ep"]["soldo"]);
        $assist = $perc = 0;
        $aux_pre_esc = 321;
        $nr_filhos_6 =parseInt($("#nr_filhos_menor_6").val());
        var valor = (Moeda_Float($("#soldo .inp_valpesquisado").val()) + 
            Moeda_Float($("#adc_militar .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_hab .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_disp .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_perm .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_pqdt .inp_valpesquisado").val())).toFixed(2);
        
        $texto = "<br><b>Pré Escolar informações:</b><br/>";
        if(valor / $base <= 5){
            $perc = 5;
            $assist = ($aux_pre_esc - ($aux_pre_esc * ($perc / 100)));
        } 
        else if(valor / $base <= 10) {
            $perc = 10;
            $assist = ($aux_pre_esc - ($aux_pre_esc * ($perc / 100)));
        }
        else if(valor / $base <= 15) {
            $perc = 15;
            $assist = ($aux_pre_esc - ($aux_pre_esc * ($perc / 100)));
        }
        else if(valor / $base <= 20) {
            $perc = 20;
            $assist = ($aux_pre_esc - ($aux_pre_esc * ($perc / 100)));
        }
        else if(valor / $base > 20) {
            $perc = 25;
            $assist = ($aux_pre_esc - ($aux_pre_esc * ($perc / 100)));
        }

        $texto += "<b>BC</b> ("+Moeda($base)+") | <b>VB</b> ("+Moeda(valor)+") <b>Faixa Rem</b> ("+Moeda(valor / $base)+"X) <br><b>Cota</b> ("+$perc+"% - "+($aux_pre_esc * ($perc / 100))+") | <b>Salário Fam.</b> ("+Moeda($assist)+")";
        $("#info-sal-familia").html($texto);

        //console.log($base, $assist, $nr_filhos_6, Moeda($nr_filhos_6 * $assist), valor / $base);

        $("#assist_pre_escolar .inp_valpesquisado").val(Moeda($nr_filhos_6 * $assist));

    }

    function PNR(){
        $soldo = Moeda_Float($("#soldo .inp_valpesquisado").val());
        if($("#cb_perc_pnr_gestoria").is(":checked")){
            $("#pnr_gestora .inp_valpesquisado").val(Moeda(Moeda_Float($("#perc_pnr_gestoria").val()) / 100 * $soldo));
            $("#pnr_gestora td:nth-child(2)").html($("#perc_pnr_gestoria").val());
        }
        if($("#cb_perc_pnr_manut").is(":checked")){
            $("#pnr_manut .inp_valpesquisado").val(Moeda(Moeda_Float($("#perc_pnr_manut").val()) / 100 * $soldo));
            $("#pnr_manut td:nth-child(2)").html($("#perc_pnr_manut").val());
        }
        if($("#cb_perc_pnr_const").is(":checked")){
            $("#pnr_const .inp_valpesquisado").val(Moeda(Moeda_Float($("#perc_pnr_const").val()) / 100 * $soldo));
            $("#pnr_const td:nth-child(2)").html($("#perc_pnr_const").val());
        }

    }

    function Despesas(){
        var valor = (Moeda_Float($("#soldo .inp_valpesquisado").val()) + 
            Moeda_Float($("#adc_militar .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_hab .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_disp .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_perm .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_pqdt .inp_valpesquisado").val())).toFixed(2);
        
            //Pensão 10,5
            $("#p_mil_105 .inp_valpesquisado").val(Moeda((valor * 0.105).toFixed(2)));
            $("#p_mil_105 td:nth-child(2)").html("10,5");

            //pensão 1,5
            if($("#cb_p_mil_dep").is(":checked")){
                $("#p_mil_15 .inp_valpesquisado").val(Moeda((valor * 0.015).toFixed(2)));
                $("#p_mil_15 td:nth-child(2)").html("1,5");
            }
            else{
                $("#p_mil_15 .inp_valpesquisado").val("");
                $("#p_mil_15 td:nth-child(2)").html("-");
            }

            //fusex 3,0
            var usuario = $USUARIOS[$("#select_nome").val()];
            $se_sd_ev = usuario["post_grad"].indexOf("Sd Ev") >= 0;
            if(!$se_sd_ev){
                $("#fusex_3 .inp_valpesquisado").val(Moeda((valor * 0.03).toFixed(2)));
                $("#fusex_3 td:nth-child(2)").html("3");
            }
            else{
                $("#fusex_3 .inp_valpesquisado").val(Moeda(0.00));
                $("#fusex_3 td:nth-child(2)").html("-");
            }

            //Desconto Dependentes fusex
            if(parseInt($("#nr_filhos").val()) > 1 && !$se_sd_ev){
                $("#desc_dep_fusex .inp_valpesquisado").val(Moeda((valor * 0.005).toFixed(2)));
                $("#desc_dep_fusex td:nth-child(2)").html("0,5");
            }
            else if(parseInt($("#nr_filhos").val()) == 1 && !$se_sd_ev){
                $("#desc_dep_fusex .inp_valpesquisado").val(Moeda((valor * 0.004).toFixed(2)));
                $("#desc_dep_fusex td:nth-child(2)").html("0,4");
            }
            else{
                $("#desc_dep_fusex .inp_valpesquisado").val("");
                $("#desc_dep_fusex td:nth-child(2)").html("-");
            }
    }

    function Adc_Natalino(){

        $("#adc_nat_jun .inp_valpesquisado, #adc_nat_nov .inp_valpesquisado, #imp_rend_tributaveis, #imp_deducoes, #imp_base_calculo").val("");

        var imp_tributaveis = (( Moeda_Float($("#soldo .inp_valpesquisado").val()) + 
            Moeda_Float($("#adc_militar .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_hab .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_disp .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_perm .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_pqdt .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_grat_rep_2 .inp_valpesquisado").val()))).toFixed(2);
        
        //Imposto de Renda
        ImpostoRenda(imp_tributaveis);

        //Adicional Natalino
        if($("#cb_adc_nat").is(":checked")){
            if($("#select_adc_nat").val() == "JUN") $("#adc_nat_jun .inp_valpesquisado").val(Moeda((imp_tributaveis / 2).toFixed(2)));
            else if($("#select_adc_nat").val() == "NOV") $("#adc_nat_nov .inp_valpesquisado").val(Moeda(imp_tributaveis));
            
            $("#imp_renda_13 .inp_valpesquisado").val($("#imposto_renda .inp_valpesquisado").val());
        }
        else $("#imp_renda_13 .inp_valpesquisado").val("");
    }

    function Adc_Ferias(){
        if($("#cb_adc_ferias").is(":checked")){
            var valor = (( Moeda_Float($("#soldo .inp_valpesquisado").val()) + 
            Moeda_Float($("#adc_militar .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_hab .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_disp .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_perm .inp_valpesquisado").val()) +
            Moeda_Float($("#adc_pqdt .inp_valpesquisado").val()) ) / 3).toFixed(2);

            $("#adc_ferias .inp_valpesquisado").val(Moeda(valor));
        }
        else $("#adc_ferias .inp_valpesquisado").val("");
    }

    function ImpostoRenda(imp_tributaveis, deducoes = null){
        //Imposto de Renda Rendimentos Tributáveis
        $("#imp_rend_tributaveis").val(Moeda(imp_tributaveis));
        
        //Imposto de Renda - Deduções
        if(deducoes == null){
            deducoes = (Moeda_Float($("#p_mil_105 .inp_valpesquisado").val()) + 
                Moeda_Float($("#p_mil_15 .inp_valpesquisado").val()) + 
                Moeda_Float($("#fusex_3 .inp_valpesquisado").val()) + 
                Moeda_Float($("#desc_dep_fusex .inp_valpesquisado").val()) +
                Moeda_Float($("#val_pj").val()) +
                ((2275.08 / 12) * $("#nr_dep_irpf").val())).toFixed(2);
        }
        $("#imp_deducoes").val(Moeda(deducoes));
        
        //Imposto de Renda Base Cálculo
        var base_calculo = imp_tributaveis - deducoes;
        if(base_calculo < 0) base_calculo = 0;
        $("#imp_base_calculo").val(Moeda(base_calculo));
        
        Valor_pago_imposto(base_calculo);
    }

    function Valor_pago_imposto(base_calculo){
        $imposto_pago = 0.0;
        //Valores Usados
        for($i=0; $i < $IMPOSTO_RENDA.length; $i++){
            if(base_calculo <= 0) {
                $("#fx"+($i+1)+" td:nth-child(6)").html("-");
                $("#fx"+($i+1)+" td:nth-child(5)").html("-");
                $imp = 0;
            }
            else if($IMPOSTO_RENDA[$i]["valor_max"] == "..."){
                $("#fx"+($i+1)+" td:nth-child(5)").html(Moeda(base_calculo));
                $imp = base_calculo * $IMPOSTO_RENDA[$i]["aliquota"] / 100;
                $("#fx"+($i+1)+" td:nth-child(6)").html(Moeda($imp));
                base_calculo = 0;
            }
            else if($IMPOSTO_RENDA[$i]["valor_max"] <= base_calculo){
                base_calculo -= $IMPOSTO_RENDA[$i]["valor_max"];
                $("#fx"+($i+1)+" td:nth-child(5)").html(Moeda($IMPOSTO_RENDA[$i]["valor_max"]));
                $imp = $IMPOSTO_RENDA[$i]["valor_max"] * $IMPOSTO_RENDA[$i]["aliquota"] / 100
                $("#fx"+($i+1)+" td:nth-child(6)").html(Moeda($imp));
            }
            else{
                $("#fx"+($i+1)+" td:nth-child(5)").html(Moeda(base_calculo));
                $imp = base_calculo * $IMPOSTO_RENDA[$i]["aliquota"] / 100;
                $("#fx"+($i+1)+" td:nth-child(6)").html(Moeda($imp));
                base_calculo = 0;
            }
            $imposto_pago += $imp;
        }
        $("#imposto_renda .inp_valpesquisado").val(Moeda($imposto_pago));
    }

    function ValeTransporte(){
        var valor = ((Moeda_Float($("#val_diario_transporte").val()) * 22) - ((Moeda_Float($("#soldo .inp_valpesquisado").val()) * 0.06 * 22) / 30)).toFixed(2);
        if(valor < 0) valor = 0.00;
        $("#adc_aux_trasnp .inp_valpesquisado").val(Moeda(valor));
    }

    function Moeda_Float(moeda){
        var valor = 0;
        if(moeda) valor = parseFloat(moeda.replace(".","").replace(",","."));
        return valor;
    }

    function Moeda(valor){
        if(valor){
            if(valor != "..."){
                valor = parseFloat(valor).toFixed(2);
                valor = valor.toString().replace(/\D/g,"");
                valor = valor.toString().replace(/(\d)(\d{8})$/,"$1.$2");
                valor = valor.toString().replace(/(\d)(\d{5})$/,"$1.$2");
                valor = valor.toString().replace(/(\d)(\d{2})$/,"$1,$2");
            }
        }
        else valor = "0,00";
        return valor
    }

    function LerUsuarios(){
        $.ajax({
            type: "GET",
            url: "../csv/militares.csv",
            dataType: "text",
            async: false,
            success: function(allText) {
                var allTextLines = allText.split(/\r\n|\n/);
                var headers = allTextLines[0].split(',');
                $USUARIOS = [];
                for (var i=1; i<allTextLines.length; i++) {
                    var data = allTextLines[i].split(',');
                    if (data.length == headers.length) {
                        var tarr = {};
                        for (var j=0; j<headers.length; j++) {
                            tarr[headers[j]] = data[j];
                        }
                        $USUARIOS.push(tarr);
                    }
                }
            }
         });
    }

    function LerCSVAdicionais(){
        $.ajax({
            type: "GET",
            url: "../csv/adicionais.csv?time="+new Date(),
            dataType: "text",
            async: false,
            success: function(allText) {
                var allTextLines = allText.split(/\r\n|\n/);
                var headers = allTextLines[0].split(',');
                $ADICIONAIS = [];
                for (var i=1; i<allTextLines.length; i++) {
                    var data = allTextLines[i].split(',');
                    if (data.length == headers.length) {
                        var tarr = {};
                        var attr = "";
                        for (var j=0; j<headers.length; j++) {
                            if(headers[j] != "post_grad") tarr[headers[j]] = data[j];
                            else attr = data[j];
                        }
                        if($ADICIONAIS[attr] === undefined) $ADICIONAIS[attr] = [];
                        $ADICIONAIS[attr] = tarr;
                    }
                }
            }
        });
    }

    function LerCSVOutros(){
        $.ajax({
            type: "GET",
            url: "../csv/outros.csv?time="+new Date(),
            dataType: "text",
            async: false,
            success: function(allText) {
                var allTextLines = allText.split(/\r\n|\n/);
                var headers = allTextLines[0].split(',');
                $OUTROS = {};
                for (var i=1; i<allTextLines.length-1; i++) {
                    var data = allTextLines[i].split(',');
                    if (data.length == headers.length) {
                        var tarr = {};
                        for (var j=0; j<headers.length; j++) {
                            tarr[headers[j]] = data[j];
                        }
                        if($OUTROS[tarr.grupo] === undefined) $OUTROS[tarr.grupo] = [];
                        $OUTROS[tarr.grupo][tarr.descricao] = tarr.valor;
                    }
                }
            }
        });
    }

});
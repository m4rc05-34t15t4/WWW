<?php

    if(!isset($link)) $link = "../";

    include_once $link."php/conexao.php";

    if( !isset($_GET["usuario"]) OR !isset($_GET["dificuldade"]) ){
        echo 0; //ERRO SERÁ TRATADO NO JS, ERRO: FALTA DE PARÂMETRO
    }
    elseif( ($_GET["dificuldade"] != "Fácil") AND ($_GET["dificuldade"] != "Média") AND ($_GET["dificuldade"] != "Difícil") ){
        echo 1; //ERRO SERÁ TRATADO NO JS, ERRO: Dificuldade com dado errado
    }
    else{
        //DEFINE AS VARIAVEIS
        date_default_timezone_set('America/Recife');
        $data_inicio_edicao = date('Y') . "-" . date('m') . "-" . date('d') . " " . date("H") . ":" . date("i") . ":" . date("s");
        $editor = strval($_GET["usuario"]);
        $limite_servidor = 11;
        $primeira_dificuldade = strval($_GET["dificuldade"]);
        $segunda_dificuldade = "";
        $terceira_dificuldade = "";
        //verifica os possíveis niveis apos o nível desejado, no qual foi recebido por parâmetro GET
        switch($primeira_dificuldade){
            case "Fácil":
                $primeira_dificuldade = "Média";
                $segunda_dificuldade = "Difícil";
                $terceira_dificuldade = "Fácil";
                break;
            case "Média":
                $primeira_dificuldade = "Difícil";
                $segunda_dificuldade = "Fácil";
                $terceira_dificuldade = "Média";
                break;
            case "Difícil":
                $primeira_dificuldade = "Fácil";
                $segunda_dificuldade = "Média";
                $terceira_dificuldade = "Difícil";
                break;
        }

        //QUERY para Pedir carta 
        $sql = "
            --Função Retorna ID Carta solicitada vendo as prioridades SRV LOCAL TRUE<br>
            CREATE OR REPLACE FUNCTION QTD_MI_LOCAL(_dificuldade text) RETURNS bigint AS $$
                BEGIN
                    RETURN 
                        --RETORNA MI SOLICITADO<br>
                        (SELECT id FROM public.edicao WHERE status = '2' AND niveis = _dificuldade AND (editor isnull OR  length(editor) < 1) AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco, mi LIMIT 1);
                END;
            $$ LANGUAGE plpgsql;

            --Função Retorna Campos Válidos de srv
            CREATE OR REPLACE FUNCTION srv_validacao(_srv_edicao character varying, _srv_revisao character varying) RETURNS character varying AS $$
                BEGIN
                    RETURN 
                        CASE 
                            WHEN CAST(_srv_edicao as integer) >= 0 THEN _srv_edicao
                            ELSE _srv_revisao
                        END;
                END;
            $$ LANGUAGE plpgsql;

            --Função Retorna Valor valor zero
            CREATE OR REPLACE FUNCTION Valor_validacao(_valor character varying) RETURNS integer AS $$
                BEGIN
                    RETURN 
                        CASE 
                            WHEN CAST(_valor as integer) >= 0 THEN CAST(_valor AS INTEGER)
                            ELSE 0
                        END;
                END;
            $$ LANGUAGE plpgsql;

            --Função Retorna ID Carta solicitada vendo as prioridades<br>
            CREATE OR REPLACE FUNCTION QTD_MI(_dificuldade text) RETURNS bigint AS $$
                BEGIN
                    RETURN 
                        (SELECT id FROM
                            --RETORNA MI SOLICITADO<br>
                            (SELECT * FROM public.edicao WHERE status = '2' AND niveis = _dificuldade AND (editor isnull OR  length(editor) < 1) AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco, mi)
                        AS carta_solicitada INNER JOIN  
                            --<br>--Retorna lista qtd servidor totais<br>
                            (SELECT srv_validacao(srv_editor, srv_revisor) as srv , SUM( Valor_validacao(CAST(qtd_editor as character varying)) + Valor_validacao(CAST(qtd_rev as character varying)) ) as qtd FROM
                                --<br>--Retorna lista qtd servidor editor, unido com usuarios<br>
                                (SELECT servidor as srv_editor, Count(editor) as qtd_editor FROM 			
                                    (SELECT CAST(editor as integer) as editor, servidor FROM public.edicao WHERE status = '3' OR status = '60' OR status = '80' GROUP BY editor, servidor ORDER BY CAST(editor as integer)) 
                                AS tabela_editor_srv JOIN
                                    (SELECT codigo, nome, srv_local FROM public.usuarios)
                                AS tabela_nome_editor ON tabela_editor_srv.editor = tabela_nome_editor.codigo WHERE srv_local is not true GROUP BY srv_editor)
                            AS lista_qtd_servidor_editor FULL JOIN
                                --<br>--Retorna lista qtd revisor unido com usuarios<br>
                                (SELECT servidor as srv_revisor, Count(revisor) as qtd_rev FROM 
                                    (
								 		(SELECT CAST(revisor1 as integer) as revisor, servidor FROM public.edicao WHERE status = '5' GROUP BY revisor1, servidor ORDER BY CAST(revisor1 as integer))
								 	UNION
								 		(SELECT CAST(revisor2 as integer) as revisor, servidor FROM public.edicao WHERE status = '7' GROUP BY revisor2, servidor ORDER BY CAST(revisor2 as integer))
                                	)
                                AS tabela_revisor_srv JOIN
                                    (SELECT codigo, nome, srv_local FROM public.usuarios)
                                AS tabela_nome_revisor ON tabela_revisor_srv.revisor = tabela_nome_revisor.codigo WHERE srv_local is not true GROUP BY srv_revisor)
                            AS lista_qtd_servidor_revisor ON srv_editor = srv_revisor GROUP BY srv ORDER BY CAST(srv_validacao(srv_editor, srv_revisor) as integer))
                        AS lista_servidores ON carta_solicitada.servidor = lista_servidores.srv WHERE qtd < $limite_servidor ORDER BY bloco, qtd, mi LIMIT 1);
                END;
            $$ LANGUAGE plpgsql;

            --Faz o pedido da carta para edição<br>
            UPDATE public.edicao SET status = '3', editor = '$editor', inicioedicao = '$data_inicio_edicao' WHERE id =  
                CASE
                    WHEN
                        --retorna true se o usuario for local<br>
                        ((SELECT srv_local FROM public.usuarios WHERE codigo = CAST('$editor' as integer)) = true) AND
                        --retornar id carta reservada<br>
                        ((SELECT id FROM public.edicao WHERE status = '2' AND editor = '$editor' AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco LIMIT 1) > 0)
                    THEN
                        --retornar id carta reservada<br>
                        (SELECT id FROM public.edicao WHERE status = '2' AND editor = '$editor' AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco LIMIT 1)
                    WHEN
                        --retorna true se o usuario for local<br>
                        ((SELECT srv_local FROM public.usuarios WHERE codigo = CAST('$editor' as integer)) = true) AND
                        --retorna carta usuário srv_local true<br>
                        ((SELECT id FROM public.edicao WHERE id = 
                            --Define o nível da proxima carta do usuário<br>
                            CASE 
                                WHEN QTD_MI_LOCAL('$primeira_dificuldade') > 0 THEN QTD_MI_LOCAL('$primeira_dificuldade')
                                WHEN QTD_MI_LOCAL('$segunda_dificuldade') > 0 THEN QTD_MI_LOCAL('$segunda_dificuldade')
                                WHEN QTD_MI_LOCAL('$terceira_dificuldade') > 0 THEN QTD_MI_LOCAL('$terceira_dificuldade')
                            END 
                        AND status = '2' AND (editor isnull OR length(editor) < 1) AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco, mi LIMIT 1) > 0)
                    THEN
                        --retorna carta usuário srv_local true
                        (SELECT id FROM public.edicao WHERE id = 
                            --Define o nível da proxima carta do usuário<br>
                            CASE 
                                WHEN QTD_MI_LOCAL('$primeira_dificuldade') > 0 THEN QTD_MI_LOCAL('$primeira_dificuldade')
                                WHEN QTD_MI_LOCAL('$segunda_dificuldade') > 0 THEN QTD_MI_LOCAL('$segunda_dificuldade')
                                WHEN QTD_MI_LOCAL('$terceira_dificuldade') > 0 THEN QTD_MI_LOCAL('$terceira_dificuldade')
                            END 
                        AND status = '2' AND (editor isnull OR length(editor) < 1) AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco, mi LIMIT 1)
                    WHEN 
                        --Retorna MI reservado para edição caso exista espaço disponivel no servidor<br>
                        (SELECT id FROM
                            --Retorna MI reservado para usuário<br>
                            (SELECT * FROM public.edicao WHERE status = '2' AND editor = '$editor' AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco)
                        AS carta_reservada INNER JOIN  
                            --<br>--Retorna lista qtd servidor totais<br>
                            (SELECT srv_validacao(srv_editor, srv_revisor) as srv , SUM( Valor_validacao(CAST(qtd_editor as character varying)) + Valor_validacao(CAST(qtd_rev as character varying)) ) as qtd FROM
                                --<br>--Retorna lista qtd servidor editor, unido com usuarios<br>
                                (SELECT servidor as srv_editor, Count(editor) as qtd_editor FROM 			
                                    (SELECT CAST(editor as integer) as editor, servidor FROM public.edicao WHERE status = '3' OR status = '60' OR status = '80' GROUP BY editor, servidor ORDER BY CAST(editor as integer)) 
                                AS tabela_editor_srv JOIN
                                    (SELECT codigo, nome, srv_local FROM public.usuarios)
                                AS tabela_nome_editor ON tabela_editor_srv.editor = tabela_nome_editor.codigo WHERE srv_local is not true GROUP BY srv_editor)
                            AS lista_qtd_servidor_editor FULL JOIN
                                --<br>--Retorna lista qtd revisor unido com usuarios<br>
                                (SELECT servidor as srv_revisor, Count(revisor) as qtd_rev FROM 
                                    (
								 		(SELECT CAST(revisor1 as integer) as revisor, servidor FROM public.edicao WHERE status = '5' GROUP BY revisor1, servidor ORDER BY CAST(revisor1 as integer))
								 	UNION
								 		(SELECT CAST(revisor2 as integer) as revisor, servidor FROM public.edicao WHERE status = '7' GROUP BY revisor2, servidor ORDER BY CAST(revisor2 as integer))
                                	)
                                AS tabela_revisor_srv JOIN
                                    (SELECT codigo, nome, srv_local FROM public.usuarios)
                                AS tabela_nome_revisor ON tabela_revisor_srv.revisor = tabela_nome_revisor.codigo WHERE srv_local is not true GROUP BY srv_revisor)
                            AS lista_qtd_servidor_revisor ON srv_editor = srv_revisor GROUP BY srv ORDER BY CAST(srv_validacao(srv_editor, srv_revisor) as integer))
                        AS lista_servidores ON carta_reservada.servidor = lista_servidores.srv WHERE qtd < $limite_servidor ORDER BY bloco, qtd, mi LIMIT 1) > 0
                    THEN 
                        --Retorna MI reservado para edição caso exista espaço disponivel no servidor<br>
                        (SELECT id FROM
                            --Retorna MI reservado para usuário<br>
                            (SELECT * FROM public.edicao WHERE status = '2' AND editor = '$editor' AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco)
                        AS carta_reservada INNER JOIN  
                            --<br>--Retorna lista qtd servidor totais<br>
                            (SELECT srv_validacao(srv_editor, srv_revisor) as srv , SUM( Valor_validacao(CAST(qtd_editor as character varying)) + Valor_validacao(CAST(qtd_rev as character varying)) ) as qtd FROM
                                --<br>--Retorna lista qtd servidor editor, unido com usuarios<br>
                                (SELECT servidor as srv_editor, Count(editor) as qtd_editor FROM 			
                                    (SELECT CAST(editor as integer) as editor, servidor FROM public.edicao WHERE status = '3' OR status = '60' OR status = '80' GROUP BY editor, servidor ORDER BY CAST(editor as integer)) 
                                AS tabela_editor_srv JOIN
                                    (SELECT codigo, nome, srv_local FROM public.usuarios)
                                AS tabela_nome_editor ON tabela_editor_srv.editor = tabela_nome_editor.codigo WHERE srv_local is not true GROUP BY srv_editor)
                            AS lista_qtd_servidor_editor FULL JOIN
                                --<br>--Retorna lista qtd revisor unido com usuarios<br>
                                (SELECT servidor as srv_revisor, Count(revisor) as qtd_rev FROM 
                                    (
								 		(SELECT CAST(revisor1 as integer) as revisor, servidor FROM public.edicao WHERE status = '5' GROUP BY revisor1, servidor ORDER BY CAST(revisor1 as integer))
								 	UNION
								 		(SELECT CAST(revisor2 as integer) as revisor, servidor FROM public.edicao WHERE status = '7' GROUP BY revisor2, servidor ORDER BY CAST(revisor2 as integer))
                                	)
                                AS tabela_revisor_srv JOIN
                                    (SELECT codigo, nome, srv_local FROM public.usuarios)
                                AS tabela_nome_revisor ON tabela_revisor_srv.revisor = tabela_nome_revisor.codigo WHERE srv_local is not true GROUP BY srv_revisor)
                            AS lista_qtd_servidor_revisor ON srv_editor = srv_revisor GROUP BY srv ORDER BY CAST(srv_validacao(srv_editor, srv_revisor) as integer))
                        AS lista_servidores ON carta_reservada.servidor = lista_servidores.srv WHERE qtd < $limite_servidor ORDER BY bloco, qtd, mi LIMIT 1)
                    WHEN 
                        --Retorna id carta para produção<br>
                        (SELECT id FROM public.edicao WHERE id = 
                            --Define o nível da proxima carta do usuário<br>
                            CASE 
                                WHEN QTD_MI('$primeira_dificuldade') > 0 THEN QTD_MI('$primeira_dificuldade')
                                WHEN QTD_MI('$segunda_dificuldade') > 0 THEN QTD_MI('$segunda_dificuldade')
                                WHEN QTD_MI('$terceira_dificuldade') > 0 THEN QTD_MI('$terceira_dificuldade')
                            END 
                        AND status = '2' AND (editor isnull OR length(editor) < 1) AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco, mi LIMIT 1) > 0
                    THEN 
                        --Retorna id carta para produção<br>
                        (SELECT id FROM public.edicao WHERE id = 
                            --Define o nível da proxima carta do usuário<br>
                            CASE 
                                WHEN QTD_MI('$primeira_dificuldade') > 0 THEN QTD_MI('$primeira_dificuldade')
                                WHEN QTD_MI('$segunda_dificuldade') > 0 THEN QTD_MI('$segunda_dificuldade')
                                WHEN QTD_MI('$terceira_dificuldade') > 0 THEN QTD_MI('$terceira_dificuldade')
                            END 
                        AND status = '2' AND (editor isnull OR length(editor) < 1) AND (inicioedicao isnull OR length(inicioedicao) < 1) ORDER BY bloco, mi LIMIT 1)
                    ELSE 
                        --Retorna id carta inválido para nada ser atualizado e retornar vazio<br>
                        -1
                END
            --Faz o retorno da linha atualizada pela query<br>
            RETURNING id, editor;
        ";
        
        $query = pg_query($conexao,$sql);
        if($query) { 

            if(pg_fetch_all($query)){
            
                $row = pg_fetch_all($query);
                
                if(count($row) > 0){
                    //SUCESSO
                    echo 10;
                }
                else{
                    echo 4;
                }
            }
            else{
                echo 6;//Limite usuário no servidor ou não há cartas disponíveis
            }
        }
        else{
            echo 3; //ERRO SERÁ TRATADO NO JS, ERRO ONDE NÃO HOUVE conexão NO banco de dados, 
                    //possívelmente não solicitou carta, se aparecer nas pendentes verificar com adm
        }
    }

?>
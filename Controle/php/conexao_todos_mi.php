<?php


if(!isset($link)) $link = "../";

include_once $link."php/conexao.php";

Cria_variaveis_auxiliares();

$lista_edicao = Busca_dados("SELECT mi, status, niveis, editor, revisor1, revisor2, servidor FROM public.edicao ORDER BY mi"); 

if(count($lista_edicao) > 0){
    
    $lista_usuarios = Busca_dados("SELECT codigo, nome FROM public.usuarios ORDER BY nome");
    
    $lista_fases_edicao = Busca_dados("SELECT * FROM public.\"Fases_Edicao\" ORDER BY codigo"); 

    Exibe_json();

}
else{

    //Erro tratado no Javascript
    return 0;

}

//FUNÇÕES

//Faz busca na Tabela edicao
function Busca_dados_edicao(){

    global $conexao;
    global $lista_edicao;

    $sql = "SELECT mi, status, niveis, editor, revisor1, revisor2, servidor FROM public.edicao ORDER BY mi";
    $query = pg_query($conexao,$sql);
    if($query) {
        $row = pg_fetch_all($query);
        for($i=0; $i < count($row); $i++){
            $lista_edicao[$i] = $row[$i];
        }
        return true;
    }
    return false;
}

//Faz busca na Tabela Fases_Edicao
function Busca_dados($sql){

    global $conexao;

    $query = pg_query($conexao,$sql);
    if($query) {
        return $row = pg_fetch_all($query);
    }
    return false;
}

//Cria variaveis auxiliares
function Cria_variaveis_auxiliares(){
    $GLOBALS["lista_edicao"] = array();
    $GLOBALS["lista_usuarios"] = array();
    $GLOBALS["lista_fases_edicao"] = array();
}

//Exibe JSON
function Exibe_json(){

    global $lista_edicao;
    global $lista_usuarios;
    global $lista_fases_edicao;

    //exibir pagina como json
    header('Content-Type: application/json');

    $resultado = array(
        0 => $lista_edicao,
        1 => $lista_usuarios,
        2 => $lista_fases_edicao
    );

    echo json_encode($resultado);
}

?>
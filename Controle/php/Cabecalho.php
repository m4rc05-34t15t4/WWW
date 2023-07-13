<?php
    $usu_login = "";
    $usu_codigo = "";
    $usu_usuario = "Faça login!";
    $usu_funcao = "";
    $usu_status = "Entrar";
    $usu_mi = '1509-2-SE';

    if( isset($_SESSION['login']) AND isset($_SESSION['senha']) AND isset($_SESSION['codigo']) OR isset($_SESSION['usuario']) AND isset($_SESSION['funcao']) ){
        $usu_login = $_SESSION['login'];
        $usu_codigo = $_SESSION['codigo'];
        $usu_usuario = $_SESSION['usuario'];
        $usu_funcao = $_SESSION['funcao'];
        $usu_status = "<a href=\"sessao_destroi.php?pagina=" . $pagina . "\">Sair</a>";
        
        //retorna último mi se for necessário para funcao do usuário, caso contrário mostra o definido em cima;
        if($_SESSION['funcao'] > 64){
            
            include_once $link."php/conexao.php";

            $sql = "
                SELECT mi, inicio2rev AS data, bloco FROM public.edicao WHERE revisor2 = '$usu_codigo' AND inicio2rev IS NOT null
                UNION 
                SELECT mi, termino2rev AS data, bloco FROM public.edicao WHERE revisor2 = '$usu_codigo' AND termino2rev IS NOT null
                UNION
                SELECT mi, inicio1rev AS data, bloco FROM public.edicao WHERE revisor1 = '$usu_codigo' AND inicio1rev IS NOT null
                UNION
                SELECT mi, termino1rev AS data, bloco FROM public.edicao WHERE revisor1 = '$usu_codigo' AND termino1rev IS NOT null
                UNION
                SELECT mi, inicioedicao AS data, bloco FROM public.edicao WHERE editor = '$usu_codigo' AND inicioedicao IS NOT null
                UNION
                SELECT mi, terminoedicao AS data, bloco FROM public.edicao WHERE editor = '$usu_codigo'  AND terminoedicao IS NOT null
                GROUP BY mi, data, bloco ORDER BY data DESC, bloco DESC, mi LIMIT 1;
            ";
            $query = pg_query($conexao,$sql);
            $query = pg_query($conexao,$sql);
            if($query) { 
                if(pg_fetch_row($query, 0)){
                    $row = pg_fetch_row($query, 0);
                    $usu_mi = $row[0];//mi
                }
            }
        }
    }
?>

<div class="box-confirmacao_content">
    <div class="box-confirmacao_mensagem"></div>
    <div class="box-confirmacao_botoes">
        <input id="box-confirmacao_botoes_cancelar" class="box-confirmacao_botoes_botao" type="button" value="Cancelar"/>
        <input id="box-confirmacao_botoes_confirmar" class="box-confirmacao_botoes_botao" type="button" value="Confirmar"/>
    </div>
</div>
<div class="box-confirmacao-fundo"></div>

<div class="cabecalho">Controle Produção Edição Bahia</div>

<div class="menu-lateral"></div>

<div id="botao-carta-informacoes" class="botao-menu-lateral" link="Mi_informacoes.php?mi=<?php echo $usu_mi; ?>" paginaatual=""><img src="../img/mi_preto.png" alt="Informações do MI"/></div>

<div id="botao-usuario-informacoes" class="botao-menu-lateral" link="Usuario_informacoes.php" paginaatual=""><img src="../img/usuarios_preto.png"/></div>

<div id="botao-todos-usuarios" class="botao-menu-lateral" link="Todos_usuarios.php" paginaatual=""><img src="../img/all_usuarios_preto.png"/></div>

<div id="botao-todos-mi" class="botao-menu-lateral" link="Todos_mi.php" paginaatual=""><img src="../img/all_mi_preto.png"/></div>

<div id="formulario-login" class="formularios">
    <form method="post" action="conexao_sessao.php" id="formlogin" name="formlogin" >
        <fieldset id="fie">
            <legend class="formularios-titulo">Login</legend>
            <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
            <input placeholder="login" class="formularios-imput" type="text" name="login" id="login"  /><br>
            <input placeholder="senha" class="formularios-imput" type="password" name="senha" id="senha" /><br>
            <input id="formulario-login-submit" class="formularios-botoes" type="submit" value="Logar"/>
            <input id="formulario-login-cancelar" class="formularios-botoes" type="button" value="Cancelar"/>
        </fieldset>
    </form>
</div>

<?php 
    echo '<div id="usuario-perfil" login="' . $usu_login . '" codigo="' . $usu_codigo . '" funcao="' . $usu_funcao . '"></div>';
    echo '<div id="nome-usuario">' . $usu_usuario . '</div>';
    echo '<div id="status-login-usuario">' . $usu_status . '</div>';
?>
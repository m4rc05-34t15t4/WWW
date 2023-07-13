<?php 
    include_once "../base.php";
?>
    <script src="<?php echo "../js/admin.js$Versao"; ?>"></script>
</head>
    <body>
        <div id="conteudo-admin">
            <div id="titulo-admin"> Exame pagamento Admin</div>
            <div id="formulario-login">
                <h1>Administrador</h1>
                <span>Digite a senha Senha:</span>
                <input id="formulario-login-senha" type="text">
            </div>
            <div id="formulario-upload">
                <form method="post" action="recebe_upload.php" enctype="multipart/form-data">
                <h1>Enviar arquivos CSV</h1>
                    <input type="file" name="arquivo" />
                    <input type="submit" value="Enviar" />
                </form>
            </div>

        </div>
    </body>
</html>
<?php 
    if(!isset($link)) $link = "../";
    
    include_once $link."php/base.php";
?>
    <script src="<?php echo $link."js/todos_usuarios.js$Versao"; ?>"></script>
</head>
    <body>
        
        <?php 
            include_once $link."php/Cabecalho.php";
            include_once $link."php/Rodape.php";
        ?>
        
        <div class="todos-usuarios group">
            
            <div class="usuario">
                <!--<table class="usuario-table">
                    <tr>
                        <td class="usuario-avatar-mini">
                        </td>
                    </tr>
                    <tr>
                        <td class="usuario-nome-mini">
                            3º Sgt Marcos Batista<br>
                            <span class="usuario-funcao-all">
                                ( Editor )
                            </span>
                        </td>
                    </tr>
                </table>-->
            </div>

        </div>

        <div class="total-situacao"></div>
    
    </body>
</html>
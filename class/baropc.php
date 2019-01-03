<?php
if (!isset($_SESSION['nome_usuario'])) {
    $_SESSION['nome_usuario'] = '';
}
?>
<div class="row">
    <div class="col-xs-12 col-md-2">
        <img src="../images/seed/porvirwhite.png"/>                   
    </div>
    <div class="col-md-offset-2 col-md-6 text-center visible-md visible-lg " >
        <h2>Consultas Administrativas GEITEC</h2>
        <h2><small>Consultas ao dados cadastrados nas bases de dados dos sistemas administrativos</small></h2>
    </div>        
</div>
<div class="row">
    <div class="col-lg-12">            
        <div class="navbar navbar-inverse navbar-static-top"> 
            <div class="container-fluid">
                <!-- Menu hamburger Inicio -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#exemplo-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Navegacao</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Título Direita do menu-->
                    <a class="navbar-brand" href="#" target="_blank">GEITEC</a>
                </div>
                <!-- Menu hamburger Fim -->
                <div class="collapse navbar-collapse" id="exemplo-navbar-collapse"> 
                    <!-- Links Inicio -->
                    <ul class="nav navbar-nav navbar-left">
                        <!-- Menu dropdown Inicio -->
                        <li><a href="../home/index.php"><span class="glyphicon glyphicon-home"></span></a></li>
                        <?php
                        if ($_SESSION['nome_usuario'] != '') {
                            $usuario = new Usuario();
                            $modulos = $usuario->listaModulosPermitidas($_SESSION['login']);
                            $paginas = $usuario->listaPaginasPermitidas($_SESSION['login']);
                            foreach ($modulos as $modulo) {
                                ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $modulo['mod_desc']; ?><span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php 
                                            foreach ($paginas as $pagina) {
                                                if($modulo['mod_desc'] == $pagina['mod_desc']){
                                                    echo '<li><a href="'.$pagina["path"].'">'.$pagina["pag_desc"].'</a></li>';
                                                }
                                        }?>                                        
                                    </ul>
                                </li>
                            <?php
                            }
                        }
                        ?>                
                    </ul>
                    <ul class="nav navbar-nav navbar-right"> 
                        <li><a href="../home/novasenha.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['nome_usuario']; ?></a></li>
                        <li><a href="../home/sairlogin.php"><span class="glyphicon glyphicon-log-in"></span> Sair</a></li>
                    </ul>
                    <!-- Menu dropdown Fim --> 
                    <!-- Links Fim -->

                </div>
            </div> 
        </div>
    </div>

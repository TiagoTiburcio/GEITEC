<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta lang="pt-BR">  
  <title>Sistema GEITEC</title>  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/estilo.css">
  <link rel='stylesheet' href='../fullcalendar/fullcalendar.css' />
  <script src='../fullcalendar/lib/jquery.min.js'></script>
  <script src='../fullcalendar/lib/moment.min.js'></script>
  <script src='../fullcalendar/fullcalendar.js'></script>
  <script src='../fullcalendar/lang/pt-br.js'></script>
  <script src="../js/calendarioservicos.js" type="text/javascript"></script>
  <script src="../js/validacampo.js" type="text/javascript"></script>  
</head>
<body>
    <div class="row">
        <div class="col-xs-12 col-lg-2">
            <img src="../images/seed/seed_colorida.svg"/>                   
        </div>
        <div class="col-xs-12 col-lg-8 text-center">
            <h2>Consultas Administrativas GEITEC</h2>
            <h2><small>Consultas ao dados cadastrados nas bases de dados dos sistemas administrativos</small></h2>
        </div>        
    </div>
    <div class="row">
        <div class="col-lg-12">
            <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand">GEITEC</a>
                </div>
                <ul class="nav navbar-nav">
                  <li><a href="../home/index.php"><span class="glyphicon glyphicon-home"></span></a></li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Contas<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../circuitos/contaanalitico.php">Conta OI Anal&iacute;tico</a></li>
                        <li><a href="../circuitos/contadetalhada.php">Conta OI Detalhado</a></li>
                        <li><a href="../circuitos/pble.php">Consulta PBLE</a></li>
                        <li><a href="../circuitos/zabbix.php">Consultas Zabbix</a></li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Servi&ccedil;os<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../servicos/servicos.php">Servi&ccedil;os</a></li>
                        <li><a href="../servicos/calendario.php">Calend&aacute;rio</a></li>
                        <li><a href="../servicos/servico_novo.php">Cadastrar Novo Servi&ccedil;o</a></li>                       
                        <li><a href="../servicos/telacentral.php">Painel Central</a></li>
                        <li><a href="../servicos/ini_tarefas.php">For&ccedil;ar Inicializar tarefas do dia</a></li>
                        <li><a href="../servicos/atualizaRedmine.php">For&ccedil;ar Atualizar Tarefas do Redmine</a></li>
                    </ul>
                  </li>  
                  <li><a href="../servidor/consultaservidor.php">Consulta Servidor</a></li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Rede Local<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../redelocal/listarsw.php">Layout Switchs Rede Local</a></li>                        
                    </ul>
                  </li>  
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Manuten&ccedil;&atilde;o Usu&aacute;rios<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../home/listarusuarios.php">Listar Todos os Usu&aacute;rios</a></li>
                        <li><a href="../home/editusuario.php">Novo Usu&aacute;rio</a></li>
                    </ul>
                  </li>                  
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="../home/novasenha.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['nome_usuario']; ?></a></li>
                  <li><a href="../home/sairlogin.php"><span class="glyphicon glyphicon-log-in"></span> Sair</a></li>
                </ul>
              </div>
            </nav>  
        </div>

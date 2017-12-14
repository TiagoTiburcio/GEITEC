<html>
<head>
  <meta charset="utf-8">
  <meta lang="pt-BR">
  <meta http-equiv="refresh" content="30" url="">  
  <title>CODIN - GEITEC</title>  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/estilo.css">
  <link rel='stylesheet' href='../fullcalendar/fullcalendar_telacentral.css' />
  <script src='../fullcalendar/lib/jquery.min.js'></script>
  <script src='../fullcalendar/lib/moment.min.js'></script>
  <script src='../fullcalendar/fullcalendar.js'></script>
  <script src='../fullcalendar/lang/pt-br.js'></script>
  <script src="../js/calendarioservicos.js" type="text/javascript"></script>  
</head>
<body>    
    <?php
        include_once '../class/principal.php';

        $usuario = new Usuario();    
        $servicos = new Servicos();
        
        //servicos->atualizaAutomaticoTarefasRedmine();
        $servicos->atuAutoRed(50);
      // $servicos->iniTarefaHoje();
        $teste = '30';
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('i');   
        if($teste == $date){        
            $servicos->iniTarefaHoje();
        }
    ?>    
    <div class="row">
        <div class="col-xs-2">
            <img src="../images/seed/seed_colorida.svg"/>                   
        </div>
        <div class="col-xs-8 text-center">
            <h2>Gest&atilde;o de Servi&ccedil;os GEITEC</h2>            
        </div>
    </div>
    <div class="row">
        <div class="col-xs-1">
            <a href="../home/index.php"><span class="glyphicon glyphicon-backward"></span></a>
        </div>    
        <div class="col-xs-10">                        
            <h3 class="titulo-painel">
            <?php
               $matricula = date ("d/m/y");
               echo"Tarefas do dia $matricula";
            ?>
            </h3>    
        </div>
    </div>    
    <div class="row">
        <div class="col-xs-4">
            <h4 class="textos-painel">A Fazer</h4>
            <div id='calendario0'>        
            </div>
        </div>
        <div class="col-xs-4">
            <h4 class="textos-painel">Em Andamento</h4>
            <div id='calendario1' class="textoCalendario">        
            </div>
        </div>
        <div class="col-xs-4">
            <h4 class="textos-painel">Conclu&iacute;do</h4>
            <div id='calendario2'>        
            </div>
        </div>        
    </div>
<?php

include ("../class/footer.php");

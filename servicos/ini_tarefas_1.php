<?php
    include_once '../class/principal.php';
    $usuario = new Usuario();    
    $servicos = new Servicos();
    $redmine = new Redmine();
    
    $usuario->validaSessao();
    
   
    

?>                
    <div class="col-xs-12">
          
    <?php
    
        echo $servicos->iniEvento("6");
        $servicos->setTarefaRedmine("16411");
        $servicos->atualizaTarefaRedimine();
        $servicos->iniTarefas("2017-10-13");
//        echo "<br/>Evento: ".$servicos->getEvento()."<br/>";
//        echo "getCodSitEvento: ".$servicos->getCodSitEvento()."<br/>";
//        echo "SituacaoEvento: ".$servicos->getSituacaoEvento()."<br/>";
//        echo "Cor Evento: ".$servicos->getCorEvento()."<br/>";
//        echo "CorTextoEvento: ".$servicos->getCorTextoEvento()."<br/>";
//        echo "TarefaRedmine()->getgetNumTarefa(): ".$servicos->getTarefaRedmine()->getNumTarefa()."<br/>";
//        echo "getTarefaRedmine()->getSitTarefa(): ".$servicos->getTarefaRedmine()->getSitTarefa()."<br/>";
//        echo "getTarefaRedmine()->getIniTarefa(: ".$servicos->getTarefaRedmine()->getIniTarefa()."<br/>";        
//        echo "getTarefaRedmine()->getFimTarefa(): ".$servicos->getTarefaRedmine()->getFimTarefa()."<br/>";
//        echo "Descricao Res: ".$servicos->getDescRes()."<br/>";
//        echo "Descricao Comp: ".$servicos->getDescComp()."<br/>";
//        echo "Data Inicio Evento: ".$servicos->getInicioEvento()."<br/>";
//        echo "Data Fim Evento: ".$servicos->getFimEvento()."<br/>";
//        echo "Data Inicio Limite: ".$servicos->getLimiteInicio()."<br/>";
//        echo "Data Fim Limite: ".$servicos->getLimiteFim()."<br/>";
//        echo "Event Ant: ".$servicos->getEventoAnt()."<br/>";
//        echo "Teste: ".$servicos->testeEventoVencido();        
      
//        
//        $servicos->atualizaTarefaRedimine();
//        
//        echo "Evento: ".$servicos->getEvento()."<br/>";
//        echo "getCodSitEvento: ".$servicos->getCodSitEvento()."<br/>";
//        echo "SituacaoEvento: ".$servicos->getSituacaoEvento()."<br/>";
//        echo "Cor Evento: ".$servicos->getCorEvento()."<br/>";
//        echo "CorTextoEvento: ".$servicos->getCorTextoEvento()."<br/>";
//        echo "TarefaRedmine()->getgetNumTarefa(): ".$servicos->getTarefaRedmine()->getNumTarefa()."<br/>";
//        echo "getTarefaRedmine()->getSitTarefa(): ".$servicos->getTarefaRedmine()->getSitTarefa()."<br/>";
//        echo "getTarefaRedmine()->getIniTarefa(: ".$servicos->getTarefaRedmine()->getIniTarefa()."<br/>";        
//        echo "getTarefaRedmine()->getFimTarefa(): ".$servicos->getTarefaRedmine()->getFimTarefa()."<br/>";
//        echo "Descricao Res: ".$servicos->getDescRes()."<br/>";
//        echo "Descricao Comp: ".$servicos->getDescComp()."<br/>";
//        echo "Data Inicio Evento: ".$servicos->getInicioEvento()."<br/>";
//        echo "Data Fim Evento: ".$servicos->getFimEvento()."<br/>";
//        echo "Data Inicio Limite: ".$servicos->getLimiteInicio()."<br/>";
//        echo "Data Fim Limite: ".$servicos->getLimiteFim()."<br/>";
//        echo "Event Ant: ".$servicos->getEventoAnt()."<br/>";
//        echo "Teste: ".$servicos->testeEventoVencido(); 
//        
//        
//        $servicos->atualizaAutomaticoTarefasRedmine();

    ?>
        
    </div>
    </div>
<?php
include ("../class/footer.php");

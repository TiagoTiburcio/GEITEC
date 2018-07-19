<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    if ($usuario->validaSessao('') == 1){
     
    $tarefas = new Tarefas();
    set_time_limit(0);
    //$tarefas->getTelas("http://172.25.76.61/zabbix/map.php?noedit=1&sysmapid=7", "indexPoolBanco.png"); 
    //$tarefas->getTelas("http://172.25.76.61/zabbix/map.php?noedit=1&sysmapid=8", "indexPoolHomologacao.png");
    //$tarefas->getTelas("http://172.25.76.61/zabbix/map.php?noedit=1&sysmapid=6", "indexPoolProducao.png");
    $tarefas->getTelas("http://172.25.76.61/zabbix/map.php?noedit=1&sysmapid=9", "indexSalaCofre.png");
    $tarefas->getTelas("http://10.24.0.59/zabbix/map.php?noedit=1&sysmapid=521", "indexWifi.png");
    $tarefas->getTelas("http://10.24.0.59/zabbix/map.php?noedit=1&sysmapid=523", "indexRep.png");
    $tarefas->getTelas("http://10.24.0.59/zabbix/map.php?noedit=1&sysmapid=522&severity_min=3", "indexRacks.png");
?>
    <div class="col-lg-4">              
        <iframe src="https://www.google.com/maps/d/embed?mid=1NoTEGGHswVsYX0wTFMJK-1OKJAebYGp7&hl=pt-BR" width="100%" height="690"></iframe> 
    </div>   
<!--    <div class="col-lg-4">              
        <img src="../images/temp/indexPoolProducao.png" height="400" width="100%"/>
    </div>
    <div class="col-lg-4">              
        <img src="../images/temp/indexPoolBanco.png" height="400" width="100%"/>
    </div>
    <div class="col-lg-4">              
        <img src="../images/temp/indexPoolHomologacao.png" height="400" width="100%"/>
    </div>-->
    <div class="col-lg-8">              
        <img src="../images/temp/indexSalaCofre.png" height="700" width="100%"/>
    </div>
    <div class="col-lg-4">              
        <img src="../images/temp/indexWifi.png" height="400" width="100%"/>
    </div>
    <div class="col-lg-4">              
        <img src="../images/temp/indexRep.png" height="400" width="100%"/>
    </div>
    <div class="col-lg-4">              
        <img src="../images/temp/indexRacks.png" height="400" width="100%"/>
    </div>
    </div>                      
<?php

include ("../class/footer.php");
    }
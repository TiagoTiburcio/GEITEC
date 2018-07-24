<?php
    include_once '../class/principal.php';
    
    $tarefas = new RotinasPublicas();
    
    if ($tarefas->validaSessao('') == 1){
         
    set_time_limit(0);   
    $tarefas->getTelas("http://172.25.76.61/zabbix/map.php?noedit=1&sysmapid=9&severity_min=4", "indexSalaCofre.png");
    $tarefas->getTelas("http://10.24.0.59/zabbix/map.php?noedit=1&sysmapid=528&severity_min=3", "indexGeralSEED.png");
?>
   <div class="col-lg-6">   
       <img src="../images/temp/indexGeralSEED.png" height="650" width="100%"/></a>    
    </div>
    <div class="col-lg-6">              
        <img src="../images/temp/indexSalaCofre.png" height="650" width="100%"/>
    </div>
    </div>                      
<?php

include ("../class/footer.php");
    }
<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('', '25') == 1) {
    ?>
    <div class="col-xs-12">         
        <div class="col-xs-12">
            <iframe src="servidores_listar_servidores.php" width="100%" height="620px" style="border: 0px;"></iframe> 
        </div>
    </div>
    </div>    
    </div>       
    <?php
    include ("../class/footer.php");
}
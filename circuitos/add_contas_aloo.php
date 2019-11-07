<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('', '28') == 1) {
    $circuitos = new Circuitos();
    
    ?>
    <div class="col-xs-12">

    </div>
<?php
    include("../class/footer.php");
}

<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4', '0') == 1) {
    $filtro_perfil = filter_input(INPUT_GET, 'perfil');
    if ($filtro_perfil == '' || $filtro_perfil == NULL) {
        echo 'ERRO - Sem Perfil no Parametro!!!';
        ;
    } else {
        $perfil = new Perfil();
        $paginas = $perfil->listaPaginas();
        echo '<div class="col-lg-12 centraltd" ><div class="col-lg-3 col-lg-offset-3 esquerdatd fundoCinza">';
        foreach ($paginas as $table_paginas) {
            echo '<input type="checkbox" name="' . $table_paginas['codigo'] . ' " value="' . $table_paginas['codigo'] . '"> - ' . $table_paginas['modulo'] . ' - ' . $table_paginas['pag_desc'] . '<br>';
        }
        echo '</div>  <div class="col-lg-1 " style="height: 300px;"> <button type="submit" class="btn-default" style="font-size: 24px; margin-top: 150px;"><</button><br/> <button type="submit" class="btn-default" style="font-size: 24px;">></button> </div> <div class="col-lg-3 esquerdatd fundoCinza">';
        foreach ($paginas as $table_paginas) {
            echo '<input type="checkbox" name="' . $table_paginas['codigo'] . ' " value="' . $table_paginas['codigo'] . '"> - ' . $table_paginas['modulo'] . ' - ' . $table_paginas['pag_desc'] . '<br>';
        }
        echo '</div></div>';
    }
}

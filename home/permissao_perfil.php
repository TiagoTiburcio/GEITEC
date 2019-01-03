<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4', '0') == 1) {
    if (filter_input(INPUT_GET, 'perfil') != NULL && filter_input(INPUT_GET, 'perfil') != '') {
        $filtro_perfil = filter_input(INPUT_GET, 'perfil');
        echo 'GET <br/>';
    } elseif (filter_input(INPUT_POST, 'perfil') != NULL && filter_input(INPUT_POST, 'perfil') != '') {
        $filtro_perfil = filter_input(INPUT_POST, 'perfil');
        echo 'POST <br/>';
    } else {
        $filtro_perfil = '';
        echo 'SEM PARAMETRO <br/>';
    }
    var_dump($filtro_perfil);
    echo '<br/>';
    if ($filtro_perfil == '') {
        echo 'ERRO - Sem Perfil no Parametro!!!';
        echo '<br/>';
    } else {
        $array_block = array();
        
        if (filter_input(INPUT_POST, 'block') != NULL && filter_input(INPUT_POST, 'block') != '') {
            $array_block[1] = var_dump(filter_input(INPUT_POST, 'block'));
            $array_block[2] = var_dump(filter_input(INPUT_POST, 'block'));
        } else {
            $array_block = "";
        }
        //echo var_dump($array_block).'<br/>';
        $perfil = new Perfil();
        $paginas = $perfil->listaPaginas();
        ?>
        <div class="col-lg-12 centraltd" >

            <table>
                <tr>
                <form name="combo_box" method="get" action="permissao_perfil.php" >
                    <td>
                        <input type="hidden" id="perfil" name="perfil" value="<?php echo $filtro_perfil; ?>"> 
                        <select class="fundoCinza" multiple size="20" name="block" style="width: 100%; " >
                            <?php
                            foreach ($paginas as $table_paginas) {
                                echo '<option value = "' . $table_paginas['pag_cod'] . '" >' . $table_paginas['modulo'] . ' - ' . $table_paginas['pag_desc'] . '</option>';
                            }
                            ?>
                        </select>

                    </td>
                    <td align="center" valign="middle">
                        <button type="submit"> >> a</button>
                    </td>
                </form>
                <form name="combo_box" method="get" action="" >
                    <td align="center" valign="middle">
                        <input type="button" onClick="move(this.form.list1, this.form.list2)" value=">>">                    
                    <td>
                        <select class="fundoCinza" multiple size="20" name="list2" style="width: 100%; " >
                        </select>
                    </td>
                </form>    
                </tr>
            </table>           
        </form>
        </div><?php
    }
}

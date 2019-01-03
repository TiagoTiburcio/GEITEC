<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('', '20') == 1) {
    $perfil = new Perfil();
    if(filter_input(INPUT_GET, 'codigo') == ''){
        $cod_perfil = '0';
    } else {
        $cod_perfil = filter_input(INPUT_GET, 'codigo');
    }
    $cod_perfil = filter_input(INPUT_GET, 'codigo');
    $dadosPerfil = $perfil->testaPerfil($cod_perfil);
    foreach ($dadosPerfil as $table) {
        if ($table['cont'] == 1 ){
            $paginas_permitidas = $perfil->listaPaginasPerfilPermitida($cod_perfil);
            $paginas_bloquadas = $perfil->listaPaginasPerfilBloqueada($cod_perfil);
        }elseif ($table['cont'] == 0 ) {
            $paginas_permitidas = array();
            $paginas_bloquadas = $perfil->listaPaginas();;
        } 
        
        ?>
        <div class="col-xs-12 text-center">
            <h2>Manuten&ccedil;&atilde;o Perfl</h2>
            <h2></h2>
            <form class="form-horizontal" method="post" action="gravaeditperfil.php">
                <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-3">                                  
                        <div class="form-group">
                            <label for="id">Código</label>
                            <input type="text" class="form-control centraltd" readonly="true" id="id" name="id" value="<?php echo $table['codigo']; ?>"> 
                            <label for="descricao">Descricao</label>
                            <input type="text" class="form-control centraltd" id="descricao" name="descricao" value="<?php echo $table['descricao']; ?>"> 
                            <div class="input-group login centraliza">
                                <label for="ativo">Perfil Ativo?</label><br/>
                                <div class="radio-inline">
                                    <label><input type="radio" name="ativo" <?php
        if ($table['ativo'] == 1) {
            echo 'checked=""';
        }
        ?> value="1">Sim</label>
                                </div>
                                <div class="radio-inline">
                                    <label><input type="radio" name="ativo" <?php
                                if ($table['ativo'] == 0) {
                                    echo 'checked=""';
                                }
        ?> value="0">Não</label>
                                </div>                    
                            </div>
                        </div>
                        <div class="form-group">
                            <table>
                                <tr>
                                    <th>
                                        <label for="permitido">Permitido</label> 
                                    </th>
                                    <th></th>
                                    <th>
                                        <label for="bloqueado">Bloqueado</label> 
                                    </th>
                                </tr>
                                <tr>                                    
                                    <td>                                                                            
                                        <select multiple size="20" name="permitidos[]" id="permitido" name="permitido" >
                                            <?php
                                            foreach ($paginas_permitidas as $table_paginas) {
                                                echo '<option value = "' . $table_paginas['pag_cod'] . '" >' . $table_paginas['modulo'] . ' - ' . $table_paginas['pag_desc'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td align="center" valign="middle">
                                        <input class="btn btn-primary" type="button" onClick="move(this.form.bloqueado, this.form.permitido)" value="<<">
                                        <input class="btn btn-primary" type="button" onClick="move(this.form.permitido, this.form.bloqueado)" value=">>">
                                    </td>
                                    <td>

                                        <select multiple size="20" id="bloqueado" name="bloqueado">
                                            <?php
                                            foreach ($paginas_bloquadas as $table_paginas) {
                                                echo '<option value = "' . $table_paginas['pag_cod'] . '" >' . $table_paginas['modulo'] . ' - ' . $table_paginas['pag_desc'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>     
                    </div>
                </div>
                <div class="col-lg-2 col-lg-offset-5">
                    <a type="button" class="btn btn-danger" href="listarperfil.php">Voltar</a>
                    <button class="btn btn-success" type="submit" onClick="selecionatudoselect('permitido')();"> Gravar <span class="glyphicon glyphicon-save"></span></button>
                </div>
            </form>           
        </div>    
        <?php
    }
    include ("../class/footer.php");
}        
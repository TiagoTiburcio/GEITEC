<?php
    include_once '../class/principal.php'; 
    
    $usuario = new Usuario();    
    $servicos = new Servicos();    
    
    $usuario->validaSessao('1'); 
?>
    <div class="col-xs-offset-3 col-xs-6">
        <form class="form-horizontal" method="post" action="../servicos/servico_novo_grava.php">
            <div class="form-group">
              <div class="col-xs-12">                                     
                <div class="form-group">
                    <label for="desc_res">Descri&ccedil;&atilde;o Servi&ccedil;o Resumida</label>
                    <input type="text" class="form-control" id="desc_res" name="desc_res" value="">
                </div>
                <div class="form-group">
                    <label for="desc_comp">Descri&ccedil;&atilde;o Servi&ccedil;o Completa</label>
                    <input type="text" class="form-control" id="desc_comp" name="desc_comp" value="">
                </div>
                <div class="form-group">
                    <label for="repeticao">Repeti&ccedil;&atilde;o Evento</label>
                    <select class="form-control" id="repeticao" name="repeticao">
                        <option value="D" >Di&aacute;rio - D</option>                    
                        <option value="S" >Semanal - S</option>
                        <option value="M" >Mensal - M</option>
                        <option value="T" >Trimestral - T</option>
                    </select>
                </div>
                <div class="text-center col-xs-12">
                    <a type="button" class="btn btn-danger" href="../servicos/servicos.php">voltar <span class="glyphicon glyphicon-backward"></span></a>                    
                  <button type="submit" class="btn btn-success">Salvar <span class="glyphicon glyphicon-floppy-disk"></span></button>                  
                </div>
               </div>
            </div>  
        </form> 
    </div>
    </div>
<?php
include ("../class/footer.php");

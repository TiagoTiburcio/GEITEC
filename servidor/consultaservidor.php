<?php
    include_once '../class/principal.php';
    
    $rotina = new RotinasPublicas();
           
    if($rotina->validaSessao('') == 1 ){    
        $servidores = new Servidores();
        if(!isset($_POST['cpf'])) { $_POST['cpf'] = ''; }
        if(!isset($_POST['nome'])) { $_POST['nome'] = ''; }
        if(!isset($_POST['setor'])) { $_POST['setor'] = ''; }
        if(!isset($_POST['siglasetor'])) { $_POST['siglasetor'] = ''; }
        if(!isset($_POST['ativo'])) { $_POST['ativo'] = '2'; }
        $cpf        = $_POST ["cpf"];
        $nome	= $_POST ["nome"];	
        $setor	= $_POST ["setor"];
        $siglasetor = $_POST ["siglasetor"];
        $zbx = $_POST['ativo'];
        $result = $servidores->listaServidores($cpf, $nome, $setor, $siglasetor);
?>
        <div class="col-xs-2">                        
            <form class="form-horizontal" method="post" action="">
             <div class="form-group">
               <div class="col-xs-10 col-xs-offset-2">                                  
                <div class="form-group">                
                <label for="cpf">CPF</label>
                  <input type="text" class="simple-field-data-mask-selectonfocus form-control" data-mask="000.000.000-00" data-mask-selectonfocus="true" id="cpf" name="cpf" value="<?php echo $cpf;?>">
                </div>
                <div class="form-group">
                  <label for="nome">Nome Servidor</label>
                  <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome;?>">
                </div>
                <div class="form-group">
                  <label for="siglasetor">Sigla Setor</label>
                  <input type="text" class="form-control" id="siglasetor" name="siglasetor" value="<?php echo $siglasetor;?>">
                </div>   
                <div class="form-group">
                  <label for="setor">Setor</label>
                  <input type="text" class="form-control" id="setor" name="setor" value="<?php echo $setor;?>">
                </div>
                <div class="form-group">
                    <label for="ativo">Situação Vinculo</label><br/>
                    <div class="radio">
                        <label><input type="radio" name="ativo" <?php if($zbx == 2){echo 'checked=""';}?> value="2">Todos</label>
                    </div><br/>
                    <div class="radio">
                        <label><input type="radio" name="ativo" <?php if($zbx == 1){echo 'checked=""';}?> value="1">Ativo</label>
                    </div><br/>
                    <div class="radio">
                        <label><input type="radio" name="ativo" <?php if($zbx == 0){echo 'checked=""';}?> value="0">Inativo</label>
                    </div><br/>                    
                </div>
                  <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                  <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
               </div>
             </div>  
            </form>
        </div>
        <div class="col-xs-10">
            <div class="col-xs-12">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                      <tr>
                        <th>Nome Servidor</th>  
                        <th>CPF</th>                                               
                        <th>Setor Sup.</th>
                        <th>Setor Sup.</th>
                        <th>Sigla Setor</th>
                        <th>Nome Setor</th>
                        <th>Tipo Vinculo</th>
                        <th>Cargo</th>
                        <th>Situacao</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while($consulta = pg_fetch_assoc($result))
                        { //print "Saldo: ".$consulta['cdsituacao']; 
                         if(($consulta["ativo"] == $zbx)||($zbx == '2')){   
                    ?>                
                   <tr>
                        <td><?php echo $consulta["nome_servidor"]; ?></td>
                        <td><?php echo $consulta["cpf"]; ?></td>                      
                        <td><?php echo $consulta["nivel_3"]; ?></td>
                        <td><?php echo $consulta["nivel_2"]; ?></td>
                        <td><?php echo $consulta["nivel_1"]; ?></td>
                        <td><?php echo $consulta["nome_setor"]; ?></td>
                        <td><?php echo $consulta["tipo_vinculo"]; ?></td>
                        <td><?php echo $consulta["cargo"]; ?></td>
                        <td><?php echo $consulta["ativo"]; ?></td>
                   </tr>  
                <?php
                         }
                    }
                ?>                                          
                    </tbody>
                </table>
            </div>
           </div>
        </div>
    <script type="text/javascript" src="../js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="../js/qunit-1.11.0.js"></script>
    <script type="text/javascript" src="../js/sinon-1.10.3.js"></script>
    <script type="text/javascript" src="../js/sinon-qunit-1.0.0.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.test.js"></script>
<?php
   
    include ("../class/footer.php");
    }    
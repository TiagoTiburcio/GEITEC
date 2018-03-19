<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
       
    if($usuario->validaSessao('') == 1 ){
    $servidores = new Servidores();
    
    if(!isset($_POST['cpf'])) { $_POST['cpf'] = ''; }
    if(!isset($_POST['nome'])) { $_POST['nome'] = ''; }
    if(!isset($_POST['setor'])) { $_POST['setor'] = ''; }
    if(!isset($_POST['siglasetor'])) { $_POST['siglasetor'] = ''; }
    $cpf        = $_POST ["cpf"];
    $nome	= $_POST ["nome"];	
    $setor	= $_POST ["setor"];
    $siglasetor = $_POST ["siglasetor"];         
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
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $resultado_servidor1 = $servidores->listaServidores($cpf, $nome, $setor, $siglasetor);
                        foreach ($resultado_servidor1 as $table){                        
                    ?>                
                   <tr>
                        <td><?php echo $table["nome_servidor"]; ?></td>
                        <td><?php echo $table["formatcpf"]; ?></td>                      
                        <td><?php echo $table["nivel_3"]; ?></td>
                        <td><?php echo $table["nivel_2"]; ?></td>
                        <td><?php echo $table["nivel_1"]; ?></td>
                        <td><?php echo $table["nome_setor"]; ?></td>
                        <td><?php echo $table["tipo_vinculo"]; ?></td>
                        <td><?php echo $table["cargo"]; ?></td>
                   </tr>  
                <?php
                        }
                ?>                                          
                    </tbody>
                </table>
            </div>
           </div>
        </div>
    <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="js/qunit-1.11.0.js"></script>
    <script type="text/javascript" src="js/sinon-1.10.3.js"></script>
    <script type="text/javascript" src="js/sinon-qunit-1.0.0.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/jquery.mask.test.js"></script>
<?php 
    include ("../class/footer.php");
    }    
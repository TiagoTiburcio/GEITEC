<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();   

    $circuitos = new Circuitos();   
?>
    <div class="col-lg-8 col-lg-offset-2">
        <h1>Upload Arquivos Contas Oi</h1>

        <form action="importcontas_grava.php" method="post" enctype="multipart/form-data">
        <p><input type="file" name="arquivo[]" /></p>
        <p><input type="file" name="arquivo[]" /></p>
        <p><input type="file" name="arquivo[]" /></p>
        <p><input type="file" name="arquivo[]" /></p>
        <p><input type="file" name="arquivo[]" /></p> 
        <p><input type="file" name="arquivo[]" /></p>
        <p><input type="submit" value="Enviar" /></p>
        </form>
    </div>
<?php
include ("../class/footer.php");

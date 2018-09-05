<?php
include ("../class/header.php");
include ("../class/baropc.php");
$cd_erro = filter_input(INPUT_GET, 'erro');
switch ($cd_erro){
    case 1: 
        $menssagem = "Senha Incorreta!!!";
        break;
    case 2:
        $menssagem = "Usuário não cadastrado ou Inativo!!!";
        break;
    case 3:
        $menssagem = "Usuário ou Senha não Informados!!!";
        break;
    case 3:
        $menssagem = "Erro Cadastro Usuário";
        break;
    default :
        $menssagem = "";
        break;
}
?>
<div class="col-xs-12 text-center">
    <form class="form-horizontal" method="post" action="../home/validalogin.php">
        <h3><?php echo $menssagem;?></h3>
        <div class="form-group">
            <div class="col-xs-12 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">                                  
                <div class="input-group login">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" required="true" class="form-control text-center" id="login" name="login" value="" placeholder="login">                
                </div>
                <div class="input-group login">                  
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" required="true" class="form-control text-center" id="pass" name="pass" value="" placeholder="senha">
                </div>                  
                <button type="submit" class="btn btn-success">Acessar <span class="glyphicon glyphicon-ok-sign"></span></button>                  
            </div>
        </div>  
    </form>
</div>    
<?php
include ("../class/footer.php");


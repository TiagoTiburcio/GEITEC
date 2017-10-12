<?php
    include ("../class/header.php");         
?>
        <div class="col-xs-12 text-center">
            <form class="form-horizontal" method="post" action="../home/testalogin.php">
             <div class="form-group">
               <div class="col-xs-4 col-xs-offset-4 col-lg-2 col-lg-offset-5">                                  
                <div class="input-group login">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control text-center" id="login" name="login" value="" placeholder="login">                
                </div>
                <div class="input-group login">                  
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input type="password" class="form-control text-center" id="pass" name="pass" value="" placeholder="senha">
                </div>                  
                  <button type="submit" class="btn btn-success">Acessar <span class="glyphicon glyphicon-ok-sign"></span></button>                  
               </div>
             </div>  
            </form>
        </div>    
<?php
    include ("../class/footer.php");


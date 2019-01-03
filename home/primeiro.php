<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

$perfil = new Perfil();
$paginas = $perfil->listaPaginas();
?>
<html>
    <head>
        <title>Movendo itens de um select para o outro</title>
    </head>
    <body>
        <form action="primeiro.php" name="frmdestino"  method="POST">
            <select name="destino[]" size="5" id="cdestino" multiple="multiple">
                <option value="branco">branco</option>
                <option value="azul">azul</option>
                <option value="preto">preto</option>
                <option value="verde">verde</option>
            </select>

            <script>
                function selecionatudo() {
                    var selecionados = document.getElementById('cdestino');
                    for (i = 0; i <= selecionados.length - 1; i++) {
                        selecionados.options[i].selected = true;
                    }
                }
            </script>
            <input type="submit" value="ok" OnMouseOver="selecionatudo();">
        </form>
        <?php
        if (isset($_POST["destino"])) {
            foreach ($_POST["destino"] as $opcao) {
                echo "destino escolhidos " . $opcao . "<br>";
            }
        }
        ?>
    </body>
</html>
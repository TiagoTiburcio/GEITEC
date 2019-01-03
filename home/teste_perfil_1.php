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
        <form name="combo_box" method="get" action="" >
            <table>
                <tr>
                    <td>
                        <select multiple size="20" name="list1" style="width:250">
                            <?php
                            foreach ($paginas as $table_paginas) {
                                echo '<option value = "'.$table_paginas['pag_cod'].'" >'.$table_paginas['modulo'] . ' - ' . $table_paginas['pag_desc'].'</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td align="center" valign="middle">
                        <input type="button" onClick="move(this.form.list2, this.form.list1)" value="<<">
                        <input type="button" onClick="move(this.form.list1, this.form.list2)" value=">>">
                    </td>
                    <td>
                        <select multiple size="20" name="list2" style="width:250">
                        </select>
                    </td>
                </tr>
            </table>
            <button type="submit" class="" style="font-size: 24px; margin-top: 150px;">Salvar</button>
        </form>
        <script language="JavaScript">
            function move(MenuOrigem, MenuDestino) {
                var arrMenuOrigem = new Array();
                var arrMenuDestino = new Array();
                var arrLookup = new Array();
                var i;
                for (i = 0; i < MenuDestino.options.length; i++) {
                    arrLookup[MenuDestino.options[i].text] = MenuDestino.options[i].value;
                    arrMenuDestino[i] = MenuDestino.options[i].text;
                }
                var fLength = 0;
                var tLength = arrMenuDestino.length;
                for (i = 0; i < MenuOrigem.options.length; i++) {
                    arrLookup[MenuOrigem.options[i].text] = MenuOrigem.options[i].value;
                    if (MenuOrigem.options[i].selected && MenuOrigem.options[i].value != "") {
                        arrMenuDestino[tLength] = MenuOrigem.options[i].text;
                        tLength++;
                    } else {
                        arrMenuOrigem[fLength] = MenuOrigem.options[i].text;
                        fLength++;
                    }
                }
                arrMenuOrigem.sort();
                arrMenuDestino.sort();
                MenuOrigem.length = 0;
                MenuDestino.length = 0;
                var c;
                for (c = 0; c < arrMenuOrigem.length; c++) {
                    var no = new Option();
                    no.value = arrLookup[arrMenuOrigem[c]];
                    no.text = arrMenuOrigem[c];
                    MenuOrigem[c] = no;
                }
                for (c = 0; c < arrMenuDestino.length; c++) {
                    var no = new Option();
                    no.value = arrLookup[arrMenuDestino[c]];
                    no.text = arrMenuDestino[c];
                    MenuDestino[c] = no;
                }
            }
        </script>    
    </body>
</html>
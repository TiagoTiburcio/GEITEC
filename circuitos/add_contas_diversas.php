<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('', '28') == 1) {
    $contas_div = new ImportContasDiversas();
    $fornecedores = $contas_div->listaFornecedor();
    $cd_erro = '0';
    if (!isset($_SESSION['cd_erro'])) {
        $cd_erro = '0';
    } else {
        $cd_erro = $_SESSION['cd_erro'];
    }
    $_SESSION['cd_erro'] = null;
    $erro = array('', 'Data Não Permitida. Motivo: Anterior a 2 anos da data de hoje.', 'Data Não Permitida. Motivo: Posterior a 1 ano da data de hoje', 'Data é inválida', 'Formato da data inválido');
    ?>
    <script type="text/javascript">
        $(document).ready(function() { //inicio o jQuery
            $("select[name='fornecedor']").change(function() {
                var idfornecedor = $(this).val(); //pegando o value do option selecionado
                //alert(idCombo1);//apenas para debugar a variável		
                $.getJSON( //esse método do jQuery, só envia GET
                    '../class/carrega_campo.inc.php', //script server-side que deverá retornar um objeto jSON
                    {
                        idfornecedor: idfornecedor
                    }, //enviando a variável                    
                    function(data) {
                        //alert(data);//apenas para debugar a variável					
                        var option = new Array(); //resetando a variável					
                        resetaCombo('contrato'); //resetando o combo                        
                        $.each(data, function(i, obj) {
                            option[i] = document.createElement('option'); //criando o option
                            $(option[i]).attr({
                                value: obj.id
                            }); //colocando o value no option
                            $(option[i]).append(obj.nome); //colocando o 'label'
                            $("select[name='contrato']").append(option[i]); //jogando um à um os options no próximo combo
                        });
                    });
            });
        });
        /* função pronta para ser reaproveitada, caso queira adicionar mais combos dependentes */
        function resetaCombo(el) {
            $("select[name='" + el + "']").empty(); //retira os elementos antigos
            var option = document.createElement('option');
            $(option).attr({
                value: '0'
            });
            $(option).append('Escolha');
            $("select[name='" + el + "']").append(option);
        }
    </script>
    <div class="col-xs-12">
        <h3> <?php echo $erro[$cd_erro]; ?></h3>
    </div>
    <div class="col-xs-12">
        <form action="add_contas_passo2.php" method="post">
            <div class="form-group col-xs-6">
                <label for="fornecedor">Lista Fornecedores:</label>
                <select class="form-control" id="fornecedor" name="fornecedor" required>
                    <option value="">Escolha</option>
                    <?php
                        foreach ($fornecedores as $table) {
                            echo '<option value="' . $table['codigo'] . '">' . $table['nome'] . '</option>';
                        }
                        ?>
                </select>
            </div>
            <div class="form-group col-xs-6">
                <label for="contrato">Lista Contratos:</label>
                <select class="form-control" id="contrato" name="contrato" required>
                    <option value="">Escolha</option>
                </select>
            </div>
            <div class="col-xs-4"></div>
            <div class="form-group col-xs-4">
                <label for="periodo_ref">Data Anterior</label>
                <input type="text" class="form-control centraltd" id="periodo_ref" name="periodo_ref" required pattern="[0-9]{2}/[0-9]{4}" placeholder="MM/AAAA">
            </div>
            <div class="col-lg-12 centraltd">
                <button type="submit" class="btn btn-success">Proximo <span class="glyphicon glyphicon-forward"></span></button>
            </div>
        </form>
    </div>
<?php
    include("../class/footer.php");
}

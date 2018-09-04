<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4') == 1) {    
    $filtro_diretoria = filter_input(INPUT_GET, 'dre');
    $filtro_situacao = filter_input(INPUT_GET, 'sit');
    if (!isset($filtro_diretoria)) {
        $filtro_diretoria = 'Todas';
    }
    if (!isset($filtro_situacao)) {
        $filtro_situacao = '2';
    }
    $relatorio = new RelatorioCircuitos();
    $dadosDiretoria = $relatorio->listaNomesDiretorias();
    $dadosTipoUnidade = $relatorio->listaNomesTiposUnidadePorDRE($filtro_diretoria);
    $dadosUnidades = $relatorio->listaNomesUnidades($filtro_diretoria);
    $dadosCircuitos = $relatorio->listaCircuitos($filtro_diretoria);
    $dadosPble = $relatorio->listaPble($filtro_diretoria);
    ?>

    <?php
    foreach ($dadosDiretoria as $dirTable) {
        $diretoriaAtual = $dirTable['sigla_dre'];
        foreach ($dadosTipoUnidade as $tipUnTable) {
            $tipoUnAtual = $tipUnTable['desc_localizacao'];
            foreach ($dadosUnidades as $unidTable) {
                $unidadeAtual = $unidTable['desc_unidade'];
                if (($tipUnTable['sigla_dre'] == $dirTable['sigla_dre']) && ($unidTable['desc_localizacao'] == $tipUnTable['desc_localizacao'])) {
                    ?>
                    <table class="table table-striped table-responsive">        
                        <caption><?php echo 'Diretoria: ' . $diretoriaAtual . ' <br/> Tipo Unidade / Nome:  ' . $tipoUnAtual . ' / ' . $unidadeAtual; ?></caption>
                        <thead>
                            <tr>
                                <th>Designação</th>
                                <th>Tipo Circuito</th>
                                <th>IP</th>
                                <th>Velocidade</th>
                                <th>Data Ult. Alt.</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($dadosCircuitos as $circTable) {
                                if ($unidTable['cd_siig_unidade'] == $circTable['cd_siig_unidade']) {
                                    ?>
                                    <tr>
                                        <td><?php echo $circTable['designacao']; ?></td>                   
                                        <td><?php echo $circTable['grupo']; ?></td>                   
                                        <td><?php echo $circTable['ip']; ?></td>                   
                                        <td><?php echo $circTable['velocidade']; ?></td>                   
                                        <td><?php echo $circTable['data']; ?></td>                   
                                        <td><?php echo $rotina->imprimiAtivo($circTable['value']); ?></td>                   
                                    </tr>
                                    <?php
                                }
                            }
                            foreach ($dadosPble as $circTable) {
                                if ($unidTable['cd_siig_unidade'] == $circTable['cd_siig_unidade']) {
                                    ?>
                                    <tr>
                                        <td><?php echo $circTable['designacao']; ?></td>                   
                                        <td><?php echo $circTable['grupo']; ?></td>                   
                                        <td><?php echo $circTable['ip']; ?></td>                   
                                        <td><?php echo $circTable['velocidade']; ?></td>                   
                                        <td><?php echo $circTable['data']; ?></td>                   
                                        <td><?php echo $rotina->imprimiAtivo($circTable['value']); ?></td>                   
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <style>            
                        th {
                            text-align: center;
                        }
                        td{
                            text-align: center;
                        }
                    </style>
                    <?php
                } // fim IF 
            } //fim unidade  
        }//fim tipounidade
    }// fim diretoria 
}//fim valida sessão
<?php

/**
 * Description of Circuitos
 *
 * @author tiagoc
 */
class ImportContasCircuitos extends Database {

    function insertImportContas($_linhas) {
        $consulta_insertImportContas = "INSERT INTO `circuito_arquivo_import` "
                . " (`nome_arquivo`,`num_linha_arquivo`,`site`,`nome_cliente`, "
                . " `finalidade`,`contrato`,`ciclo_faturamento`,`num_fatura`, "
                . " `num_nota_fiscal`,`cod_ddd`,`num_telefone`,`designacao`, "
                . " `valor_a_pagar`,`nome_local`,`tip_logradouro`,`nome_logradouro`, "
                . " `num_imovel`,`nome_bairro`,`cep`,`uf`,`nome_local2`,`tip_logradouro2`, "
                . " `nome_logradouro2`,`num_imovel2`,`nome_bairro2`,`cep2`,`uf2`, "
                . " `prod_telefone`,`velocidade_circuito`,`num_pagina`,`num_linha`, "
                . " `data_servico`,`cod_servico_descricao_servico`,`degrau`,`num_tel_origem`, "
                . " `cod_selecao`,`ddd_tel_destino`,`tel_destino`,`hr_qtd_chamada`, "
                . " `duracao`,`s`,`valor_servico`,`aliquota_icms`,`conta`,`num_detalhe`, "
                . " `cod_l_origem_chamada`,`cod_l_destino_chamada`,`vencimento`,`contestar`, "
                . " `valor_contestar`,`localidade`,`telefone_origem`,`sigla_orgao_analise`) VALUES "
                . implode(', ', $_linhas) . ";";
        $resultado_insertImportContas = mysqli_query($this->connect(), $consulta_insertImportContas);

        return $resultado_insertImportContas;
    }

    function limpaImport() {
        $consulta_limpaImport = " INSERT INTO `circuito_arquivo_import_temp`(`nome_arquivo`,`num_linha_arquivo`,`contrato`,`num_fatura`,`num_nota_fiscal`,`cod_ddd`,`num_telefone`,`designacao`,`tip_logradouro`,`nome_local`,`nome_logradouro`,`num_imovel`,`nome_bairro`,`cep`,`uf`,`prod_telefone`,`velocidade_circuito`,`num_pagina`,`num_linha`,`data_servico`,`cod_servico_descricao_servico`,`valor_servico`,`conta`,`num_detalhe`,`vencimento`) select * from (select a1.nome_arquivo, a1.num_linha_arquivo, concat('18500' , a1.contrato) as contrato, a1.num_fatura, a1.`num_nota_fiscal`, a1.cod_ddd, a1.num_telefone, (CASE a1.designacao_limpa WHEN '' THEN (CASE a1.num_tel_origem WHEN '' THEN (CASE a1.telefone_origem WHEN '' THEN (select REPLACE(num_tel_origem,'000000','') from `circuito_arquivo_import` where nome_arquivo = a1.nome_arquivo and num_linha_arquivo = (a1.num_linha_arquivo - 1)) else (REPLACE(a1.telefone_origem,'-','')) END)else (REPLACE(num_tel_origem,'000000','')) END)else (a1.designacao_limpa) END) as designacao_limpa, a1.tip_logradouro, a1.nome_local, a1.nome_logradouro, a1.num_imovel, SUBSTR( a1.nome_bairro, 5 ) AS nome_bairro, a1.cep, a1.uf, a1.prod_telefone, a1.velocidade_circuito, a1.num_pagina, a1.num_linha, CONCAT(SUBSTR( a1.data_servico, 7, 4 ),'-', SUBSTR( a1.data_servico, 4, 2 ),'-',SUBSTR( a1.data_servico, 1, 2 )) as data_servico,a1.cod_servico_descricao_servico, CASE a1.s WHEN '+' THEN (CAST(replace(a1.valor_servico,',','.') as DECIMAL(9,2)))  WHEN '-' THEN (-CAST(replace(a1.valor_servico,',','.') as DECIMAL(9,2))) END as valor_servico, CONCAT(SUBSTR( a1.conta, 1, 4 ),'-', SUBSTR( a1.conta, 5, 2 ),'-',SUBSTR( a1.conta, 7, 2 )) as conta,  a1.num_detalhe, CONCAT(SUBSTR( a1.vencimento, 7, 4 ),'-', SUBSTR( a1.vencimento, 4, 2 ),'-',SUBSTR( a1.vencimento, 1, 2 )) as vencimento from (SELECT TRIM(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(designacao,'CONTRATO DE CONTA CUS450', 'Encargos '),'  ', ' '),'   ', ' '),'    ', ' '),'   ', ' '),'  ',' '),'-',''), 'AEB AEB' , 'AEB' ), 'AGUR AGUR' , 'AGUR' ), 'AJU AJU' , 'AJU' ), 'TANQUE NOVO' , '' ), 'APF APF' , 'APF' ), 'TATW TATW' , 'TATW' ), 'AQB AQB' , 'AQB' ), 'TBOC TBOC' , 'TBOC' ), 'AUX AUX' , 'AUX' ), 'TQNV TQNV' , 'TQNV' ), 'BEJ BEJ' , 'BEJ' ), 'SSNV SSNV' , 'SSNV' ), 'BQM BQM' , 'BQM' ), 'TAFA TAFA' , 'TAFA' ), 'BQS BQS' , 'BQS' ), 'SREO SREO' , 'SREO' ), 'CAI CAI' , 'CAI' ), 'SRAW SRAW' , 'SRAW' ), 'CBE CBE' , 'CBE' ), 'SMCD SMCD' , 'SMCD' ), 'CDB CDB' , 'CDB' ), 'SMAP SMAP' , 'SMAP' ), 'CEJ CEJ' , 'CEJ' ), 'SITIOS NOVOS' , '' ), 'CFY CFY' , 'CFY' ), 'SERK SERK' , 'SERK' ), 'CHB CHB' , 'CHB' ), 'RPED RPED' , 'RPED' ), 'CPL CPL' , 'CPL' ), 'PRBR PRBR' , 'PRBR' ), 'CSP CSP' , 'CSP' ), 'POXM POXM' , 'POXM' ), 'CYR CYR' , 'CYR' ), 'PIDB PIDB' , 'PIDB' ), 'DNP DNP' , 'DNP' ), 'MUCE MUCE' , 'MUCE' ), 'ETC ETC' , 'ETC' ), 'MTGD MTGD' , 'MTGD' ), 'FVA FVA' , 'FVA' ), 'MCAM MCAM' , 'MCAM' ), 'GAPO GAPO' , 'GAPO' ), 'LGDR LGDR' , 'LGDR' ), 'GCH GCH' , 'GCH' ), 'LDHS LDHS' , 'LDHS' ), 'GRX GRX' , 'GRX' ), 'INT MLD' , 'INT' ), 'GYD GYD' , 'GYD' ), 'ENHO ENHO' , 'ENHO' ), 'IBI IBI' , 'IBI' ), 'IHF IHF' , 'IHF' ), 'IJD IJD' , 'IJD' ), 'ILHV ILHV' , 'ILHV' ), 'IND IND' , 'IND' ), 'INN INN' , 'INN' ), 'INT INT' , 'INT' ), 'JPO JPO' , 'JPO' ), 'JUB JUB' , 'JUB' ), 'LAT LAT' , 'LAT' ), 'LNJ LNJ' , 'LNJ' ), 'MHR MHR' , 'MHR' ), 'MLD MLD' , 'MLD' ), 'MMB MMB' , 'MMB' ), 'MOB MOB' , 'MOB' ), 'MRM MRM' , 'MRM' ), 'MSG MSG' , 'MSG' ), 'MUB MUB' , 'MUB' ), 'NHG NHG' , 'NHG' ), 'NNL NNL' , 'NNL' ), 'NOS NOS' , 'NOS' ), 'NRA NRA' , 'NRA' ), 'NRO NRO' , 'NRO' ), 'NSD NSD' , 'NSD' ), 'PAB PAB' , 'PAB' ), 'PDK PDK' , 'PDK' ), 'PEH PEH' , 'PEH' ), 'PFH PFH' , 'PFH' ), 'PKT PKT' , 'PKT' ), 'POV POV' , 'POV' ), 'PPI PPI' , 'PPI' ), 'PXM PXM' , 'PXM' ), 'PYO PYO' , 'PYO' ), 'RCH RCH' , 'RCH' ), 'REE REE' , 'REE' ), 'RHT RHT' , 'RHT' ), 'RRO RRO' , 'RRO' ), 'SAX SAX' , 'SAX' ), 'SCV SCV' , 'SCV' ), 'SDS SDS' , 'SDS' ), 'SFW SFW' , 'SFW' ), 'SFY SFY' , 'SFY' ), 'SHY SHY' , 'SHY' ), 'SLM SLM' , 'SLM' ), 'SMB SMB' , 'SMB' ), 'SXO SXO' , 'SXO' ), 'SXN SXN' , 'SXN' ), 'SYR SYR' , 'SYR' ), 'TBB TBB' , 'TBB' ), 'TGU TGU' , 'TGU' ), 'TLH TLH' , 'TLH' ), 'UUB UUB' , 'UUB' ), 'ASGG ASGG' , 'ASGG' ), 'MGBI MGBI' , 'MGBI' ), 'PCBS PCBS' , 'PCBS' ), 'TRIO TRIO' , 'TRIO' ), 'FIP FIP' , 'FIP' ), 'AGUA FRIA' , '' ), 'BNSU BNSU' , 'BNSU' ), 'ATALAIA NOVA' , '' ), 'FEIRA NOVA' , '' ), 'ASS QUEIMADA GRANDE' , '' ), 'ALAGADICO' , '' ), 'ALTO DO SANTO ANTONIO' , '' ), 'AMPARO DE SAO FRANCI' , '' ), 'AQUIDABA' , '' ), 'ARACAJU' , '' ), 'ARAUA' , '' ), 'AREIA BRANCA' , '' ), 'ATALAIA DEZA' , '' ), 'BARRA DOS COQUEIROS' , '' ), 'BONSUCESSO' , '' ), 'BOQUIM' , '' ), 'BRAVO URUBU' , '' ), 'BREJAO' , '' ), 'BREJO GRANDE' , '' ), 'BREJO' , '' ), 'CABRITA' , '' ), 'CAMPO DO BRITO' , '' ), 'CANHOBA' , '' ), 'CANINDE DE SAO FRANC' , '' ), 'CAPELA' , '' ), 'CARIRA' , '' ), 'CARMOPOLIS' , '' ), 'CEDRO DE SAO JOAO' , '' ), 'COLONIA MIRANDA' , '' ), 'COLONIA TREZE' , '' ), 'COLONIA' , '' ), 'CRISTINAPOLIS' , '' ), 'CRUZ DAS GRACAS' , '' ), 'CUMBE' , '' ), 'DIVINA PASTORA' , '' ), 'ESCURIAL' , '' ), 'ESPINHEIRO' , '' ), 'ESTANCIA' , '' ), 'FAZENDA DEZA' , '' ), 'FEIRA DEZA' , '' ), 'FREI PAULO' , '' ), 'GARARU' , '' ), 'GENERAL MAYNARD' , '' ), 'GENIPAPO' , '' ), 'GRACHO CARDOSO' , '' ), 'ILHA DAS FLORES' , '' ), 'INDIAROBA' , '' ), 'ITABAIANA' , '' ), 'ITABAIANINHA' , '' ), 'ITABI' , '' ), 'ITAPORANGA DAJUDA' , '' ), 'JAPARATUBA' , '' ), 'JAPOATA' , '' ), 'LADEIRA' , '' ), 'LADEIRINHAS' , '' ), 'LAGARTO' , '' ), 'LAGOA DA VOLTA' , '' ), 'LARANJEIRAS' , '' ), 'MACAMBIRA' , '' ), 'MALHADA DOS BOIS' , '' ), 'MALHADOR' , '' ), 'MANGABEIRAS' , '' ), 'MARUIM' , '' ), 'MATA GRANDE' , '' ), 'MATAPOA' , '' ), 'MIRANDA' , '' ), 'MOCAMBO' , '' ), 'MOITA BONITA' , '' ), 'MONTE ALEGRE DE SERG' , '' ), 'MURIBECA' , '' ), 'MUSSUCA' , '' ), 'NEOPOLIS' , '' ), 'NOSSA SENHORA APAREC' , '' ), 'NOSSA SENHORA DA GLO' , '' ), 'NOSSA SENHORA DAS DO' , '' ), 'NOSSA SENHORA DE LOU' , '' ), 'NOSSA SENHORA DO SOC' , '' ), 'OITEIROS' , '' ), 'PACATUBA' , '' ), 'PAU DE COLHER' , '' ), 'PEDRA BRANCA' , '' ), 'PEDRA MOLE' , '' ), 'PEDRINHAS' , '' ), 'PINDOBA' , '' ), 'PINHAO' , '' ), 'PIRAMBU' , '' ), 'PIRUNGA' , '' ), 'POCO REDONDO' , '' ), 'POCO VERDE' , '' ), 'POCOS DOS BOIS' , '' ), 'PORTO DA FOLHA' , '' ), 'POXIM' , '' ), 'PROPRIA' , '' ), 'RIACHAO DO DANTAS' , '' ), 'RIACHUELO' , '' ), 'RIBEIROPOLIS' , '' ), 'RIO DAS PEDRAS' , '' ), 'ROSARIO DO CATETE' , '' ), 'SALGADO' , '' ), 'SANTA LUZIA DO ITANH' , '' ), 'SANTA ROSA DE LIMA' , '' ), 'SANTA ROSA DO ERMIRI' , '' ), 'SANTANA DO SAO FRANC' , '' ), 'SANTO AMARO DAS BROT' , '' ), 'SACO TORTO' , '' ), 'SAO CRISTOVAO' , '' ), 'SAO DOMINGOS' , '' ), 'SAO FRANCISCO' , '' ), 'SAO JOSE' , '' ), 'SAO MATEUS DA PALEST' , '' ), 'SAO MIGUEL DO ALEIXO' , '' ), 'SERRA DO MACHADO' , '' ), 'SERRAO' , '' ), 'SIMAO DIAS' , '' ), 'SIRIRI' , '' ), 'SITIOS DEZOS' , '' ), 'TAICOCA DE FORA' , '' ), 'TANQUE DEZO' , '' ), 'TATU' , '' ), 'TELHA' , '' ), 'TOBIAS BARRETO' , '' ), 'TOMAR DO GERU' , '' ), 'TRIUNFO' , '' ), 'UMBAUBA' , '' ), 'TIPO DE LINHA' , '' ), ' 800' , '' )) AS designacao_limpa , ai.* FROM `circuito_arquivo_import` as ai) AS a1 left join circuito_arquivo_import_temp as i on a1.nome_arquivo = i.nome_arquivo and a1.num_linha_arquivo = i.num_linha_arquivo where i.num_linha_arquivo is null) as c1 ; ";
        $resultado_limpaImport = mysqli_query($this->connect(), $consulta_limpaImport);
        $consulta_limpaImport1 = " select distinct nome_arquivo from circuito_arquivo_import_temp;  ";
        $resultado_limpaImport1 = mysqli_query($this->connect(), $consulta_limpaImport1);
        foreach ($resultado_limpaImport1 as $table1) {
            $this->corrigeArquivo($table1['nome_arquivo']);
        }
        return $resultado_limpaImport;
    }

    function corrigeArquivo($_arquivo) {
        $consulta_corrigeArquivo = " UPDATE `circuito_arquivo_import_temp` AS t1 JOIN `circuitos_correcao_import` AS t2 ON t1.`contrato` = t2.`contrato` and t1.`designacao` = t2.`designacao_antes` SET t1.`designacao` = t2.`designacao_depois` where t1.nome_arquivo = '$_arquivo' and t1.num_linha_arquivo > 0; ";
        $resultado_corrigeArquivo = mysqli_query($this->connect(), $consulta_corrigeArquivo);
        return $resultado_corrigeArquivo;
    }

    function excluiImport($_arquivo) {
        $consulta_excluiImport = " delete FROM circuito_arquivo_import where nome_arquivo = '$_arquivo' and num_linha_arquivo > '0'; ";
        $resultado_excluiImport = mysqli_query($this->connect(), $consulta_excluiImport);

        $consulta_excluiImport2 = " delete FROM circuito_arquivo_import_temp where nome_arquivo = '$_arquivo' and num_linha_arquivo > '0'; ";
        $resultado_excluiImport2 = mysqli_query($this->connect(), $consulta_excluiImport2);
        return $resultado_excluiImport . $resultado_excluiImport2;
    }

    function excluiDadosContas($_contrato, $_conta) {
        $consulta_excluiDadosContas = " delete FROM circuitos_contas where fatura = '$_contrato' and periodo_ref = '$_conta' ";
        $resultado_excluiDadosContas = mysqli_query($this->connect(), $consulta_excluiDadosContas);
        return $resultado_excluiDadosContas;
    }

    function listaProblemaImport() {
        $consulta_listaProblemaImport = "SELECT ai.* , date_format(ai.conta, '%m/%Y') as conta, date_format(ai.vencimento, '%d/%m') as vencimento FROM circuito_arquivo_import_temp as ai left join circuitos_registro_consumo as rc on rc.codigo = ai.designacao where rc.codigo is null;";
        $resultado_listaProblemaImport = mysqli_query($this->connect(), $consulta_listaProblemaImport);
        return $resultado_listaProblemaImport;
    }

    function listaContasImport() {
        $consulta_listaContasImport = " SELECT ai.nome_arquivo , ai.contrato, date_format(ai.conta, '%m/%Y') as conta, c.periodo_ref, (case when c.periodo_ref is null then  CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(SUM(ai.valor_servico), 2),'.',';'),',','.'),';',',')) ELSE ''  END) as valor_total  FROM circuito_arquivo_import_temp as ai left join circuitos_contas as c on c.fatura = ai.contrato and c.periodo_ref = ai.conta group by ai.contrato,ai.conta, c.periodo_ref; ";
        $resultado_listaContasImport = mysqli_query($this->connect(), $consulta_listaContasImport);
        return $resultado_listaContasImport;
    }

    function insertContasImport($_nom_arquivo) {
        $consulta_insertContasImport = "  INSERT INTO `circuitos_contas` (`designacao`, `periodo_ref`, `fatura`,`valor_conta`, `nome_arquivo`,`num_linha_arquivo`,`vencimento` ) select designacao,conta,contrato,sum(valor_servico) as valor_conta,nome_arquivo, num_linha_arquivo,vencimento from circuito_arquivo_import_temp where `nome_arquivo` = '$_nom_arquivo'  group by designacao,conta,contrato; ";
        $resultado_insertContasImport = mysqli_query($this->connect(), $consulta_insertContasImport);
        return $resultado_insertContasImport;
    }

    function editRegistroConsumo($_nom_arquivo) {
        $consulta_editRegistroConsumo = " update `circuitos_registro_consumo` as t1 join `circuito_arquivo_import_temp` as t2  on t2.`designacao` = t1.`codigo` set t1.`velocidade` = t2.`velocidade_circuito`, t1.`tipo_servico` = t2.`prod_telefone`, t1.`tip_logradouro` = t2.`tip_logradouro`, t1.`nome_logradouro` = t2.`nome_logradouro`, t1.`nome_cidade` = t2.`nome_local`, t1.`num_imovel` = t2.`num_imovel`, t1.`nome_bairro` = t2.`nome_bairro`, t1.`data_ult_ref` = t2.`conta` where t2.`nome_arquivo` = '$_nom_arquivo'; ";
        $resultado_editRegistroConsumo = mysqli_query($this->connect(), $consulta_editRegistroConsumo);
        return $resultado_editRegistroConsumo;
    }

    function testeImport($_nom_arquivo) {
        $resultado_analitico2 = $this->listaProblemaImport();
        $resultado_listaProblemaImport = $this->listaContasImport();
        foreach ($resultado_listaProblemaImport as $table1) {
            $aviso = '';
            foreach ($resultado_analitico2 as $table) {
                if (($table["contrato"] == $table1["contrato"]) && ($table1['nome_arquivo'] == $_nom_arquivo)) {
                    $aviso = '1';
                }
            }
            if (($table1["periodo_ref"] == '') && ($table1['nome_arquivo'] == $_nom_arquivo)) {
                $aviso = '' . $aviso;
            } else {
                $aviso = '2' . $aviso;
            }
            if ($aviso == '') {
                return '1';
            } else {
                return '0';
            }
        }
    }

    // editLinhaArquivo
    function editLinhaArquivo($_arquivo, $_num_linha, $_designacao) {
        $consulta_editLinhaArquivo0 = " select i.designacao , count(i.designacao) as cont from circuito_arquivo_import_temp as i  where  i.nome_arquivo = '$_arquivo' and i.num_linha_arquivo = '$_num_linha';";
        $resultado_editLinhaArquivo0 = mysqli_query($this->connect(), $consulta_editLinhaArquivo0);
        foreach ($resultado_editLinhaArquivo0 as $cont) {
            $teste = $cont['cont'];
            $designacao_antes = $cont['designacao'];
        }
        if ($teste > 0) {
            $resultado_editLinhaArquivo1 = $this->editLinhaArquivoFrag1($_designacao, $_arquivo, $_num_linha);
            foreach ($resultado_editLinhaArquivo1 as $valida) {
                $v1 = $valida['cont'];
                $contrato = $valida['contrato'];
            }
            $this->editLinhaArquivoFrag2($v1, $contrato, $designacao_antes, $_designacao, $_arquivo, $_num_linha);
        }
    }

    private function editLinhaArquivoFrag2($v1, $contrato, $designacao_antes, $_designacao, $_arquivo, $_num_linha) {
        if ($v1 > 0) {
            $consulta_editLinhaArquivo3 = " INSERT INTO `circuitos_correcao_import`(`contrato`,`designacao_antes`,`designacao_depois`)VALUES('$contrato','$designacao_antes','$_designacao'); ";
            $resultado_editLinhaArquivo3 = mysqli_query($this->connect(), $consulta_editLinhaArquivo3);
            return $resultado_editLinhaArquivo3;
        } else {
            $consulta_editLinhaArquivo3 = " UPDATE `circuito_arquivo_import_temp` SET `designacao` = '$designacao_antes' WHERE `nome_arquivo` = '$_arquivo' AND `num_linha_arquivo` = '$_num_linha'; ";
            $resultado_editLinhaArquivo3 = mysqli_query($this->connect(), $consulta_editLinhaArquivo3);
            return $resultado_editLinhaArquivo3;
        }
    }

    private function editLinhaArquivoFrag1($_designacao, $_arquivo, $_num_linha) {
        $consulta_editLinhaArquivo1 = " UPDATE `circuito_arquivo_import_temp` SET `designacao` = '$_designacao' WHERE `nome_arquivo` = '$_arquivo' AND `num_linha_arquivo` = '$_num_linha'; ";
        $resultado_editLinhaArquivo1 = mysqli_query($this->connect(), $consulta_editLinhaArquivo1);
        $consulta_editLinhaArquivo2 = " select count(rc.codigo) as cont, i.contrato from circuito_arquivo_import_temp as i join circuitos_registro_consumo as rc on rc.codigo = i.designacao where i.designacao = '$_designacao' and i.nome_arquivo = '$_arquivo' and i.num_linha_arquivo = '$_num_linha'; ";
        $resultado_editLinhaArquivo2 = mysqli_query($this->connect(), $consulta_editLinhaArquivo2);
        return $resultado_editLinhaArquivo2;
    }

}

class RelatorioCircuitos extends Database {

    function dadosContasUltAno($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " cu.descricao = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "  ";
        }
        $consulta = "SELECT rc.codigo as 'designacao', rc.localizacao, cl.descricao AS 'desc_localizacao', rc.data_ativacao, rc.velocidade, rc.tipo_servico, rc.tip_logradouro, rc.nome_logradouro, rc.nome_cidade, rc.num_imovel, rc.nome_bairro, rc.data_ult_ref, cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM circuitos_registro_consumo AS rc JOIN circuitos_localizacao AS cl ON cl.codigo = rc.localizacao JOIN circuitos_unidades AS cu ON cu.codigo_ut_siig = rc.codigo_unidade LEFT JOIN circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai WHERE rc.data_ult_ref > date_sub(now(), interval 1 year) and cu.codigo_unidade_pai = '72' group by rc.codigo;";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaPble($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE c1.sigla_dre = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "  ";
        }
        $consulta = " SELECT c1.cd_siig_dre, c1.cd_siig_unidade, c2.name as designacao, c2.grupo, c1.cod_localizacao, c1.desc_localizacao, c2.ip, c2.situacao, c2.value, DATE_FORMAT(c2.data, '%d/%m/%Y') AS data, ' - ' as velocidade FROM (SELECT DISTINCTROW u.codigo_siig as cd_siig_unidade, u.codigo_inep, u.descricao, d.descricao descricao_dre, d.sigla AS sigla_dre, d.codigo_siig AS cd_siig_dre, i1c1.localizacao AS 'cod_localizacao', i1c1.descricao AS 'desc_localizacao', e.descricao AS cidade FROM sis_geitec.circuitos_unidades AS u INNER JOIN sis_geitec.circuitos_unidades AS d ON u.codigo_unidade_pai = d.codigo_siig INNER JOIN sis_geitec.EscolasSiteCompleta AS e ON e.codigo_mec = u.codigo_inep INNER JOIN (SELECT cu.codigo_siig, crc.localizacao, cl.descricao FROM sis_geitec.circuitos_unidades AS cu JOIN sis_geitec.circuitos_registro_consumo AS crc ON cu.codigo_ut_siig = crc.codigo_unidade JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = crc.localizacao GROUP BY codigo_siig) AS i1c1 ON u.codigo_siig = i1c1.codigo_siig ORDER BY d.sigla , e.descricao , u.descricao) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.codigo_inep = c2.inep $text ; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaNomesDiretorias() {
        $consulta = " SELECT c1.cd_siig_dre, c1.sigla_dre, count(c1.sigla_dre) as qtd_circuito_dre FROM (SELECT cc.designacao, cc.fatura, cfat.descricao_servico AS 'desc_servico_fatura', cc.periodo_ref, cc.valor_conta, rc.localizacao, cl.descricao AS 'desc_localizacao', rc.data_ativacao, rc.velocidade, rc.tipo_servico, rc.tip_logradouro, rc.nome_logradouro, rc.nome_cidade, rc.num_imovel, rc.nome_bairro, rc.data_ult_ref, cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM sis_geitec.circuitos_contas AS cc JOIN sis_geitec.circuitos_contrato AS cfat ON cc.fatura = cfat.codigo JOIN sis_geitec.circuitos_registro_consumo AS rc ON rc.codigo = cc.designacao JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = rc.localizacao JOIN sis_geitec.circuitos_unidades AS cu ON cu.codigo_ut_siig = rc.codigo_unidade LEFT JOIN sis_geitec.circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai WHERE periodo_ref = (SELECT DISTINCTROW periodo_ref FROM sis_geitec.circuitos_contas ORDER BY periodo_ref DESC LIMIT 1)) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28' , '29', '30', '31', '32', '33', '392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.designacao = c2.name GROUP BY c1.sigla_dre; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaNomesUnidades($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE dre.sigla = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "";
        }
        $consulta = " SELECT    cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, ctu.descricao AS 'desc_tipo_unidade', cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM sis_geitec.circuitos_unidades as cu JOIN sis_geitec.circuito_tipo_unidade AS ctu ON ctu.codigo = cu.codigo_tipo_categoria_unidade LEFT JOIN sis_geitec.circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai $text ;";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaNomesTiposUnid($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE c1.sigla_dre = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "";
        }
        $consulta = " SELECT c1.cod_localizacao, c1.desc_localizacao, count(c1.cod_localizacao) as qtd_circuitos FROM (SELECT cc.designacao, cc.fatura, cfat.descricao_servico AS 'desc_servico_fatura', cc.periodo_ref, cc.valor_conta, rc.localizacao AS 'cod_localizacao', cl.descricao AS 'desc_localizacao', rc.data_ativacao, rc.velocidade, rc.tipo_servico, rc.tip_logradouro, rc.nome_logradouro, rc.nome_cidade, rc.num_imovel, rc.nome_bairro, rc.data_ult_ref, cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, ctu.descricao AS 'desc_tipo_unidade', cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM sis_geitec.circuitos_contas AS cc JOIN sis_geitec.circuitos_contrato AS cfat ON cc.fatura = cfat.codigo JOIN sis_geitec.circuitos_registro_consumo AS rc ON rc.codigo = cc.designacao JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = rc.localizacao JOIN sis_geitec.circuitos_unidades AS cu ON cu.codigo_ut_siig = rc.codigo_unidade JOIN sis_geitec.circuito_tipo_unidade AS ctu ON ctu.codigo = cu.codigo_tipo_categoria_unidade LEFT JOIN sis_geitec.circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai WHERE periodo_ref = (SELECT DISTINCTROW periodo_ref FROM sis_geitec.circuitos_contas ORDER BY periodo_ref DESC LIMIT 1)) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28' , '29', '30', '31', '32', '33', '392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.designacao = c2.name $text GROUP BY c1.cod_localizacao; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaNomesTiposUnidadePorDRE($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE c1.sigla_dre = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "";
        }
        $consulta = " SELECT c1.cd_siig_dre, c1.sigla_dre, c1.cod_localizacao, c1.desc_localizacao, COUNT(c1.cod_localizacao) AS qtd_circuitos FROM (SELECT cc.designacao, cc.fatura, cfat.descricao_servico AS 'desc_servico_fatura', cc.periodo_ref, cc.valor_conta, rc.localizacao AS 'cod_localizacao', cl.descricao AS 'desc_localizacao', rc.data_ativacao, rc.velocidade, rc.tipo_servico, rc.tip_logradouro, rc.nome_logradouro, rc.nome_cidade, rc.num_imovel, rc.nome_bairro, rc.data_ult_ref, cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, ctu.descricao AS 'desc_tipo_unidade', cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM sis_geitec.circuitos_contas AS cc JOIN sis_geitec.circuitos_contrato AS cfat ON cc.fatura = cfat.codigo JOIN sis_geitec.circuitos_registro_consumo AS rc ON rc.codigo = cc.designacao JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = rc.localizacao JOIN sis_geitec.circuitos_unidades AS cu ON cu.codigo_ut_siig = rc.codigo_unidade JOIN sis_geitec.circuito_tipo_unidade AS ctu ON ctu.codigo = cu.codigo_tipo_categoria_unidade LEFT JOIN sis_geitec.circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai WHERE periodo_ref = (SELECT DISTINCTROW periodo_ref FROM sis_geitec.circuitos_contas ORDER BY periodo_ref DESC LIMIT 1)) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28' , '29', '30', '31', '32', '33', '392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.designacao = c2.name $text GROUP BY c1.sigla_dre , c1.cod_localizacao; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaQtdCircuitosUpDownContasPorDRE() {
        $consulta = "SELECT c1.cd_siig_dre, c1.sigla_dre, c2.situacao, count(c2.situacao) as qtd_circ_dir_sit FROM (SELECT cc.designacao, cc.fatura, cfat.descricao_servico AS 'desc_servico_fatura', cc.periodo_ref, cc.valor_conta, rc.localizacao, cl.descricao AS 'desc_localizacao', rc.data_ativacao, rc.velocidade, rc.tipo_servico, rc.tip_logradouro, rc.nome_logradouro, rc.nome_cidade, rc.num_imovel, rc.nome_bairro, rc.data_ult_ref, cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM sis_geitec.circuitos_contas AS cc JOIN sis_geitec.circuitos_contrato AS cfat ON cc.fatura = cfat.codigo JOIN sis_geitec.circuitos_registro_consumo AS rc ON rc.codigo = cc.designacao JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = rc.localizacao JOIN sis_geitec.circuitos_unidades AS cu ON cu.codigo_ut_siig = rc.codigo_unidade LEFT JOIN sis_geitec.circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai WHERE periodo_ref = (SELECT DISTINCTROW periodo_ref FROM sis_geitec.circuitos_contas ORDER BY periodo_ref DESC LIMIT 1)) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28' , '29', '30', '31', '32', '33', '392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.designacao = c2.name group by c1.sigla_dre,c2.situacao;";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaQtdPbleUpDownContasPorDRE() {
        $consulta = "select c1.codigo_siig_dre, c1.sigla_dre, c2.situacao, count(c2.situacao) as qtd_circ_dir_sit from ( SELECT distinctrow u.codigo_inep, u.descricao, d.descricao descricao_dre,d.sigla as sigla_dre, d.codigo_siig as codigo_siig_dre, e.descricao as cidade FROM sis_geitec.circuitos_unidades as u inner join sis_geitec.circuitos_unidades as d on u.codigo_unidade_pai = d.codigo_siig inner join sis_geitec.EscolasSiteCompleta as e on e.codigo_mec = u.codigo_inep order by d.sigla, e.descricao, u.descricao) as c1 join (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.codigo_inep = c2.inep group by c1.sigla_dre, c2.situacao ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaPbleUnidades($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE c1.sigla_dre = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "";
        }
        $consulta = " SELECT c1.cod_siig_unidade, c1.desc_unidade, c2.situacao, COUNT(c2.situacao) AS qtd_circ_dir_sit FROM (SELECT DISTINCTROW u.codigo_siig as 'cod_siig_unidade', u.codigo_inep, u.descricao as 'desc_unidade', d.descricao descricao_dre, d.sigla AS sigla_dre, d.codigo_siig AS codigo_siig_dre, i1c1.localizacao AS 'cod_localizacao', i1c1.descricao AS 'desc_localizacao', e.descricao AS cidade FROM sis_geitec.circuitos_unidades AS u INNER JOIN sis_geitec.circuitos_unidades AS d ON u.codigo_unidade_pai = d.codigo_siig INNER JOIN sis_geitec.EscolasSiteCompleta AS e ON e.codigo_mec = u.codigo_inep INNER JOIN (SELECT cu.codigo_siig, crc.localizacao, cl.descricao FROM sis_geitec.circuitos_unidades AS cu JOIN sis_geitec.circuitos_registro_consumo AS crc ON cu.codigo_ut_siig = crc.codigo_unidade JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = crc.localizacao GROUP BY codigo_siig) AS i1c1 ON u.codigo_siig = i1c1.codigo_siig ORDER BY d.sigla , e.descricao , u.descricao) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.codigo_inep = c2.inep $text GROUP BY c1.desc_unidade , c2.situacao; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaCircUnidades($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE c1.sigla_dre = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "";
        }
        $consulta = " SELECT c1.cd_siig_unidade, c1.desc_unidade, c2.situacao, COUNT(c2.situacao) AS qtd_circ_dir_sit FROM (SELECT cc.designacao, cc.fatura, cfat.descricao_servico AS 'desc_servico_fatura', cc.periodo_ref, cc.valor_conta, rc.localizacao AS 'cod_localizacao', cl.descricao AS 'desc_localizacao', rc.data_ativacao, rc.velocidade, rc.tipo_servico, rc.tip_logradouro, rc.nome_logradouro, rc.nome_cidade, rc.num_imovel, rc.nome_bairro, rc.data_ult_ref, cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, ctu.descricao AS 'desc_tipo_unidade', cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM sis_geitec.circuitos_contas AS cc JOIN sis_geitec.circuitos_contrato AS cfat ON cc.fatura = cfat.codigo JOIN sis_geitec.circuitos_registro_consumo AS rc ON rc.codigo = cc.designacao JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = rc.localizacao JOIN sis_geitec.circuitos_unidades AS cu ON cu.codigo_ut_siig = rc.codigo_unidade JOIN sis_geitec.circuito_tipo_unidade AS ctu ON ctu.codigo = cu.codigo_tipo_categoria_unidade LEFT JOIN sis_geitec.circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai WHERE periodo_ref = (SELECT DISTINCTROW periodo_ref FROM sis_geitec.circuitos_contas ORDER BY periodo_ref DESC LIMIT 1)) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28' , '29', '30', '31', '32', '33', '392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.designacao = c2.name $text GROUP BY c1.desc_unidade , c2.situacao; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaPbleTipoUnid($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE c1.sigla_dre = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "";
        }
        $consulta = " SELECT c1.cod_localizacao, c1.desc_localizacao, c2.situacao, COUNT(c2.situacao) AS qtd_circ_dir_sit FROM (SELECT DISTINCTROW u.codigo_inep, u.descricao, d.descricao descricao_dre, d.sigla AS sigla_dre, d.codigo_siig AS codigo_siig_dre, i1c1.localizacao AS 'cod_localizacao', i1c1.descricao AS 'desc_localizacao', e.descricao AS cidade FROM sis_geitec.circuitos_unidades AS u INNER JOIN sis_geitec.circuitos_unidades AS d ON u.codigo_unidade_pai = d.codigo_siig INNER JOIN sis_geitec.EscolasSiteCompleta AS e ON e.codigo_mec = u.codigo_inep INNER JOIN (SELECT cu.codigo_siig, crc.localizacao, cl.descricao FROM sis_geitec.circuitos_unidades AS cu JOIN sis_geitec.circuitos_registro_consumo AS crc ON cu.codigo_ut_siig = crc.codigo_unidade JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = crc.localizacao GROUP BY codigo_siig) AS i1c1 ON u.codigo_siig = i1c1.codigo_siig ORDER BY d.sigla , e.descricao , u.descricao) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.codigo_inep = c2.inep $text GROUP BY c1.desc_localizacao , c2.situacao; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaCircTipoUnid($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE c1.sigla_dre = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "";
        }
        $consulta = " SELECT c1.cod_localizacao, c1.desc_localizacao, c2.situacao, COUNT(c2.situacao) AS qtd_circ_dir_sit FROM (SELECT cc.designacao, cc.fatura, cfat.descricao_servico AS 'desc_servico_fatura', cc.periodo_ref, cc.valor_conta, rc.localizacao AS 'cod_localizacao', cl.descricao AS 'desc_localizacao', rc.data_ativacao, rc.velocidade, rc.tipo_servico, rc.tip_logradouro, rc.nome_logradouro, rc.nome_cidade, rc.num_imovel, rc.nome_bairro, rc.data_ult_ref, cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, ctu.descricao AS 'desc_tipo_unidade', cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM sis_geitec.circuitos_contas AS cc JOIN sis_geitec.circuitos_contrato AS cfat ON cc.fatura = cfat.codigo JOIN sis_geitec.circuitos_registro_consumo AS rc ON rc.codigo = cc.designacao JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = rc.localizacao JOIN sis_geitec.circuitos_unidades AS cu ON cu.codigo_ut_siig = rc.codigo_unidade JOIN sis_geitec.circuito_tipo_unidade AS ctu ON ctu.codigo = cu.codigo_tipo_categoria_unidade LEFT JOIN sis_geitec.circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai WHERE periodo_ref = (SELECT DISTINCTROW periodo_ref FROM sis_geitec.circuitos_contas ORDER BY periodo_ref DESC LIMIT 1)) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28' , '29', '30', '31', '32', '33', '392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.designacao = c2.name $text GROUP BY c1.desc_localizacao , c2.situacao; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaCircuitos($_filtro_diretoria) {
        if ($_filtro_diretoria != 'Todas') {
            $text = " WHERE c1.sigla_dre = '" . $_filtro_diretoria . "' ";
        } else {
            $text = "";
        }
        $consulta = " SELECT c1.cd_siig_dre, c1.cd_siig_unidade, c1.designacao, c2.grupo, c1.cod_localizacao, c1.desc_localizacao, c2.ip, c2.situacao, c2.value, c2.groupid, DATE_FORMAT(c1.data_ult_ref, '%m/%Y') as ult_ref, DATE_FORMAT(c2.data, '%d/%m/%Y') AS data, c1.velocidade  FROM (SELECT rc.codigo as 'designacao', rc.localizacao AS 'cod_localizacao', cl.descricao AS 'desc_localizacao', rc.data_ativacao, rc.velocidade, rc.tipo_servico, rc.tip_logradouro, rc.nome_logradouro, rc.nome_cidade, rc.num_imovel, rc.nome_bairro, rc.data_ult_ref, cu.codigo_siig AS 'cd_siig_unidade', cu.codigo_inep, cu.descricao AS 'desc_unidade', cu.sigla AS 'sigla_unidade', cu.codigo_tipo_categoria_unidade, ctu.descricao AS 'desc_tipo_unidade', cu.zona_localizacao_unidade, cu.cidade AS 'cidade_unidade', cu.ativo AS 'ativo_unidade', dre.codigo_siig AS 'cd_siig_dre', dre.descricao AS 'desc_dre', dre.sigla AS 'sigla_dre', dre.codigo_tipo_categoria_unidade AS 'cd_tipo_categoria_dre', dre.cidade AS 'cidade_dre', dre.ativo AS 'ativo_dre' FROM  sis_geitec.circuitos_registro_consumo AS rc JOIN sis_geitec.circuitos_localizacao AS cl ON cl.codigo = rc.localizacao JOIN sis_geitec.circuitos_unidades AS cu ON cu.codigo_ut_siig = rc.codigo_unidade JOIN sis_geitec.circuito_tipo_unidade AS ctu ON ctu.codigo = cu.codigo_tipo_categoria_unidade LEFT JOIN sis_geitec.circuitos_unidades AS dre ON dre.codigo_siig = cu.codigo_unidade_pai WHERE rc.data_ult_ref > date_sub(now(), interval 1 year) ) AS c1 JOIN (SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, g.groupid, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28' , '29', '30', '31', '32', '33', '394',  '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1') AS c2 ON c1.designacao = c2.name $text ; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

}

/**
 * Description of Circuitos
 *
 * @author tiagoc
 */
class Circuitos extends Database {

    //import Contas
    function insertImportContas($_linhas) {
        $importContas = new ImportContasCircuitos();
        return $importContas->insertImportContas($_linhas);
    }

    //import Contas
    function limpaImport() {
        $importContas = new ImportContasCircuitos();
        return $importContas->limpaImport();
    }

    //import Contas
    function corrigeArquivo($_arquivo) {
        $importContas = new ImportContasCircuitos();
        return $importContas->corrigeArquivo($_arquivo);
    }

    //import Contas
    function excluiImport($_arquivo) {
        $importContas = new ImportContasCircuitos();
        return $importContas->excluiImport($_arquivo);
    }

    //import Contas
    function excluiDadosContas($_contrato, $_conta) {
        $importContas = new ImportContasCircuitos();
        return $importContas->excluiDadosContas($_contrato, $_conta);
    }

    //import Contas
    function listaProblemaImport() {
        $importContas = new ImportContasCircuitos();
        return $importContas->listaProblemaImport();
    }

    //import Contas
    function listaContasImport() {
        $importContas = new ImportContasCircuitos();
        return $importContas->listaContasImport();
    }

    //import Contas
    function insertContasImport($_nom_arquivo) {
        $importContas = new ImportContasCircuitos();
        return $importContas->insertContasImport($_nom_arquivo);
    }

    //import Contas
    function editRegistroConsumo($_nom_arquivo) {
        $importContas = new ImportContasCircuitos();
        return $importContas->editRegistroConsumo($_nom_arquivo);
    }

    //import Contas    
    function testeImport($_nom_arquivo) {
        $importContas = new ImportContasCircuitos();
        return $importContas->testeImport($_nom_arquivo);
    }

    function editLinhaArquivo($_arquivo, $_num_linha, $_designacao) {
        $importContas = new ImportContasCircuitos();
        return $importContas->editLinhaArquivo($_arquivo, $_num_linha, $_designacao);
    }

    // retorna lista com todos os usuarios cadastrados
    function listaUnidades($_dre, $_unidade, $_cidade) {
        $consulta_listaUnidades = " SELECT DISTINCTROW u.codigo_inep, u.descricao, d.descricao descricao_dre, d.sigla AS sigla_dre, d.codigo_siig AS codigo_siig_dre, e.descricao AS cidade FROM circuitos_unidades AS u INNER JOIN circuitos_unidades AS d ON u.codigo_unidade_pai = d.codigo_siig INNER JOIN EscolasSiteCompleta AS e ON e.codigo_mec = u.codigo_inep where d.sigla like '%$_dre%' and u.descricao like '%$_unidade%' and e.descricao like '%$_cidade%' ORDER BY d.sigla , e.descricao , u.descricao; ";
        $resultado_listaUnidades = mysqli_query($this->connect(), $consulta_listaUnidades);
        return $resultado_listaUnidades;
    }

    // retorna lista com todos os usuarios cadastrados
    function listaLinhaArquivo($_arquivo, $_num_linha) {
        $consulta_listaLinhaArquivo = "SELECT * FROM circuito_arquivo_import_temp where nome_arquivo = '$_arquivo' and num_linha_arquivo = '$_num_linha'; ";
        $resultado_listaLinhaArquivo = mysqli_query($this->connect(), $consulta_listaLinhaArquivo);
        return $resultado_listaLinhaArquivo;
    }

    // retorna lista com todos os usuarios cadastrados
    function listaUnidadesCadastradas() {
        $consulta_listaUnidadesCadastradas = "SELECT u_sup.sigla as dre, u.descricao as nome, u.codigo_ut_siig as codigo, u.cidade "
                . " FROM circuitos_unidades as u left join circuitos_unidades as u_sup on u.codigo_unidade_pai = u_sup.codigo_siig where u.ativo = '1' order by u_sup.sigla, u.cidade, u.descricao;";
        $resultado_listaUnidadesCadastradas = mysqli_query($this->connect(), $consulta_listaUnidadesCadastradas);
        return $resultado_listaUnidadesCadastradas;
    }

// retorna lista com todos os usuarios cadastrados
    function listaLocalizacao() {
        $consulta_listaLocalizacao = "SELECT * FROM circuitos_localizacao;";
        $resultado_listaLocalizacao = mysqli_query($this->connect(), $consulta_listaLocalizacao);
        return $resultado_listaLocalizacao;
    }

    // retorna lista com todos os usuarios cadastrados
    function addRegistroConsumo($_designacao, $_localizacao, $_codigo_unidade) {
        date_default_timezone_set("America/Bahia");
        $data = date('Y-m-d');
        $consulta_editLinhaArquivo = " INSERT INTO `circuitos_registro_consumo`(`codigo`,`localizacao`,`codigo_unidade`,`data_ativacao`) VALUES('$_designacao','$_localizacao','$_codigo_unidade','$data'); ";
        $resultado_editLinhaArquivo = mysqli_query($this->connect(), $consulta_editLinhaArquivo);
        return $resultado_editLinhaArquivo;
    }

    function listaCircuitosCadstrados($_contrato, $_dre, $_unidade, $_circuito) {
        $consulta = "SELECT rc.codigo as designacao ,c.fatura, rc.data_ativacao ,rc.data_ult_ref ,rc.velocidade ,rc.tipo_servico ,rc.tip_logradouro ,rc.nome_logradouro ,rc.nome_cidade ,rc.num_imovel ,rc.nome_bairro    ,lo.descricao as localizacao ,u.descricao as nome_unidade ,u.ativo as status_unidade ,dre.sigla as sigla_dre FROM circuitos_registro_consumo as rc join circuitos_localizacao as lo on lo.codigo = rc.localizacao  join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade join circuitos_unidades as dre on dre.codigo_siig = u.codigo_unidade_pai join circuitos_contas as c on c.designacao = rc.codigo and c.periodo_ref = rc.data_ult_ref where tipo_servico is not null "
                . " and rc.codigo like '%$_circuito%' and c.fatura like '%$_contrato%' and dre.sigla like '%$_dre%' and u.descricao like '%$_unidade%' "
                . " order by dre.sigla, u.descricao, rc.codigo;";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    // retorna lista com todos os usuarios cadastrados
    function listaCircuitos($_mescad, $_fatura) {
        $consulta_circuito1 = " SELECT c.periodo_ref, c.fatura, rc.localizacao,"
                . " CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(SUM(c.valor_conta), 2),'.',';'),',','.'),';',',')) as valor, "
                . " date_format(c.periodo_ref,'%m/%Y') as mes, lo.descricao, "
                . " co.descricao_servico FROM circuitos_contas as c "
                . " join circuitos_registro_consumo as rc on rc.codigo = c.designacao "
                . " join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade "
                . " join circuitos_localizacao as lo on lo.codigo = rc.localizacao "
                . " join circuitos_contrato as co on co.codigo = c.fatura "
                . " where c.periodo_ref = '$_mescad' and c.fatura like '%$_fatura%' "
                . " GROUP BY c.periodo_ref, c.fatura, rc.localizacao "
                . " ORDER BY c.periodo_ref desc, c.fatura , rc.localizacao; ";
        $resultado_circuito1 = mysqli_query($this->connect(), $consulta_circuito1);
        return $resultado_circuito1;
    }

    function listaPeriodoRef() {
        $consulta_circuito2 = "SELECT distinct periodo_ref, date_format(periodo_ref,'%m/%Y') as mes FROM circuitos_contas order by periodo_ref desc limit 10";
        $resultado_circuito2 = mysqli_query($this->connect(), $consulta_circuito2);
        return $resultado_circuito2;
    }

    function listaRegConsumo() {
        $consulta_listaRegConsumo = "SELECT rc.codigo , u.descricao as cidade  FROM circuitos_registro_consumo as rc join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade;";
        $resultado_listaRegConsumo = mysqli_query($this->connect(), $consulta_listaRegConsumo);
        return $resultado_listaRegConsumo;
    }

    function listaConsultaDetalhada($_unidade, $_fatura, $_circuito, $_diretoria, $_mescad, $_inep) {
        if(($_inep != NULL)||($_inep != '')){
            $filtro = " and u.codigo_inep = '$_inep' ";
        } else {
            $filtro = "";
        }
        $consulta = " SELECT u_sup.sigla AS `DRE`, u.cidade AS `cidade`, u.codigo_inep, c.designacao AS `circuito`, u.descricao AS `nome_unidade`, DATE_FORMAT(c.periodo_ref, '%m/%Y') AS `periodo_ref`, c.`fatura`, rc.velocidade, CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(c.valor_conta, 2), '.', ';'), ',', '.'), ';', ',')) AS `valor_conta` FROM `circuitos_contas` AS c JOIN `circuitos_registro_consumo` AS rc ON rc.codigo = c.designacao JOIN `circuitos_unidades` AS u ON u.codigo_ut_siig = rc.codigo_unidade JOIN `circuitos_unidades` AS u_sup ON u.codigo_unidade_pai = u_sup.codigo_siig WHERE u.descricao LIKE '%$_unidade%' AND c.`fatura` LIKE '%$_fatura%' AND c.designacao LIKE '%$_circuito%' AND u_sup.sigla LIKE '%$_diretoria%' AND c.periodo_ref = '$_mescad' $filtro ORDER BY u_sup.sigla , u.cidade , u.descricao; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaValorContasAno() {
        $consulta_c = " SELECT c.periodo_ref, c.fatura, SUM(c.valor_conta) as valor_double,CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(SUM(c.valor_conta), 2),'.',';'),',','.'),';',',')) as valor, date_format(c.periodo_ref,'%m/%Y') as mes, co.descricao_servico FROM circuitos_contas as c join circuitos_registro_consumo as rc on rc.codigo = c.designacao join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade join circuitos_localizacao as lo on lo.codigo = rc.localizacao join circuitos_contrato as co on co.codigo = c.fatura WHERE c.periodo_ref > (date_sub(now(), interval 12 month))  and c.fatura like '%%' GROUP BY c.periodo_ref, c.fatura ORDER BY c.periodo_ref asc, c.fatura;";
        $resultado_c = mysqli_query($this->connect(), $consulta_c);
        return $resultado_c;
    }

    function listaMesesContasAno() {
        $consulta_listaMesesContasAno = " SELECT distinct date_format(c.periodo_ref,'%m/%Y') as mes FROM circuitos_contas as c join circuitos_registro_consumo as rc on rc.codigo = c.designacao join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade join circuitos_localizacao as lo on lo.codigo = rc.localizacao join circuitos_contrato as co on co.codigo = c.fatura WHERE c.periodo_ref > (date_sub(now(), interval 12 month))  and c.fatura like '%%' GROUP BY c.periodo_ref, c.fatura ORDER BY c.periodo_ref asc, c.fatura; ";
        $resultado_listaMesesContasAno = mysqli_query($this->connect(), $consulta_listaMesesContasAno);
        return $resultado_listaMesesContasAno;
    }

    function listaContratosContasAno() {
        $consulta_listaContratosContasAno = " SELECT distinct c.fatura FROM circuitos_contas as c join circuitos_registro_consumo as rc on rc.codigo = c.designacao join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade join circuitos_localizacao as lo on lo.codigo = rc.localizacao join circuitos_contrato as co on co.codigo = c.fatura WHERE c.periodo_ref > (date_sub(now(), interval 12 month))  and c.fatura like '%%' GROUP BY c.periodo_ref, c.fatura ORDER BY c.periodo_ref asc, c.fatura; ";
        $resultado_listaContratosContasAno = mysqli_query($this->connect(), $consulta_listaContratosContasAno);
        return $resultado_listaContratosContasAno;
    }

    function __destruct() {
        
    }

}

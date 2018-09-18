<?php

/**
 * Description of Rede
 *
 * @author tiagoc
 */
class Rede extends Database {

    function getRede($_codVlan) {
        $consulta_getRede = " SELECT count(codigo) as 'qtd_redes', `codigo`, `nome`, `qtd_hosts`, `descricao`, `rede`, `mascara`, `gateway`, `cor`, `fonte` FROM redelocal_vlan "
                . " where codigo = '$_codVlan'";
        $resultado_getRede = mysqli_query($this->connect(), $consulta_getRede);
        return $resultado_getRede;
    }

    function getArrayIPsRede($_codVlan) {
        $resultado = $this->getRede($_codVlan);
        $ips = Array();
        foreach ($resultado as $table) {
            if ($table['qtd_redes'] == '1') {
                $ip = explode(".", $table['rede']);
                $inicio = $ip['3'] + 1;
                $fim = intval($ip['3']) + intval($table['qtd_hosts']);
                for ($i = $inicio; $i <= $fim; $i++) {
                    $ips[] = $ip['0'] . '.' . $ip['1'] . '.' . $ip['2'] . '.' . $i;
                }
                return $ips;
            }
        }
    }

}

/**
 * Description of Log Arquivos Rede Local
 *
 * @author tiagoc
 */
class LogArquivos extends Database {

    function insertImportLogArquivo($_linhas) {
        $consulta_insertImportLogArquivo = " INSERT INTO `redelocal_log_arquivos` (`codigo_acao`,`data_hora`,`usuario`,`arquivo`,`descricao_acao`) VALUES "
                . implode(',', $_linhas) . ";";
        $resultado_insertImportLogArquivo = mysqli_query($this->connect(), $consulta_insertImportLogArquivo);
        return $resultado_insertImportLogArquivo;
    }

    function limpaLog() {
        $consulta_insertImportLogArquivo1 = " delete FROM redelocal_log_arquivos where arquivo like '%.tmp%' and codigo > 0;";
        $resultado_insertImportLogArquivo1 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo1);
        $consulta_insertImportLogArquivo2 = " delete FROM redelocal_log_arquivos where arquivo like '%~$%' and codigo > 0;";
        $resultado_insertImportLogArquivo2 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo2);
        $consulta_insertImportLogArquivo3 = " delete FROM redelocal_log_arquivos where arquivo like '%DFSR%' and codigo > 0";
        $resultado_insertImportLogArquivo3 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo3);
        $consulta_insertImportLogArquivo4 = " delete FROM redelocal_log_arquivos where arquivo like '%RECYCLE.BIN%' and codigo > 0;";
        $resultado_insertImportLogArquivo4 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo4);
        $consulta_insertImportLogArquivo5 = " delete FROM redelocal_log_arquivos where arquivo like '%Thumbs.db%' and codigo > 0;";
        $resultado_insertImportLogArquivo5 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo5);
        return $resultado_insertImportLogArquivo5 . $resultado_insertImportLogArquivo1 . $resultado_insertImportLogArquivo2 . $resultado_insertImportLogArquivo3 . $resultado_insertImportLogArquivo4;
    }

    function consArquivos($_data_inicio, $_data_fim, $_usuario, $_arquivo, $_acao) {
        if ($_usuario != '') {
            $usr = "and usuario = '" . $_usuario . "'";
        } else {
            $usr = "";
        }
        $usr = "and usuario = '" . $_usuario . "'";
        $consulta = " select codigo_acao, data_hora, usuario, arquivo, descricao_acao  , count(arquivo) as cont_arq FROM redelocal_log_arquivos where data_hora >= '$_data_inicio' and data_hora <= '$_data_fim' $usr  and arquivo like '%$_arquivo%' and descricao_acao like '%$_acao%' group by codigo_acao, data_hora, usuario, arquivo order by  data_hora desc, usuario ,arquivo, codigo_acao; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function usuariosArquivos() {
        $consulta = " select distinctrow usuario FROM redelocal_log_arquivos order by usuario; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function consUltData() {
        $consulta_consUltDataDel = " SELECT max(data_hora) as ult_data FROM redelocal_log_arquivos ; ";
        $resultado_consUltDataDel = mysqli_query($this->connect(), $consulta_consUltDataDel);
        foreach ($resultado_consUltDataDel as $value) {
            $data = $value['ult_data'];
        }
        return $data;
    }

    function convert_data_BR_US($_data) {
        $dataEN = DateTime::createFromFormat('d/m/Y H:i:s', $_data);
        return $dataEN->format('Y-m-d H:i:s');
    }

    function convert_data_US_BR($_data) {
        $dataBR = new DateTime($_data);
        return $dataBR->format('d/m/Y H:i:s');
    }

}

/**
 * Description of Switchs Ativos Rede Local
 *
 * @author tiagoc
 */
class Switchs extends Database {

    function listaSwitch($_marca, $_modelo, $_ip, $_bloco, $_setor) {
        $consulta_listSwitch = " SELECT sw.codigo as codigo_sw, sw.ip,"
                . " sw.empilhado, sw.numero_empilhamento, sw.ativo as ativo_sw, "
                . " sw.vlan_padrao, sw.data_incl as data_alt_sw, "
                . " msw.descricao as modelo_sw, msw.qtd_portas_eth, "
                . " msw.qtd_portas_fc, msw.gerenciavel, m.descricao as marca_sw, "
                . " r.descricao as descricao_rack, r.setor as setor_rack, "
                . " b.nome as nome_bloco, b.descricao as descricao_bloco "
                . " FROM redelocal_switch as sw "
                . " join redelocal_modelo_switch as msw on msw.codigo = sw.codigo_modelo "
                . " join redelocal_marca as m on m.codigo =  msw.codigo_marca "
                . " join redelocal_rack as r on r.codigo = sw.codigo_rack "
                . " join redelocal_bloco as b on b.codigo = r.codigo_bloco "
                . " where m.descricao like '%$_marca%' and msw.descricao like '%$_modelo%' "
                . " and sw.ip like '%$_ip%' and b.nome like '%$_bloco%' and r.setor like '%$_setor%' "
                . " order by b.nome asc, r.descricao asc, msw.descricao, sw.numero_empilhamento asc  ;";
        $resultado_listSwitch = mysqli_query($this->connect(), $consulta_listSwitch);

        return $resultado_listSwitch;
    }

    function limpaPortaSwitch($_switch, $_porta, $_tipo_porta) {
        $consulta_limpaPortaSwitch = " DELETE FROM `redelocal_porta_switch` "
                . " WHERE codigo_switch = '$_switch' and codigo_porta_switch = '$_porta' and tipo_porta = '$_tipo_porta'; ";
        $resultado_limpaPortaSwitch = mysqli_query($this->connect(), $consulta_limpaPortaSwitch);
        return $resultado_limpaPortaSwitch;
    }

    function limpaImpPorta($_hostZabbix) {
        $consulta_limpaImpPorta = " DELETE FROM `redelocal_impressora` WHERE `codigo_host_zabbix` = '$_hostZabbix'; ";
        $resultado_limpaImpPorta = mysqli_query($this->connect(), $consulta_limpaImpPorta);
        return $resultado_limpaImpPorta;
    }

    function consImpressoraPorta($_switch, $_porta, $_tipo_porta) {
        $consulta_consImpressoraPorta = " SELECT count(codigo_modelo) as contador, `codigo_modelo`, `codigo_switch`,`codigo_porta_switch`,`tipo_porta`,`codigo_host_zabbix`,`setor` "
                . " FROM `redelocal_impressora` where `codigo_switch` = '$_switch' and `codigo_porta_switch` = '$_porta' and `tipo_porta` = '$_tipo_porta'; ";
        $resultado_consImpressoraPorta = mysqli_query($this->connect(), $consulta_consImpressoraPorta);
        return $resultado_consImpressoraPorta;
    }

    function consImpressoraZbx($_hostZabbix) {
        $consulta_consImpressoraZbx = " SELECT count(codigo_modelo) as contador, `codigo_modelo`, `codigo_switch`,`codigo_porta_switch`,`tipo_porta`,`codigo_host_zabbix`,`setor` "
                . " FROM `redelocal_impressora` where `codigo_host_zabbix` = '$_hostZabbix'; ";
        $resultado_consImpressoraZbx = mysqli_query($this->connect(), $consulta_consImpressoraZbx);
        return $resultado_consImpressoraZbx;
    }

    function dadosSwitch($_codigo) {
        $consulta_listSwitch = " SELECT sw.codigo as codigo_sw, sw.ip,"
                . " sw.empilhado, sw.numero_empilhamento, sw.ativo as ativo_sw, "
                . " sw.vlan_padrao, sw.data_incl as data_alt_sw, "
                . " msw.descricao as modelo_sw, msw.qtd_portas_eth, "
                . " msw.qtd_portas_fc, msw.gerenciavel, m.descricao as marca_sw, "
                . " r.descricao as descricao_rack, r.setor as setor_rack, "
                . " b.nome as nome_bloco, b.descricao as descricao_bloco "
                . " FROM redelocal_switch as sw "
                . " join redelocal_modelo_switch as msw on msw.codigo = sw.codigo_modelo "
                . " join redelocal_marca as m on m.codigo =  msw.codigo_marca "
                . " join redelocal_rack as r on r.codigo = sw.codigo_rack "
                . " join redelocal_bloco as b on b.codigo = r.codigo_bloco "
                . " where sw.codigo = '$_codigo'; ";
        $resultado_listSwitch = mysqli_query($this->connect(), $consulta_listSwitch);

        return $resultado_listSwitch;
    }

    function listImprCad() {
        $consulta_listImprCad = " SELECT * FROM `redelocal_impressora` as i; ";
        $resultado_listImprCad = mysqli_query($this->connect(), $consulta_listImprCad);
        return $resultado_listImprCad;
    }

    function listModImpr() {
        $consulta_listModImpr = " SELECT mi.*, mi.descricao as modelo, m.descricao as marca FROM redelocal_modelo_impressora as mi join redelocal_marca as m on m.codigo = mi.codigo_marca; ";
        $resultado_listModImpr = mysqli_query($this->connect(), $consulta_listModImpr);
        return $resultado_listModImpr;
    }

    function listPortasSwitch() {
        $consulta_listPortaSwitch = " SELECT `codigo_switch`, `codigo_porta_switch`, "
                . " `tipo_porta`, `velocidade`, `codigo_vlan`, `observacao`, "
                . " `texto_tela`, `data_alt`, cor, fonte  FROM `redelocal_porta_switch` as psw  inner join redelocal_vlan as v on psw.codigo_vlan = v.codigo; ";
        $resultado_listPortaSwitch = mysqli_query($this->connect(), $consulta_listPortaSwitch);
        return $resultado_listPortaSwitch;
    }

    function listavlans() {
        $consulta_listaVlans = " SELECT codigo, descricao, cor, fonte FROM homo_sis_geitec.redelocal_vlan; ";
        $resultado_listaVlans = mysqli_query($this->connect(), $consulta_listaVlans);
        return $resultado_listaVlans;
    }

    function listVlan() {
        $consulta_listVlan = " SELECT `codigo`, `nome`, `qtd_hosts`, `descricao`, `rede`, `mascara`, `gateway`,`cor`,`fonte` FROM `redelocal_vlan`; ";
        $resultado_listVlan = mysqli_query($this->connect(), $consulta_listVlan);
        return $resultado_listVlan;
    }

    function listImpressoras($_bloco, $_rack) {
        $consulta_listImpressoras = " select c0.*, c1.codigo_host_zabbix, c1.marca, c1.modelo, c1.colorida, c1.laser, c1.tinta, c1.rede, c1.scanner from (SELECT tpsw.descricao AS 'tipo_porta_desc', r.descricao AS 'rack', b.nome AS 'bloco', b.descricao AS 'bloco_descricao', sw.numero_empilhamento, sw.ip, psw.codigo_switch, psw.codigo_porta_switch, psw.codigo_vlan, psw.tipo_porta FROM redelocal_porta_switch AS psw JOIN redelocal_switch AS sw ON psw.codigo_switch = sw.codigo JOIN redelocal_rack AS r ON sw.codigo_rack = r.codigo JOIN redelocal_bloco AS b ON r.codigo_bloco = b.codigo JOIN redelocal_tipo_porta_sw AS tpsw ON tpsw.codigo = psw.tipo_porta) as c0 left join (SELECT i.codigo_host_zabbix, mi.descricao AS 'modelo', m.descricao AS 'marca', tpsw.descricao AS 'tipo_porta_desc', mi.colorida, mi.laser, mi.tinta, mi.rede, mi.scanner, psw.codigo_switch, psw.codigo_porta_switch, psw.codigo_vlan, psw.tipo_porta FROM redelocal_impressora AS i JOIN redelocal_modelo_impressora AS mi ON mi.codigo = i.codigo_modelo JOIN redelocal_marca AS m ON m.codigo = mi.codigo_marca JOIN redelocal_switch AS sw ON i.codigo_switch = sw.codigo JOIN redelocal_porta_switch AS psw ON psw.codigo_switch = i.codigo_switch AND psw.codigo_porta_switch = i.codigo_porta_switch AND psw.tipo_porta = i.tipo_porta JOIN redelocal_rack AS r ON sw.codigo_rack = r.codigo JOIN redelocal_bloco AS b ON r.codigo_bloco = b.codigo JOIN redelocal_tipo_porta_sw AS tpsw ON tpsw.codigo = psw.tipo_porta) as c1 on c1.codigo_switch = c0.codigo_switch and c0.codigo_porta_switch = c1.codigo_porta_switch and c0.tipo_porta = c1.tipo_porta where c0.codigo_vlan = '300' and c0.bloco like '%$_bloco%' and c0.rack like '%$_rack%' order by c0.bloco, c0.rack, c0.ip; ";
        $resultado_listImpressoras = mysqli_query($this->connect(), $consulta_listImpressoras);
        return $resultado_listImpressoras;
    }

    function testePorta($_porta, $_switch, $_tipoPorta) {
        $consulta_testePorta = " SELECT count(codigo_switch) as cont FROM redelocal_porta_switch "
                . " where codigo_switch = '$_switch' and codigo_porta_switch = '$_porta' and tipo_porta = '$_tipoPorta'; ";
        $resultado_testePorta = mysqli_query($this->connect(), $consulta_testePorta);
        foreach ($resultado_testePorta as $table_testePorta) {
            $resutaldo = $table_testePorta["cont"];
        }
        return $resutaldo;
    }

    function cadImpressora($_porta, $_switch, $_tipoPorta, $_setor, $_codigo_zabbix, $_codigo_modelo) {
        $consulta_cadImpressora = " INSERT INTO `redelocal_impressora` "
                . " (`codigo_modelo`,`codigo_switch`,`codigo_porta_switch`,`tipo_porta`,`codigo_host_zabbix`,`setor`) "
                . " VALUES ('$_codigo_modelo','$_switch','$_porta','$_tipoPorta','$_codigo_zabbix','$_setor'); ";
        $resultado_cadImpressora = mysqli_query($this->connect(), $consulta_cadImpressora);
        return $resultado_cadImpressora;
    }

    function iniPorta($_porta, $_switch, $_tipoPorta) {
        $resultado = $this->testePorta($_porta, $_switch, $_tipoPorta);
        if ($resultado == '1') {
            $consulta_iniPorta = " SELECT p_sw.*, imp.codigo_modelo, imp.setor , imp.codigo_host_zabbix as cod_imp FROM redelocal_porta_switch as p_sw "
                    . " left join redelocal_impressora as imp on imp.codigo_porta_switch = p_sw.codigo_porta_switch and imp.codigo_switch = p_sw.codigo_switch and imp.tipo_porta = p_sw.tipo_porta "
                    . " where p_sw.codigo_switch = '$_switch' and p_sw.codigo_porta_switch = '$_porta' and p_sw.tipo_porta = '$_tipoPorta'; ";
            $resultado_iniPorta = mysqli_query($this->connect(), $consulta_iniPorta);
        } else {
            $consulta_iniPorta = " SELECT sw.codigo as 'codigo_switch', '$_porta' as 'codigo_porta_switch', '$_tipoPorta' as 'tipo_porta',  msw.velocidade_padrao_portas as 'velocidade', sw.vlan_padrao as 'codigo_vlan', '' as 'observacao' , sw.vlan_padrao as 'texto_tela', now() as 'data_alt', ' ' as cod_imp, '' as codigo_modelo, '' as setor FROM redelocal_switch as sw join redelocal_modelo_switch as msw on msw.codigo = sw.codigo_modelo where sw.codigo = '$_switch'; ";
            $resultado_iniPorta = mysqli_query($this->connect(), $consulta_iniPorta);
        }
        return $resultado_iniPorta;
    }

    function manutPortaSwitch($_porta, $_switch, $_tipoPorta, $_velocidade, $_codigoVlan, $_observacao, $_textoTela, $_dataAlt) {
        $resultado = $this->testePorta($_porta, $_switch, $_tipoPorta);
        if ($resultado == '1') {
            $consulta_manutPortaSwitch2 = " UPDATE `redelocal_porta_switch` SET "
                    . "`velocidade` = '$_velocidade', `codigo_vlan` = '$_codigoVlan', "
                    . "`observacao` = '$_observacao', `texto_tela` = '$_textoTela', `data_alt` = '$_dataAlt' "
                    . " where codigo_switch = '$_switch' and codigo_porta_switch = '$_porta' and tipo_porta = '$_tipoPorta'; ";
            $resultado_manutPortaSwitch2 = mysqli_query($this->connect(), $consulta_manutPortaSwitch2);
        } elseif ($resultado == '0') {
            $consulta_manutPortaSwitch2 = " INSERT INTO `redelocal_porta_switch` "
                    . " (`codigo_switch`,`codigo_porta_switch`,`tipo_porta`,`velocidade`,`codigo_vlan`,`observacao`,`texto_tela`,`data_alt`)"
                    . " VALUES('$_switch','$_porta','$_tipoPorta','$_velocidade','$_codigoVlan','$_observacao','$_textoTela','$_dataAlt'); ";
            $resultado_manutPortaSwitch2 = mysqli_query($this->connect(), $consulta_manutPortaSwitch2);
        }
    }

    function imprimiAtivo($_codigo) {
        if ($_codigo == '1') {
            return '<span class="glyphicon glyphicon-remove-circle btn-danger">';
        } elseif ($_codigo == '0') {
            return '<span class="glyphicon glyphicon-ok-circle btn-success">';
        } else {
            return '<span class="glyphicon glyphicon-ban-circle">';
        }
    }

}

/**
 * Description of Rotinas Referentes A Descritivo Rede LOCAL
 * 
 * @author tiagoc
 */
class RedeLocal extends Database {

    /**
     * Dados `codigo` | `tipo` | `descricao` | `usuario` | `senha` | `local_alocado` 
     * Filtro `tipo` | `descricao` | `local_alocado` 
     * @return array consulta
     */
    function listaCredenciais($_tipo, $_descricao, $_local) {
        $consulta_listaCredenciais = " SELECT * FROM redelocal_credenciais where tipo like '%$_tipo%' and descricao like '%$_descricao%' and local_alocado like '%$_local%'"
                . " order by `tipo`, `descricao`, `local_alocado`; ";
        $resultado_listaCredenciais = mysqli_query($this->connect(), $consulta_listaCredenciais);
        return $resultado_listaCredenciais;
    }

    /**
     * Dados `codigo` | `tipo` | `descricao` | `usuario` | `senha` | `local_alocado` 
     * Filtro `tipo` | `descricao` | `local_alocado` 
     * @return array consulta com 1 registro
     */
    function dadosCredencial($_codigo) {
        $consulta_dadosCredencial = " SELECT c.* , count(c.codigo) as cont  FROM redelocal_credenciais as c where c.codigo = '$_codigo'; ";
        $resultado_dadosCredencial = mysqli_query($this->connect(), $consulta_dadosCredencial);
        return $resultado_dadosCredencial;
    }

    /**
     * 
     * @param type $_usuario
     * @return array resultado consulta usuários em listas 
     */
    function usuariosListaExpresso($_usuario, $_conferido) {
        if ($_conferido == '1') {
            $_conferido = " emails.conferido is null ";
        } elseif ($_conferido == '0') {
            $_conferido = " emails.conferido is not null ";
        } else {
            $_conferido = "";
        } 
        $text = " where ";
        if (($_usuario != "") && ($_conferido != "")) {
            $text = $text . " emails.email like '%$_usuario%' and $_conferido ";
        } elseif (($_usuario == "") && ($_conferido != "")) {
            $text = $text . " $_conferido ";
        } elseif (($_usuario != "") && ($_conferido == "")) {
            $text = $text . " emails.email like '%$_usuario%' ";
        } else {
            $text = " ";
        }       
        $consulta = " SELECT emails.*, ger.lista_seed_geral, usr.lista_seed_usuarios, adm.lista_seed_administrativo, esc.lista_seed_escest FROM (SELECT email, nome_usuario, COUNT(email) AS qtd_lista, conferido, usuario FROM redelocal_usuarios_lista_expresso le GROUP BY email) AS emails LEFT JOIN (SELECT email, '1' AS 'lista_seed_administrativo' FROM redelocal_usuarios_lista_expresso WHERE nome_lista = 'lista-seed-administrativo') AS adm ON adm.email = emails.email LEFT JOIN (SELECT email, '1' AS 'lista_seed_escest' FROM redelocal_usuarios_lista_expresso WHERE nome_lista = 'lista-seed-escest') AS esc ON esc.email = emails.email LEFT JOIN (SELECT email, '1' AS 'lista_seed_geral' FROM redelocal_usuarios_lista_expresso WHERE nome_lista = 'lista-seed-geral') AS ger ON ger.email = emails.email LEFT JOIN (SELECT email, '1' AS 'lista_seed_usuarios' FROM redelocal_usuarios_lista_expresso WHERE nome_lista = 'lista-seed-usuarios') AS usr ON usr.email = emails.email $text ORDER BY emails.email; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }
    
    function updateUsuarioLista($_email){
        
        $consulta = " UPDATE `redelocal_usuarios_lista_expresso` SET usuario = '".$_SESSION['login']."', conferido = '".date("Y-m-d H:i:s")."' WHERE email = '$_email' and conferido is null; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    } 

    /**
     * 
     * @param type $_codigo
     * @param type $_tipo
     * @param type $_descricao
     * @param type $_usuario
     * @param type $_senha
     * @param type $_local_alocado
     * @return type
     */
    function manuCredencial($_codigo, $_tipo, $_descricao, $_usuario, $_senha, $_local_alocado) {
        $resultDados = $this->dadosCredencial($_codigo);
        foreach ($resultDados as $dados) {
            if ($dados['cont'] == '0') {
                $consulta_manuCredencial = " INSERT INTO `redelocal_credenciais`(`tipo`,`descricao`,`usuario`,`senha`,`local_alocado`)VALUES('$_tipo','$_descricao','$_usuario','$_senha','$_local_alocado'); ";
                $resultado_manuCredencial = mysqli_query($this->connect(), $consulta_manuCredencial);
            } else {
                $consulta_manuCredencial = " UPDATE `redelocal_credenciais` SET `tipo` = '$_tipo', `descricao` = '$_descricao', `usuario` = '$_usuario', `senha` = '$_senha', `local_alocado` = '$_local_alocado' WHERE `codigo` = '$_codigo'; ";
                $resultado_manuCredencial = mysqli_query($this->connect(), $consulta_manuCredencial);
            }
            return $resultado_manuCredencial;
        }
    }

}

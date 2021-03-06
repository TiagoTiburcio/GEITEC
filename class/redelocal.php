<?php


/**
 * Description of Rede
 *
 * @author tiagoc
 */
class GraficosDiscosDC extends Database {

    function listaMeses() {
        $consulta = " SELECT distinct DATE_FORMAT(data, '%m/%Y') as mes, data FROM sis_geitec.temp_dados_discos where DAY(data) = 01; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    // 
    
    function listaVM() {
        $consulta = " SELECT distinct host, name_pool FROM sis_geitec.temp_dados_discos where DAY(data) = 01 order by name_pool,host; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaEspacoPorVM() {
        $consulta = " SELECT name_pool, host, data, format(total_disco,2,'de_DE') as total_disco_format, DATE_FORMAT(data, '%m/%Y') as mes, total_disco FROM sis_geitec.temp_dados_discos where DAY(data) = 01 order by name_pool,host; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }
}


/**
 * Description of Rede
 *
 * @author tiagoc
 */
class GraficosMemDC extends Database {

    function listaMeses() {
        $consulta = ' select distinct mes_ano from ( SELECT `tmht`.`host`, `tmht`.`data_hora`, DATE_FORMAT(`tmht`.`data_hora`, "%m/%Y") as mes_ano, `tmht`.`livre_mb`, `tmht`.`utilizada_mb`, `tmht`.`total_mb`, `tmht`.`livre_perc`, `tmht`.`utilizada_perc` FROM `sis_geitec`.`temp_mem_hist_tratada` as `tmht` ) as c1 where data_hora > SUBDATE(current_timestamp(), INTERVAL 3 MONTH) group by host, mes_ano order by `data_hora`; ' ;
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    // 
    
    function listaVM() {
        $consulta = " SELECT gr.groupid, gr.name as group_name, ht.hostid, ht.host, ht.available, ht.name as host_apelido FROM zabbixcofre.groups AS gr JOIN zabbixcofre.hosts_groups AS ht_gr ON ht_gr.groupid = gr.groupid JOIN zabbixcofre.hosts AS ht ON ht.hostid = ht_gr.hostid JOIN zabbixcofre.items AS it ON ht.hostid = it.hostid WHERE gr.groupid IN ('39' , '40', '41') group by host order by gr.name, ht.host; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function listaDadosMemVMs() {
        $consulta = " SELECT gr.groupid, gr.name AS group_name, ht.hostid, ht.host, ht.available, ht.name AS host_apelido, hist.mes_ano, hist.`livre_mb`, hist.`utilizada_mb`, hist.`total_mb`, hist.`livre_perc`, hist.`utilizada_perc` FROM zabbixcofre.groups AS gr JOIN zabbixcofre.hosts_groups AS ht_gr ON ht_gr.groupid = gr.groupid JOIN zabbixcofre.hosts AS ht ON ht.hostid = ht_gr.hostid JOIN zabbixcofre.items AS it ON ht.hostid = it.hostid JOIN (SELECT * FROM (SELECT `tmht`.`host`, `tmht`.`data_hora`, DATE_FORMAT(`tmht`.`data_hora`, '%m/%Y') AS mes_ano, `tmht`.`livre_mb`, `tmht`.`utilizada_mb`, `tmht`.`total_mb`, `tmht`.`livre_perc`, `tmht`.`utilizada_perc` FROM `sis_geitec`.`temp_mem_hist_tratada` AS `tmht`) AS c1 GROUP BY host , mes_ano) AS hist ON hist.host = ht.host WHERE gr.groupid IN ('39' , '40', '41') GROUP BY host , hist.mes_ano ORDER BY gr.name , ht.host,hist.data_hora; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }
}


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

    function getAlertas($_nome) {
        $consulta = " SELECT count(nome_host) as cont, `nome_host`,`data_evento`,`resolvido` FROM redelocal_alerta where nome_host = '$_nome' and resolvido <> '1'; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function setAlerta($_nome, $_data) {
        $consulta = " INSERT INTO `redelocal_alerta` (`nome_host`,`data_evento`,`resolvido`) VALUES ('$_nome', '$_data', '0'); ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    function updateAlerta($_nome, $_data) {
        $consulta = " UPDATE `redelocal_alerta` SET  `resolvido` = '1' WHERE `nome_host` = '$_nome' AND `data_evento` = '$_data'; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

}

class RedeLocalServidores extends Database {

    /**
     * @param type $_hostid
     * @return type
     */
    function listServidores($_hostid = '') {
        $consulta = " SELECT `codigo`, `nome_servidor`, `hostid_zbx` FROM `redelocal_servidores` where `hostid_zbx` = '$_hostid'; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }
    
    /**
     * @param type $_hostid
     * @return type
     */
    function listAplicativos($_hostid = '') {
        $consulta = " SELECT app.codigo, app.codigo_servidor, app.nome as nome_app, app.descricao as descricao_app, app.tipo_app, bd.nome as nome_bd, bd.descricao as descricao_bd, bd.tipo_banco_dados FROM redelocal_srv_aplicativo AS app LEFT JOIN redelocal_app_bd AS app_bd ON app_bd.codigo_app = app.codigo left JOIN redelocal_srv_banco_dados AS bd ON bd.codigo = app_bd.codigo_bd where app.codigo_servidor = '$_hostid' ;  ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }
   
     /**
     * 
     * @param type $_hostid
     * @param type $_nome_bd
     * @param type $_tipo_banco_dados
     * @param type $codigo_bd
     * @return type
     */
    function addBancoDados($_hostid, $_nome_bd, $_tipo_banco_dados,$_descricao, $codigo_bd = '') {
        if ($codigo_bd == '') {
            $consulta = " INSERT INTO `redelocal_srv_banco_dados`(`nome`,`codigo_servidor`,`tipo_banco_dados`,`descricao`) VALUES ('$_nome_bd','$_hostid','$_tipo_banco_dados','$_descricao');";
        } else {
            $consulta = " UPDATE `redelocal_srv_banco_dados` SET `nome` = '$_nome_bd', `codigo_servidor` = '$_hostid' , `tipo_banco_dados` = '$_tipo_banco_dados', `descricao` = '$_descricao' WHERE `codigo` = '$codigo_bd'; ";
        }
        echo $consulta;
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }
    
    /**
     * 
     * @param type $_hostid
     * @param type $_nome_aplicativo
     * @param type $_descricao_app
     * @param type $codigo_app
     * @return type
     */
    function addAplicativo($_hostid, $_nome_aplicativo, $_descricao_app, $_tipo_app,$codigo_app = '') {
        if ($codigo_app == '') {
            $consulta = " INSERT INTO `redelocal_srv_aplicativo` (`nome`,`descricao`,`codigo_servidor`,`tipo_app`) VALUES (' $_nome_aplicativo', '$_descricao_app', '$_hostid', '$_tipo_app'); ";
        } else {
            $consulta = " UPDATE `redelocal_srv_aplicativo` SET `nome` = '$_nome_aplicativo', `descricao` = '$_descricao_app', `codigo_servidor` = '$_hostid', `tipo_app` = '$_tipo_app' WHERE `codigo` = '$codigo_app'; ";
        }
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }
    
    
    
    
}

class ServidoresRede extends DatabaseZbxCofre {

    /**
     * @param type $_type
     * @param type $_amb
     * @param type $_so
     * @param type $_nome
     * @return type
     */
    function listServidores($_type = '0', $_amb = '0', $_so = '0', $_nome = '', $_hostid = '') {
        $filtro = " and h.host like '%$_nome%' ";
        if ($_type != '0') {
            $filtro = $filtro . " and hi.type = '" . $_type . "' ";
        }
        if ($_amb != '0') {
            $filtro = $filtro . " and hi.tag = '" . $_amb . "' ";
        }
        if ($_so != '0') {
            $filtro = $filtro . " and hi.os_short = '" . $_so . "' ";
        }
        if ($_hostid != '') {
            $filtro = $filtro . " and h.hostid = '" . $_hostid . "' ";
        }
        $consulta = " SELECT h.hostid, h.host, h.status, h.description, hi.type, hi.type_full, hi.name, hi.alias, hi.os, hi.os_full, hi.os_short, hi.tag, hi.software, hi.software_full, hi.software_app_a, hi.software_app_b, hi.software_app_c, hi.software_app_d, hi.software_app_e, hi.contact, hi.location, hi.url_a, hi.url_b, hi.url_c, g.name AS grupo_nome FROM zabbixcofre.hosts AS h LEFT JOIN zabbixcofre.host_inventory AS hi ON hi.hostid = h.hostid JOIN zabbixcofre.hosts_groups AS hg ON hg.hostid = h.hostid JOIN zabbixcofre.groups AS g ON g.groupid = hg.groupid WHERE g.name = 'Servidores' $filtro ORDER BY hi.tag DESC , hi.type , h.host; ";
        $resultado = mysqli_query($this->connectZbxCofre(), $consulta);
        return $resultado;
    }

    /**
     * 
     * @param type $_hostid
     * @return type
     */
    function listInterfaces($_hostid) {
        $consulta = " SELECT distinctrow i.hostid, i.main, i.ip, i.dns FROM interface as i where i.hostid = '$_hostid'; ";
        $resultado = mysqli_query($this->connectZbxCofre(), $consulta);
        return $resultado;
    }

    /**
     * @param type $_hostid
     * @return type
     */
    function itensServidor($_hostid) {
        $consulta = " SELECT i.`itemid`, i.`hostid`, i.`name`, i.`key_`, i.`status`, i.`units` FROM items AS i WHERE i.value_type = '3' AND i.name NOT IN ('Incoming network traffic on $1' , 'Outgoing network traffic on $1') AND i.key_ NOT IN ('vfs.fs.size[{#FSNAME},free]' , 'vfs.fs.size[{#FSNAME},pfree]','vfs.fs.size[{#FSNAME},total]','vfs.fs.size[{#FSNAME},used]') AND i.hostid = '$_hostid';  ";
        $resultado = mysqli_query($this->connectZbxCofre(), $consulta);
        return $resultado;
    }

    /**
     * @param type $_hostid
     * @return type
     */
    function graficosServidor($_hostid) {
        $consulta = " SELECT DISTINCTROW g.graphid, g.name FROM hosts AS h JOIN items AS i ON i.hostid = h.hostid JOIN graphs_items AS gi ON gi.itemid = i.itemid JOIN graphs AS g ON g.graphid = gi.graphid JOIN hosts_groups AS hg ON hg.hostid = h.hostid WHERE hg.groupid = '35'  and g.name not in  ('Crescimento uso disco {#FSNAME}' , 'Uso espaço em Disco {#FSNAME}', 'Disk space usage {#FSNAME}', 'Network traffic on {#IFNAME}') AND h.hostid = '$_hostid';  ";
        $resultado = mysqli_query($this->connectZbxCofre(), $consulta);
        return $resultado;
    }

    /**
     * 
     * @param type $_itemid
     * @return type
     */
    function dadoItem($_itemid) {
        $consulta = " SELECT hu.`itemid`, from_unixtime(hu.`clock`) as data_hora, (hu.`value`) as tamanho FROM `history_uint` as hu where hu.`itemid` = '$_itemid' order by hu.`clock` desc limit 1;  ";
        $resultado = mysqli_query($this->connectZbxCofre(), $consulta);
        return $resultado;
    }

    /**
     * Tipo Servidor
     * @return type consulta
     */
    function listTiposServidores() {
        $consulta = " SELECT distinctrow type, type_full FROM host_inventory as hi where hi.type <> '' order by type; ";
        $resultado = mysqli_query($this->connectZbxCofre(), $consulta);
        return $resultado;
    }

    /**
     * Sistemas Opracionais Servidores
     * @return type consulta
     */
    function listSistemasOperacionais() {
        $consulta = " SELECT distinctrow os_short, os_full FROM host_inventory as hi where hi.os_short <> ''order by hi.os_short; ";
        $resultado = mysqli_query($this->connectZbxCofre(), $consulta);
        return $resultado;
    }

    /**
     * Tipo Servidor Produção Homologação
     * @return type consulta
     */
    function listProdHomo() {
        $consulta = " SELECT distinctrow tag FROM host_inventory as hi where hi.tag <> '' order by hi.tag; ";
        $resultado = mysqli_query($this->connectZbxCofre(), $consulta);
        return $resultado;
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
        $consulta_listaCredenciais = " SELECT * FROM redelocal_credenciais where tipo like '%$_tipo%' and descricao like '%$_descricao%' and local_alocado like '%$_local%' order by `tipo` desc, `descricao`, `local_alocado`; ";
        $resultado_listaCredenciais = mysqli_query($this->connect(), $consulta_listaCredenciais);
        return $resultado_listaCredenciais;
    }

    /**
     * @param type $_codigo
     * @return type
     */
    function getUsuarioExpresso($_codigo) {
        $consulta = "SELECT * FROM ( SELECT * FROM lista_expresso AS le LEFT JOIN (SELECT DISTINCTROW REPLACE(`redelocal_usuarios_lista_expresso`.`email`, '@seduc.se.gov.br', '') AS login_limpo, `redelocal_usuarios_lista_expresso`.`email`, `redelocal_usuarios_lista_expresso`.`nome_usuario` FROM `sis_geitec`.`redelocal_usuarios_lista_expresso` WHERE data_import = '2019-03-29') AS t1 ON le.login = t1.login_limpo ) as t2 where id = '$_codigo';";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    /**
     * @param type $_codigo
     * @return type
     */
    function getUsuarioGeral($_usuario_expresso) {
        $consulta = " SELECT `cpf`, `usuario_expresso`, `usuario_rede`, `codigo_recadastramento`, `data_atualizacao`, `usuario_atualizacao` FROM `usuarios_geral` where `usuario_expresso` = '$_usuario_expresso';  ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    /**
     * @param type $_codigo, $_situacao
     * @return nada
     */
    function updateSituacaoExpresso($_codigo, $_situacao) {
        $consulta = " UPDATE `lista_expresso` SET `edit` = '$_situacao'  WHERE `id` = '$_codigo'; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    /**
     * Lista de Usuários 
     * @return type array Consulta
     */
    function listaExpresso($_limite) {
        if ($_limite != "") {
            $limite = " limit $_limite ";
        } else {
            $limite = "";
        }
        $consulta = " SELECT * FROM ( SELECT * FROM lista_expresso AS le LEFT JOIN (SELECT DISTINCTROW REPLACE(`redelocal_usuarios_lista_expresso`.`email`, '@seduc.se.gov.br', '') AS login_limpo, `redelocal_usuarios_lista_expresso`.`email`, `redelocal_usuarios_lista_expresso`.`nome_usuario` FROM `sis_geitec`.`redelocal_usuarios_lista_expresso` WHERE data_import = '2019-03-29') AS t1 ON le.login = t1.login_limpo ) as t2  where edit = '0' order by dias_sem_logar, ult_acesso desc, login $limite ; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    /**
     *  Retorna Conferidos , Não Conferidos, Total
     * @return type array Totais
     */
    function totalConf() {
        $consulta = " select total, conferidos, a_conferir from (SELECT 1 as id, count(id) as total FROM lista_expresso) as t1 join (select 1 as id, count(id) as a_conferir FROM lista_expresso where edit = '0' ) as t2 on t1.id = t2.id join (SELECT 1 as id, COUNT(id) AS conferidos FROM lista_expresso WHERE edit <> '0' ) as t3 on t1.id = t3.id; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    /**
     *  Retorna Conferidos , Não Conferidos, Total
     * @return type array Totais
     */
    function gravaUsuarioGeral($_cpf, $_usuario_rede, $_codigo_recadastramento, $_usuario_expresso, $_data_atualizacao, $_usuario_atualizacao, $_situacao, $_motivo_desativar) {
        $consulta = " SELECT count(usuario_expresso) as cont, codigo FROM usuarios_geral where usuario_expresso = '$_usuario_expresso'; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        foreach ($resultado as $dados) {
            $cont = $dados['cont'];
            $codigo = $dados['codigo'];
        }
        if ($cont == '1') {
            $consulta = " UPDATE `usuarios_geral` SET `cpf` = '$_cpf', `situacao` = '$_situacao', `motivo_desativar` = '$_motivo_desativar', `usuario_expresso` = '$_usuario_expresso', `usuario_rede` = '$_usuario_rede', `codigo_recadastramento` = '$_codigo_recadastramento', `data_atualizacao` = '$_data_atualizacao', `usuario_atualizacao` = '$_usuario_atualizacao' WHERE `codigo` = '$codigo'; ";
            $resultado = mysqli_query($this->connect(), $consulta);
        } elseif ($cont == '0') {
            $consulta = " INSERT INTO `usuarios_geral` (`cpf`,`usuario_expresso`, `usuario_rede`,`codigo_recadastramento`, `situacao` ,`motivo_desativar`, `data_atualizacao`, `usuario_atualizacao`) VALUES ('$_cpf', '$_usuario_expresso', '$_usuario_rede', '$_codigo_recadastramento', '$_situacao', '$_motivo_desativar', '$_data_atualizacao', '$_usuario_atualizacao'); ";
            $resultado = mysqli_query($this->connect(), $consulta);
        }
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
        } elseif ($_conferido == '3') {
            $_conferido = " emails.conferido is not null and pendencia.resolvido = '0' ";
        } elseif ($_conferido == '4') {
            $_conferido = " emails.conferido is not null and (pendencia.resolvido = '0' or pendencia.resolvido is null)  ";
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
        $consulta = " SELECT emails.*, ger.lista_seed_geral, usr.lista_seed_usuarios, adm.lista_seed_administrativo, esc.lista_seed_escest, pendencia.descricao, pendencia.resolvido FROM (SELECT email, nome_usuario, COUNT(email) AS qtd_lista, conferido, usuario FROM redelocal_usuarios_lista_expresso le GROUP BY email) AS emails LEFT JOIN (SELECT email, '1' AS 'lista_seed_administrativo' FROM redelocal_usuarios_lista_expresso WHERE nome_lista = 'lista-seed-administrativo') AS adm ON adm.email = emails.email LEFT JOIN (SELECT email, '1' AS 'lista_seed_escest' FROM redelocal_usuarios_lista_expresso WHERE nome_lista = 'lista-seed-escest') AS esc ON esc.email = emails.email LEFT JOIN (SELECT email, '1' AS 'lista_seed_geral' FROM redelocal_usuarios_lista_expresso WHERE nome_lista = 'lista-seed-geral') AS ger ON ger.email = emails.email LEFT JOIN (SELECT email, '1' AS 'lista_seed_usuarios' FROM redelocal_usuarios_lista_expresso WHERE nome_lista = 'lista-seed-usuarios') AS usr ON usr.email = emails.email LEFT JOIN (SELECT email, descricao, resolvido FROM redelocal_pendencia_lista_expresso) AS pendencia ON pendencia.email = emails.email $text ORDER BY emails.email; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    /**
     * 
     * @param type $_email
     * @return type igual a zero com erro / diferente de zero correto
     */
    function updateUsuarioLista($_email) {
        $consulta = " select count(email) as cont from `redelocal_usuarios_lista_expresso` WHERE email = '$_email' and conferido is null; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        foreach ($resultado as $value) {
            $test = $value['cont'];
        }
        if ($test != "0") {
            $consulta = " UPDATE `redelocal_usuarios_lista_expresso` SET usuario = '" . $_SESSION['login'] . "', conferido = '" . date("Y-m-d H:i:s") . "' WHERE email = '$_email'; ";
            $resultado = mysqli_query($this->connect(), $consulta);
            return $resultado;
        }
        return 0;
    }

    /**
     * 
     * @param type $_email
     * @return type igual a zero com erro / diferente de zero correto
     */
    function consultaPendenciaLista($_email) {
        $consulta = " SELECT * FROM `redelocal_pendencia_lista_expresso` where email = '$_email'; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }

    /**
     * 
     * @param type $_email
     * @param type $_pendencia
     * @param type $_resolvido
     * @return type resultado alteraçao na base de dados
     */
    function gravaPendencia($_email, $_pendencia, $_resolvido) {
        $consulta = " SELECT count(email) as cont FROM `redelocal_pendencia_lista_expresso` where email = '$_email'; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        foreach ($resultado as $value) {
            $test = $value['cont'];
        }
        if ($test != "0") {
            $consulta = " UPDATE `redelocal_pendencia_lista_expresso` SET `descricao` = '$_pendencia', `usuario` = '" . $_SESSION['login'] . "', `data` = '" . date("Y-m-d H:i:s") . "', `resolvido` = '$_resolvido' WHERE `email` = '$_email'; ";
            $resultado = mysqli_query($this->connect(), $consulta);
            return $resultado;
        } else {
            $consulta = " INSERT INTO `redelocal_pendencia_lista_expresso`(`email`,`descricao`,`usuario`,`data`,`resolvido`) VALUES ('$_email','$_pendencia','" . $_SESSION['login'] . "','" . date("Y-m-d H:i:s") . "','$_resolvido'); ";
            $resultado = mysqli_query($this->connect(), $consulta);
            return $resultado;
        }
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
        $senha = base64_encode($_senha);
        foreach ($resultDados as $dados) {
            if ($dados['cont'] == '0') {
                $consulta_manuCredencial = " INSERT INTO `redelocal_credenciais`(`tipo`,`descricao`,`usuario`,`senha`,`local_alocado`)VALUES('$_tipo','$_descricao','$_usuario','$senha','$_local_alocado'); ";
                $resultado_manuCredencial = mysqli_query($this->connect(), $consulta_manuCredencial);
            } else {
                $consulta_manuCredencial = " UPDATE `redelocal_credenciais` SET `tipo` = '$_tipo', `descricao` = '$_descricao', `usuario` = '$_usuario', `senha` = '$senha', `local_alocado` = '$_local_alocado' WHERE `codigo` = '$_codigo'; ";
                $resultado_manuCredencial = mysqli_query($this->connect(), $consulta_manuCredencial);
            }
            return $resultado_manuCredencial;
        }
    }

}

/**
 * Description of Rotinas Referentes A Descritivo Rede LOCAL
 * 
 * @author tiagoc
 */
class EscolasPG {

    function listaEscolas($_inep = '', $_diretoria = '', $_nome = '', $_cidade = '') {
        $filtro = "";
        if ($_inep != '') {
            $filtro = $filtro . " and e.codigo_mec = '$_inep' ";
        }
        if ($_diretoria != '') {
            $filtro = $filtro . " AND dre.nome_abreviado ilike '%$_diretoria%' ";
        }
        if ($_nome != '') {
            $filtro = $filtro . " AND eo.nome_abreviado ilike '%$_nome%' ";
        }
        if ($_cidade != '') {
            $filtro = $filtro . " AND cid.descricao ilike '%$_cidade%' ";
        }
        $conexao_seednet = new DatabaseSEEDNET();
        $consulta = " SELECT e.cdescola, eo.cdestrutura, e.codigo_mec, dre.nome_abreviado as dre, eo.nome_abreviado as nome_unidade, eo.gps_latitude, eo.gps_longitude, i.logradouro, i.numero, i.complemento, i.cep, i.bairro,  cid.descricao as cidade FROM academico.escola e INNER JOIN administrativo.estrutura_organizacional eo ON e.cdestrutura_organizacional = eo.cdestrutura inner join administrativo.estrutura_organizacional dre ON eo.cdestrutura_pai = dre.cdestrutura inner join public.cidade cid on eo.cdcidade_sede = cid.cdcidade LEFT JOIN administrativo.estrutura_organizacional_imovel eoi ON e.cdestrutura_organizacional = eoi.cdestrutura LEFT JOIN administrativo.imovel i ON eoi.cdimovel = i.cdimovel WHERE eo.cdcategoria = 2 AND e.cdsituacao = 1 and e.cdtipo_administracao = 1 and eo.cdestrutura not in (9999) $filtro order by dre.nome_abreviado asc, eo.nome_abreviado asc;";
        return $conexao_seednet->listConsulta($consulta);
    }

    function listaCodDBSEED($_cod_legado) {
        $conexao_dbseed = new DatabaseDBSEED();
        $consulta = "SELECT cd_estrutura_adm_pk, cd_estrutura_legado FROM public.tb_estrutura_de_para where cd_estrutura_legado = '$_cod_legado';";
        while ($consulta = pg_fetch_assoc($conexao_dbseed->listConsulta($consulta))) {
            return $consulta["cd_estrutura_adm_pk"];
        }
    }

}

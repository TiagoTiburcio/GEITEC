<?php

/**
 * Description of Servidores
 *
 * @author tiagoc
 */
class Servidores extends Database {

    function __construct() {
        
    }

    // retorna lista com todos os usuarios cadastrados
    function listaServidores($_cpf, $_nome, $_setor, $_siglasetor) {
        $conexao_seednet = new DatabaseSEEDNET();
        $query = " SELECT * FROM ( SELECT distinct s.nome as Nome_Servidor, replace(to_char(s.cpf, '000:000:000-00'), ':', '.') as cpf, "
                . " s.pispasep as PIS, e4.sigla as Nivel_4, e3.sigla as Nivel_3, e2.sigla as Nivel_2, e1.sigla as Nivel_1, "
                . " e1.nome_abreviado as Nome_Setor, tv.descricao as Tipo_Vinculo, c.descricao as Cargo, vs.ativo  "
                . " FROM administrativo.servidor as s "
                . " join administrativo.vinculo_servidor as vs on s.cdservidor = vs.cdservidor "
                . " join administrativo.tipo_vinculo as tv on tv.cdtipo_vinculo = vs.cdtipo_vinculo "
                . " join administrativo.cargo as c on c.cdcargo = vs.cdcargo and c.cdcargo_grupo = vs.cdcargo_grupo "
                . " left join administrativo.estrutura_organizacional as e1 on vs.cdlotacao = e1.cdestrutura "
                . " left join administrativo.estrutura_organizacional as e2 on e1.cdestrutura_pai = e2.cdestrutura "
                . " left join administrativo.estrutura_organizacional as e3 on e2.cdestrutura_pai = e3.cdestrutura "
                . " left join administrativo.estrutura_organizacional as e4 on e3.cdestrutura_pai = e4.cdestrutura) as c1 "
                . " where nome_servidor ilike '%$_nome%' and nome_setor ilike '%$_setor%' and cpf ilike '%$_cpf%' "
                . " and (nivel_4 ilike '%$_siglasetor%' or nivel_3 ilike '%$_siglasetor%' or nivel_2 ilike '%$_siglasetor%' or nivel_1 ilike '%$_siglasetor%') "
                . " order by nome_servidor, nivel_4, nivel_3, nivel_2, nivel_1, nome_setor limit 150; ";
        return $conexao_seednet->listConsulta($query);
    }

    // retorna lista com todos os usuarios cadastrados
    function listaExpresso($_usuario, $_nome, $_situacao) {
        $consulta_listaExpresso = " SELECT * FROM sis_geitec.temp_listaexpresso where login like '%$_usuario%' and nome like '%$_nome%' and situacao like '%$_situacao%' limit 50; ";
        $resultado_listaExpresso = mysqli_query($this->connect(), $consulta_listaExpresso);
        return $resultado_listaExpresso;
    }

    function listaEscolas($_inep) {
        $conexao_seednet = new DatabaseSEEDNET();
        $consulta = " SELECT e.cdescola, eo.cdestrutura, e.codigo_mec, eo.nome_abreviado, eo.gps_latitude, eo.gps_longitude, i.logradouro, i.numero, i.complemento, i.cep, i.bairro,  cid.descricao FROM academico.escola e  INNER JOIN administrativo.estrutura_organizacional eo ON e.cdestrutura_organizacional = eo.cdestrutura inner join administrativo.estrutura_organizacional dre ON eo.cdestrutura_pai = dre.cdestrutura inner join public.cidade cid on eo.cdcidade_sede = cid.cdcidade LEFT JOIN administrativo.estrutura_organizacional_imovel eoi ON e.cdestrutura_organizacional = eoi.cdestrutura LEFT JOIN administrativo.imovel i ON eoi.cdimovel = i.cdimovel WHERE eo.cdcategoria = 2 AND e.cdsituacao = 1 and e.cdtipo_administracao = 1 and eo.cdestrutura not in (9999)   and e.codigo_mec in = '$_inep' ; ";
        return $conexao_seednet->listConsulta($consulta);
    }

    function __destruct() {
        
    }

}

<?php
if(!@($conexao = pg_connect("host=172.25.76.67 dbname=seednet port=5432 user=usrappacademico password=12347")))
{
   print "Não foi possível estabelecer uma conexão com o banco de dados.";
}
else
{
     $query = " SELECT distinct s.nome as Nome_Servidor, replace(to_char(s.cpf, '000:000:000-00'), ':', '.') as cpf, "
             . " s.pispasep as PIS, e4.sigla as Nivel_4, e3.sigla as Nivel_3, e2.sigla as Nivel_2, e1.sigla as Nivel_1, "
             . " e1.nome_abreviado as Nome_Setor, tv.descricao as Tipo_Vinculo, c.descricao as Cargo "
             . " FROM administrativo.servidor as s "
             . " join administrativo.vinculo_servidor as vs on s.cdservidor = vs.cdservidor "
             . " join administrativo.tipo_vinculo as tv on tv.cdtipo_vinculo = vs.cdtipo_vinculo "
             . " join administrativo.cargo as c on c.cdcargo = vs.cdcargo and c.cdcargo_grupo = vs.cdcargo_grupo "
             . " left join administrativo.estrutura_organizacional as e1 on vs.cdlotacao = e1.cdestrutura "
             . " left join administrativo.estrutura_organizacional as e2 on e1.cdestrutura_pai = e2.cdestrutura "
             . " left join administrativo.estrutura_organizacional as e3 on e2.cdestrutura_pai = e3.cdestrutura "
             . " left join administrativo.estrutura_organizacional as e4 on e3.cdestrutura_pai = e4.cdestrutura "
             . " where  vs.ativo = '1' "
             . " order by e4.sigla,e3.sigla,e2.sigla,e1.sigla limit 150; ";    
    

     $result = pg_query($conexao, $query);

    /* Retonar um array associativo correspondente a cada linha da tabela */
     while($consulta = pg_fetch_assoc($result))
     { print "Saldo: ".$consulta['cdsituacao'];
     }
    
     pg_close($conexao);
}
?>
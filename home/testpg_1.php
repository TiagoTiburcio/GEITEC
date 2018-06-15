<?php
$nome = array();
$cpf = array();
$i = 0;
if(!@($conexao = pg_connect("host=172.25.76.67 dbname=seednet port=5432 user=usrappacademico password=12347")))
{
   print "Não foi possível estabelecer uma conexão com o banco de dados.";
}
else
{
     $query = " SELECT distinct s.nome , replace(to_char(s.cpf, '000:000:000-00'), ':', '.') as cpf, vs.ativo"
            . " FROM administrativo.servidor as s join administrativo.vinculo_servidor as vs on s.cdservidor = vs.cdservidor "
             . " join administrativo.tipo_vinculo as tv on tv.cdtipo_vinculo = vs.cdtipo_vinculo "
             . " join administrativo.cargo as c on c.cdcargo = vs.cdcargo and c.cdcargo_grupo = vs.cdcargo_grupo left "
             . " join administrativo.estrutura_organizacional as e1 on vs.cdlotacao = e1.cdestrutura "
             . " left join administrativo.estrutura_organizacional as e2 on e1.cdestrutura_pai = e2.cdestrutura "
             . " left join administrativo.estrutura_organizacional as e3 on e2.cdestrutura_pai = e3.cdestrutura "
             . " left join administrativo.estrutura_organizacional as e4 on e3.cdestrutura_pai = e4.cdestrutura "
             . " where s.cpf not in (SELECT distinct s.cpf FROM administrativo.servidor as s join administrativo.vinculo_servidor as vs on s.cdservidor = vs.cdservidor join administrativo.tipo_vinculo as tv on tv.cdtipo_vinculo = vs.cdtipo_vinculo join administrativo.cargo as c on c.cdcargo = vs.cdcargo and c.cdcargo_grupo = vs.cdcargo_grupo left join administrativo.estrutura_organizacional as e1 on vs.cdlotacao = e1.cdestrutura left join administrativo.estrutura_organizacional as e2 on e1.cdestrutura_pai = e2.cdestrutura left join administrativo.estrutura_organizacional as e3 on e2.cdestrutura_pai = e3.cdestrutura left join administrativo.estrutura_organizacional as e4 on e3.cdestrutura_pai = e4.cdestrutura where vs.ativo = '1') ";    
    

     $result = pg_query($conexao, $query);

    /* Retonar um array associativo correspondente a cada linha da tabela */
     while($consulta = pg_fetch_assoc($result))
     { $nome[$i] = $consulta['nome'];
       $cpf[$i] = $consulta['cpf'];
       $i = $i + 1;
     }
    
     pg_close($conexao);
}

$input = preg_quote('TIBURCIO', '~'); // don't forget to quote input string!
$result = preg_grep('~' . $input . '~', $nome);
foreach ($result as $key => $value) {
    echo $key.' !!! '.$value. '!! '. $cpf[$key].'<br/>';    
}

<?php

use function Amp\File\atime;


/**
 * Description of Rotinas Publicas
 * Classse com rotinas comuns a todo o sistema 
 *
 * @author tiagoc
 */
class Unidade
{
    private $codigo;
    private $codigo_siig;
    private $codigo_inep;
    private $descricao;
    private $sigla;    
    private $codigo_unidade_pai;
    private $codigo_tipo_categoria_unidade;
    private $zona_localizacao_unidade;
    private $cidade;
    private $ativo;

    function __construct(
        $_codigo,
        $_codigo_siig,
        $_codigo_inep,
        $_descricao,
        $_sigla,        
        $_codigo_unidade_pai,
        $_codigo_tipo_categoria_unidade,
        $_zona_localizacao_unidade,
        $_cidade,
        $_ativo
    ) {
        $this->codigo = filter_var($_codigo, FILTER_VALIDATE_INT);
        $this->codigo_siig = filter_var($_codigo_siig, FILTER_VALIDATE_INT);
        $this->codigo_inep = filter_var($_codigo_inep, FILTER_SANITIZE_STRING);
        $this->descricao = filter_var($_descricao, FILTER_SANITIZE_STRING);
        $this->sigla = filter_var($_sigla, FILTER_SANITIZE_STRING);        
        $this->codigo_unidade_pai = filter_var($_codigo_unidade_pai, FILTER_SANITIZE_STRING);
        $this->codigo_tipo_categoria_unidade = filter_var($_codigo_tipo_categoria_unidade, FILTER_SANITIZE_STRING);
        $this->zona_localizacao_unidade = filter_var($_zona_localizacao_unidade, FILTER_SANITIZE_STRING);
        $this->cidade = filter_var($_cidade, FILTER_SANITIZE_STRING);
        $this->ativo = filter_var($_ativo, FILTER_VALIDATE_BOOLEAN);
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function novoCodigoUnidade(int $_codigo, int $_codigo_siig):void
    {
        $this->codigo = $_codigo;
        $this->codigo_siig = $_codigo_siig;
    }    
}
/**
 * Description of Rotinas Publicas
 * Classse com rotinas comuns a todo o sistema 
 *
 * @author tiagoc
 */
class UnidadesManut extends Database
{
    private function validaUnidadeExiste(Unidade $unidade) : bool
    {
        if ($unidade->codigo_siig == '0'){
            $unidade = $this->novaUnidade($unidade);
            return false;
        }else{
            foreach ($this->listaUnidades() as $value) {
                if (($value['unidade_codigo'] == $unidade->codigo)){
                    return true;
                }
            } 
        }

    }

    private function novaUnidade(Unidade $unidade):Unidade{
        $consulta = " SELECT (max(codigo) + 1) as novo_codigo, (max(codigo_siig) + 1) as novo_codigo_siig FROM sis_geitec.circuitos_unidades; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        foreach ($resultado as $value) {
            $unidade->novoCodigoUnidade($value['novo_codigo'],$value['novo_codigo_siig']);            
        }
        return $unidade;
    }

    function manUnidade(Unidade $unidade)
    {
        if($this->validaUnidadeExiste($unidade)){
            //update
            $consulta = "  ";
        }else{
            //insert
            $consulta = " UPDATE `sis_geitec`.`servicos_valida` SET `codigo` = '1', `resultado` = '1' WHERE `codigo` = '1'; ";
        }
        $resultado = mysqli_query($this->connect(), $consulta);
        var_dump($resultado);
        return $resultado;
    }
    function listaUnidades($_ativo = NULL, $_tipo_unidade = NULL, $_codigo_unidade = NULL, $_filhas = false)
    {
        /*  Dados consulta Campos
            unidade_codigo 
            unidade_siig
            unidade_inep
            unidade_descricao
            unidade_sigla
            unidade_ut_siig
            dre_unidade
            dre_sigla   
            unidade_cidade
            unidade_tipo_codigo
            unidade_tipo_descricao
            unidade_zona
            ativo
        */
        // var_dump($_ativo);
        // echo '<br>';
        // var_dump($_tipo_unidade);
        // echo '<br>';
        // var_dump($_codigo_unidade);
        // echo '<br>';
        // var_dump($_filhas);
        // echo '<br>';
        if ((is_null($_codigo_unidade)) && (is_null($_ativo)) && (is_null($_tipo_unidade))) {
            $filtro = '';
        } elseif (is_null($_codigo_unidade)) {
            if ((is_null($_ativo)) || (is_null($_tipo_unidade))) {
                $filtro = (is_null($_ativo)) ? "where tu.codigo = '$_tipo_unidade'" : "where cu.ativo = '$_ativo'";
            } else {
                $filtro = "where cu.ativo = '$_ativo' and tu.codigo = '$_tipo_unidade'";
            }
        } elseif (!is_null($_codigo_unidade)) {
            $filtro = ($_filhas) ? "where cu.`codigo_unidade_pai` = '$_codigo_unidade' and cu.ativo = '1'" : "where cu.`codigo_siig` = '$_codigo_unidade'";
        }
        //echo $filtro . '<br>';
        $consulta = " SELECT cu.`codigo` as unidade_codigo, cu.`codigo_siig` as unidade_siig, cu.zona_localizacao_unidade as unidade_zona , cu.`codigo_inep` as unidade_inep, cu.`descricao` as unidade_descricao, cu.`sigla` as unidade_sigla, cu.`codigo_ut_siig` as unidade_ut_siig, cu.`codigo_unidade_pai` as dre_unidade, dre.sigla as dre_sigla, cu.`cidade` as unidade_cidade, cu.`codigo_tipo_categoria_unidade` as unidade_tipo_codigo, tu.`descricao` as unidade_tipo_descricao, cu.`ativo` FROM `sis_geitec`.`circuitos_unidades` as cu join `sis_geitec`.`circuitos_unidades` as dre on cu.codigo_unidade_pai = dre.codigo_siig join `sis_geitec`.`circuito_tipo_unidade` as tu on tu.codigo = cu.`codigo_tipo_categoria_unidade` $filtro ;";
        $resultado = mysqli_query($this->connect(), $consulta);        
        return $resultado;
    }

    function listaTipoUnidade()
    {
        /*  Dados consulta Campos
            codigo 
            descricao            
        */

        $consulta = " SELECT distinctrow ctu.`codigo`, ctu.`descricao` FROM `sis_geitec`.`circuito_tipo_unidade` as ctu";
        $resultado = mysqli_query($this->connect(), $consulta);

        return $resultado;
    }

    function listaDREs()
    {
        /*  Dados consulta Campos
            codigo_siig 
            sigla
            descricao            
        */

        $consulta = " SELECT distinctrow dre.codigo_siig, dre.sigla, dre.descricao FROM `circuitos_unidades` as cu join `circuitos_unidades` as dre on cu.codigo_unidade_pai = dre.codigo_siig where dre.ativo = '1';";
        $resultado = mysqli_query($this->connect(), $consulta);

        return $resultado;
    }

    public function listaCircuitosUnidade($_codigo_unidade)
    {
        /**
         * circuito_codigo,
         * unidade_ut_siig,
         * circuito_data_ativacao,
         * circuito_velocidade,
         * circuito_tipo_servico,
         * circuito_tipo_logradouro,
         * circuito_nome_logradouro,
         * circuito_nome_cidade,
         * circuito_num_imovel,
         * circuito_bairro,
         * circuito_data_ult_ref,
         * unidade_codigo,
         * localizacao_codigo,
         * localizacao_descricao,
         * contrato_codigo,
         * contrato_nome_fornecedor
         */
        $consulta = " SELECT DISTINCT crc.`codigo` AS circuito_codigo, crc.`codigo_unidade` AS unidade_ut_siig, crc.`data_ativacao` AS circuito_data_ativacao, crc.`velocidade` AS circuito_velocidade, crc.`tipo_servico` AS circuito_tipo_servico, crc.`tip_logradouro` AS circuito_tipo_logradouro, crc.`nome_logradouro` AS circuito_nome_logradouro, crc.`nome_cidade` AS circuito_nome_cidade, crc.`num_imovel` AS circuito_num_imovel, crc.`nome_bairro` AS circuito_bairro, crc.`data_ult_ref` AS circuito_data_ult_ref, cu.codigo_siig AS unidade_codigo, cl.codigo AS localizacao_codigo, cl.descricao AS localizacao_descricao, ccont.codigo AS contrato_codigo, ccont.nome_fornecedor AS contrato_nome_fornecedor FROM `circuitos_registro_consumo` AS crc JOIN circuitos_unidades AS cu ON cu.codigo_ut_siig = crc.codigo_unidade JOIN circuitos_localizacao AS cl ON crc.localizacao = cl.codigo JOIN circuitos_contas AS cc ON cc.designacao = crc.codigo JOIN circuitos_contrato AS ccont ON cc.fatura = ccont.codigo WHERE crc.data_ult_ref IS NOT NULL AND cu.codigo_siig = '$_codigo_unidade' order by crc.`data_ult_ref` desc, ccont.nome_fornecedor, crc.`codigo` ;";
        $resultado = mysqli_query($this->connect(), $consulta);
        return $resultado;
    }
}

<?php
include_once '../class/principal.php';
	header("Content-Type: text/html; charset=ISO-8859-1");

	function intGet($campo)
	{
		return isset($_GET[$campo]) ? (int) $_GET[$campo] : 0;
	}
	function retornoForn($id)
	{
		$contas_div = new ImportContasDiversas();		
		$lista_contrato = $contas_div->listaContratos($id);
		$campo = '';
		$i = 0;
		$json = ' [';
		foreach ($lista_contrato as $table) {	
			if($i > 0){
				$json .= ',';	
			}					
			$json .= '{"nome' . $campo . '":"' . $table['contrato'] . '","id' . $campo . '":"' . $table['contrato'] . '"}';
			$i += 1;
		}
		if ($i > 1) {
			$json .= ']';
			return $json;
		} else
			$json .= '{"nome' . $campo . '": "Não Encontrado"}';

		$json .= ']';

		return $json;
	}
	function retornoCont($id)
	{
		$contas_div = new ImportContasDiversas();		
		$lista_contrato = $contas_div->listaContratos($id);
		$campo = '';
		$i = 0;
		$json = ' [';
		foreach ($lista_contrato as $table) {	
			if($i > 0){
				$json .= ',';	
			}					
			$json .= '{"nome' . $campo . '":"' . $table['contrato'] . '","id' . $campo . '":"' . $table['contrato'] . '"}';
			$i += 1;
		}
		if ($i > 1) {
			$json .= ']';
			return $json;
		} else
			$json .= '{"nome' . $campo . '": "Não Encontrado"}';

		$json .= ']';

		return $json;
	}
	$forncad = filter_input(INPUT_GET, 'idfornecedor');
    if (isset($forncad)) {
        echo retornoForn($forncad);
	}
	$contratocad = filter_input(INPUT_GET, 'idcontrato');
	if (isset($contratocad)) {
        echo retornoCont($contratocad);
	}
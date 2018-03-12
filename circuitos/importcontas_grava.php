<?php
$_SESSION['importcontas'] = '';
// DEFINIÇÕES
// Numero de campos de upload
$numeroCampos = 1;
// Tamanho máximo do arquivo (em bytes)
$tamanhoMaximo = 10485760;
// Extensões aceitas
$extensoes = array(".csv", ".txt");
// Caminho para onde o arquivo será enviado
$caminho = "uploads/";
// Substituir arquivo já existente (true = sim; false = nao)
$substituir = false;
$menssagem = '';

for ($i = 0; $i < $numeroCampos; $i++) {
	
	// Informações do arquivo enviado
	$nomeArquivo = $_FILES["arquivo"]["name"][$i];
	$tamanhoArquivo = $_FILES["arquivo"]["size"][$i];
	$nomeTemporario = $_FILES["arquivo"]["tmp_name"][$i];
	
	// Verifica se o arquivo foi colocado no campo
	if (!empty($nomeArquivo)) {
	
		$erro = false;
	
		// Verifica se o tamanho do arquivo é maior que o permitido
		if ($tamanhoArquivo > $tamanhoMaximo) {
			$erro = "O arquivo " . $nomeArquivo . " não deve ultrapassar " . $tamanhoMaximo. " bytes";
		} 
		// Verifica se a extensão está entre as aceitas
		elseif (!in_array(strrchr($nomeArquivo, "."), $extensoes)) {
			$erro = "A extensão do arquivo <b>" . $nomeArquivo . "</b> não é válida";
		} 
		// Verifica se o arquivo existe e se é para substituir
		elseif (file_exists($caminho . $nomeArquivo) and !$substituir) {
			$erro = "O arquivo <b>" . $nomeArquivo . "</b> já existe";
		}
	
		// Se não houver erro
		if (!$erro) {
			// Move o arquivo para o caminho definido
			move_uploaded_file($nomeTemporario, ($caminho . $nomeArquivo));
			// Mensagem de sucesso
			$menssagem = $menssagem . 'O arquivo <b>' .$nomeArquivo. '</b> foi enviado com sucesso. <br />';                         
		} 
		// Se houver erro 
		else {
			// Mensagem de erro
			$menssagem = $menssagem .  $erro . "<br />";
		}
                $_SESSION['importcontas'] = $_SESSION['importcontas'] . ' | ' . $menssagem;  
	}
}
header("Location: abrirarq.php");


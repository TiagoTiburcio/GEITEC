<?php

include_once '../class/principal.php';
$zbxCofre = new ZabbixCofre();
$logArquivos = new LogArquivos();
$log = array();
$consulta_arq = $zbxCofre->listArquivosLog($logArquivos->consUltData());
foreach ($consulta_arq as $table) {
    $arq = $table['value'];
    $data_hora_log = $table['data_hora'];
    $linhas = explode("\n", $arq);
    foreach ($linhas as $key => $value) {
        switch ($key) {
            case 4:
                $usuario_log = $value;
                break;
            case 11:
                $arquivo_log = $value;
                break;
            case 20:
                $acao_log = $value;
                break;
            case 22:
                $cod_acao_log = $value;
                break;
            default:
        }
    }
    $log[] = "('" . trim(str_replace("'", "", str_replace("Access Mask:", "", $cod_acao_log))) . "', '" . $data_hora_log . "', '" . trim(str_replace("'", "", str_replace("Account Name:", "", $usuario_log))) . "', '" . trim(str_replace("\\", '\\', trim(str_replace("Ã­", "i", str_replace("Ãª", "e", str_replace("Ã", "I", str_replace("Ã", "A", str_replace("Ãš", "O", str_replace("Ãº", "u", str_replace("Ã•", "O", str_replace("Âª", "", str_replace("ÃŠ", "E", str_replace("Ã‚", "A", str_replace("Ã³", "o", str_replace("Âº", "", str_replace("Ã”", "O", str_replace("Ã£", "a", str_replace("Ã‡", "C", str_replace("Ãƒ", "A", str_replace("Ãµ", "o", str_replace("Ã“", "O", str_replace("Ã‰", "E", str_replace("Ã¡", "a", str_replace("Ã§", "c", str_replace("Ã©", "e", str_replace("\\", "\\\\", str_replace("'", "", str_replace("Object Name:", "", $arquivo_log)))))))))))))))))))))))))))) . "', '" . trim(str_replace("'", "", str_replace("Accesses:", "", $acao_log))) . "')";
}
$logArquivos->insertImportLogArquivo($log);
header("Location: limpa_log_arquivo.php");

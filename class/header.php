<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta lang="pt-BR">  
        <title>Sistema GEITEC</title>  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/estilo.css">
        <script src="../js/validacampo.js" type="text/javascript"></script>      
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>       
        <?php
        if (!isset($_SESSION['pagina'])) {
            $_SESSION['pagina'] = '';
        }
        $dependencias = $_SESSION['pagina'];
        if ($dependencias == '3') {
            ?>         
            <script src='../fullcalendar/lib/jquery.min.js'></script>
            <script src='../fullcalendar/lib/moment.min.js'></script>
            <script src='../fullcalendar/fullcalendar.js'></script>
            <script src='../fullcalendar/lang/pt-br.js'></script>    
            <script src="../js/calendarioservicos.js" type="text/javascript"></script>
            <link rel='stylesheet' href='../fullcalendar/fullcalendar.css' /> 
        <?php } elseif ($dependencias == '2') { ?>                
            <script src="../js/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src='../fullcalendar/lib/jquery.min.js'></script>
            <script src='../fullcalendar/lib/moment.min.js'></script>
            <script src='../fullcalendar/fullcalendar.js'></script>
            <script src='../fullcalendar/lang/pt-br.js'></script>    
            <script src="../js/calendarioservicos.js" type="text/javascript"></script> 
        <?php } elseif ($dependencias == '') {
            
        } ?>
    </head>
    <body>
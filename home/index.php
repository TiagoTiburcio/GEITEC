<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    if ($usuario->validaSessao('') == 1){
    //Conectando ao banco de dados
   
?>
<!--        <div class="col-xs-6">                        
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-xs-6">              
            <canvas id="primeiroGrafico"></canvas> 
        </div>-->
        <div class="col-xs-6">              
            <iframe src="https://www.google.com/maps/d/embed?mid=1xyYVwo84tvTywKOwNOszGWPmy-8NW8N2&hl=pt-BR" width="100%" height="600"></iframe> 
        </div>
        <div class="col-xs-6">              
            <canvas id="chart-0" style="display: block; width: 800px; height: 600px;" ></canvas> 
        </div>
        
        </div>
        <link rel="stylesheet" type="text/css" href="../css/chart-style.css">
        <script src="../js/Chart.bundle.js"></script>
        <script src="../js/chart-utils.js"></script>
        <script src="../js/charts_area_analyser.js"></script>
        <script src="../js/grafico.js"  type="text/javascript"></script>
        <script>
		var presets = window.chartColors;
		var utils = Samples.utils;
		var inputs = {
			min: 20,
			max: 80,
			count: 8,
			decimals: 2,
			continuity: 1
		};

		function generateData() {
			return utils.numbers(inputs);
		}

		function generateLabels() {
			return utils.months({count: inputs.count});
		}

		utils.srand(42);

		var data = {                   
                       <?php 
                         $circuito =  new Circuitos();
    
    $meses = $circuito->listaMesesContasAno();
    foreach ($meses as $meses_table) {
        $meses_graph[] =  $meses_table['mes'] ; 
    }
   // echo '["' . implode('", "', $meses_graph) . '"]';
   // echo '';
    
    $contratos = $circuito->listaContratosContasAno();
    $contas = $circuito->listaValorContasAno();    
    
    foreach ($contratos as $contratos_table) {
        $contratos_graph[] =  $contratos_table['fatura'] ;        
    }
    $cores = array("red", "orange", "yellow", "green", "blue", "grey", "purple" );
    $ind_cor = "0";
    //echo '["' . implode('", "', $contratos_graph) . '"]';    
   // echo '';
    echo "labels: ";
    echo '["' . implode('", "', $meses_graph) . '"],  datasets:'; 
    foreach ($contratos_graph as $key => $value) { 
        if ($key == 0 ){echo '[';} else {echo ',';}
        echo "{ backgroundColor: utils.transparentize(presets.$cores[$ind_cor]), borderColor: presets.$cores[$ind_cor], data: ";        
        foreach ($meses_graph as $key1 => $value1) {            
            $fat = $value;    $val = '0.00';    $mes = $value1;        
            if ($key1 == 0 ){echo '[';} else {echo ',';}
            foreach ($contas as $contas_table){
                if (($value == $contas_table['fatura']) && ($value1 == $contas_table['mes'])){               
                    $fat = $contas_table['fatura'];    $val = $contas_table['valor_double'];    $mes = $contas_table['mes'];                
                }
            }
            echo  ' ' .number_format($val, 2, '.', '')  ;            
        }
        if ($ind_cor < 6){
                $ind_cor = $ind_cor + 1;
            } else {
                $ind_cor = 0;
        }
        echo "],  hidden: false,  label: '$value',  fill: true} "      ;
    }
    echo ']';
                       ?>
       };

		var options = {
			maintainAspectRatio: false,
			spanGaps: false,
			elements: {
				line: {
					tension: 0.0001
				}
			},
			scales: {
				yAxes: [{
					stacked: true
				}]
			},
			plugins: {
				filler: {
					propagate: false
				}
			}
		};

		var chart1 = new Chart('chart-0', {
			type: 'line',
			data: data,
			options: options
		});		
	</script>           
<?php
include ("../class/footer.php");
    }
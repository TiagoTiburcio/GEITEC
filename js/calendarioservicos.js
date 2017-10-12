/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {	
           	
            //CARREGA CALENDARIO E EVENTOS DO BANCO
            $('#calendario').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                weekNumbers: true,                
                hiddenDays: [ 0, 6 ],
                editable: true,
                eventLimit: true, 
                events: 'eventos.php'
            });	
            //CARREGA CALENDARIO E EVENTOS DO BANCO
            $('#calendario0').fullCalendar({
                header: {
                    left: '',
                    center: '',
                    right: ''
                },
                 height: 690,                
                defaultView: 'basicDay',
                hiddenDays: [ 0, 6 ],
                editable: true,
                eventLimit: true, 
                events: 'eventos_1.php'                
            });	
            
            //CARREGA CALENDARIO E EVENTOS DO BANCO
            $('#calendario1').fullCalendar({
                header: {
                    left: '',
                    center: '',
                    right: ''
                },
                height: 690,                
                defaultView: 'basicDay',
                hiddenDays: [ 0, 6 ],
                editable: true,
                eventLimit: true, 
                events: 'eventos_2.php'
            });	
            //CARREGA CALENDARIO E EVENTOS DO BANCO
            $('#calendario2').fullCalendar({
                header: {
                    left: '',
                    center: '',
                    right: ''
                },
                height: 690,
                defaultView: 'basicDay',
                hiddenDays: [ 0, 6 ],
                editable: true,
                eventLimit: true, 
                events: 'eventos_3.php'
            });	
            //CADASTRA NOVO EVENTO
            $('#novo_evento').submit(function(){
                //serialize() junta todos os dados do form e deixa pronto pra ser enviado pelo ajax
                var dados = jQuery(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cadastrar_evento.php",
                    data: dados,
                    success: function(data)
                    {   
                        if(data == "1"){
                            alert("Cadastrado com sucesso! ");
                            //atualiza a pagina!
                            location.reload();
                        }else{
                            alert("Houve algum problema.. ");
                        }
                    }
                });                
                return false;
            });	
	   }); 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *  @author Tiago Tiburcio
 */

// JavaScript Document
    function validaCadastro(){    
        if (document.cadastro.admin.value === "2" ){        
            alert("ERRO Cadastro - Campo Escola possui Setor Administrativo sem resposta!!!");
            return false;
        } else if (document.cadastro.lte.value === "2" ){
            alert("ERRO Cadastro - Campo Escola possui Laboratório sem resposta!!!");
            return false;
        } else if (document.cadastro.wifi.value === "2" ){
            alert("ERRO Cadastro - Campo Escola possui Redes Wifi sem resposta!!!");
            return false;
        } else if (document.cadastro.diario.value === "2" ){        
            alert("ERRO Cadastro - Campo Escola possui Diário Eletrônico sem resposta!!!");        
            return false;         
        } else {
            return true;
        }
    }
    function mostraSenha(){
        document.getElementById("senha").style.display = "block";        
    }
    function escondeSenha(){
        document.getElementById("senha").style.display = "none";        
    }
    function mostraCadImp(){
        document.getElementById("senha").style.display = "block";        
    }
    function escondeCadImp(){
        document.getElementById("senha").style.display = "none";        
    }
    function testeVlan(){
        if( document.getElementById("vlan").value  == '300'){
            document.getElementById("cadImp").style.display = "block";
        }else{
           document.getElementById("cadImp").style.display = "none"; 
        } 
    }
    
    function validaCadastroPortaSw(){
        if(document.getElementById("limpar").value  == '1'){
            return true;
        } else if((document.getElementById("vlan").value  == '300')&&(document.getElementById("Imp").value  == '0')){           
            alert("ERRO Cadastro - Impressora Não Selecionada!!!");        
            return false;
        }else if ((document.getElementById("vlan").value  == '300')&&(document.getElementById("modImp").value  == '0')) {
            alert("ERRO Cadastro - Modelo Impressora não Selecionado!!!");        
            return false;
        }else{
            return true;
        }
 
        
    }
    
    function mostraOpcaoTela(){
        if( document.getElementById("opcaoTexto").value  === '1'){
            document.getElementById("divTela").style.display = "none";
        } else if ( document.getElementById("opcaoTexto").value  === '0' ) {
            document.getElementById("divTela").style.display = "block";
        }

    }
    
    function mostraTelaPorta(){
        document.getElementById("limpaTela").style.display = "block";        
    }
    function escondeTelaPorta(){
        document.getElementById("limpaTela").style.display = "none";        
    }
    function validaSenha(){
        if(document.renoveSenha.pass.value === "") {
                alert("Digite uma senha!");
                return false;
        } else if(document.renoveSenha.repass.value === "") {
                alert("Digite a Repetição de Senha!");
                return false;
        }else if(document.renoveSenha.pass.value === "12345678" 
                || document.renoveSenha.pass.value === "123456789"
                || document.renoveSenha.pass.value === "1234567890"
                || document.renoveSenha.pass.value === "87654321"
                || document.renoveSenha.pass.value === "abcd1234"
                || document.renoveSenha.pass.value === "00000000" 
                || document.renoveSenha.pass.value === "11111111" 
                || document.renoveSenha.pass.value === "22222222" 
                || document.renoveSenha.pass.value === "33333333" 
                || document.renoveSenha.pass.value === "44444444" 
                || document.renoveSenha.pass.value === "55555555" 
                || document.renoveSenha.pass.value === "66666666" 
                || document.renoveSenha.pass.value === "77777777" 
                || document.renoveSenha.pass.value === "88888888" 
                || document.renoveSenha.pass.value === "99999999") {
                alert("Senha Muito Fraca Altere!");
                return false;
        } else                   
        if (document.renoveSenha.pass.value.length <= 7) {
                alert("Senha n\u00e3o podem ser menores que 8 digitos!");
                return false;
        } else 
        if (document.renoveSenha.pass.value !== document.renoveSenha.repass.value) {
                alert("Senha e Repetção de Senha  s\u00e3o diferentes!");
                return false;
        } else {           
            return true;
        }
    }    
    
    
//valida o CPF digitado
function ValidarCPF(Objcpf) {
    var cpf = Objcpf.value;
    exp = /\.|\-/g;
    cpf = cpf.toString().replace(exp, "");    
    
    if(cpf == '') return true; 
    // Elimina CPFs invalidos conhecidos    
    if (cpf.length != 11 || 
        cpf == "00000000000" || 
        cpf == "11111111111" || 
        cpf == "22222222222" || 
        cpf == "33333333333" || 
        cpf == "44444444444" || 
        cpf == "55555555555" || 
        cpf == "66666666666" || 
        cpf == "77777777777" || 
        cpf == "88888888888" || 
        cpf == "99999999999")
            return true;
    // Valida 1o digito 
    add = 0;    
    for (i=0; i < 9; i ++)       
        add += parseInt(cpf.charAt(i)) * (10 - i);  
        rev = 11 - (add % 11);  
        if (rev == 10 || rev == 11)     
            rev = 0;    
        if (rev != parseInt(cpf.charAt(9)))     
            return true;       
    // Valida 2o digito 
    add = 0;    
    for (i = 0; i < 10; i ++)        
        add += parseInt(cpf.charAt(i)) * (11 - i);  
    rev = 11 - (add % 11);  
    if (rev == 10 || rev == 11) 
        rev = 0;    
    if (rev != parseInt(cpf.charAt(10)))
        return true;       
    return false;
}

function valida_numero() {
   var num = document.getElementById('numero').value;
   if ( isNaN( num ) ) { // isNaN = is not a number
      alert('Não é um número!');
      return false; // bloqueia submissão/envio ao php
   }
   alert('Manda pro php porque é número sim!');
   return true; // prossegue o envio
}

//formata de forma generica os campos
function formataCampo(campo, Mascara, evento) {
    var boleanoMascara;

    var Digitato = evento.keyCode;
    exp = /\-|\.|\/|\(|\)| /g
    campoSoNumeros = campo.value.toString().replace(exp, "");

    var posicaoCampo = 0;
    var NovoValorCampo = "";
    var TamanhoMascara = campoSoNumeros.length;
    ;

    if (Digitato !== 8) { // backspace 
        for (i = 0; i <= TamanhoMascara; i++) {
            boleanoMascara = ((Mascara.charAt(i) === "-") || (Mascara.charAt(i) === ".")
                    || (Mascara.charAt(i) === "/"))
            boleanoMascara = boleanoMascara || ((Mascara.charAt(i) === "(")
                    || (Mascara.charAt(i) === ")") || (Mascara.charAt(i) === " "))
            if (boleanoMascara) {
                NovoValorCampo += Mascara.charAt(i);
                TamanhoMascara++;
            } else {
                NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                posicaoCampo++;
            }
        }
        campo.value = NovoValorCampo;
        return true;
    } else {
        return true;
    }
}

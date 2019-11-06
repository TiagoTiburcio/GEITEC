/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *  @author Tiago Tiburcio
 */

// JavaScript Document
function validaCadastro() {
    if (document.cadastro.admin.value === "2") {
        alert("ERRO Cadastro - Campo Escola possui Setor Administrativo sem resposta!!!");
        return false;
    } else if (document.cadastro.lte.value === "2") {
        alert("ERRO Cadastro - Campo Escola possui Laboratório sem resposta!!!");
        return false;
    } else if (document.cadastro.wifi.value === "2") {
        alert("ERRO Cadastro - Campo Escola possui Redes Wifi sem resposta!!!");
        return false;
    } else if (document.cadastro.diario.value === "2") {
        alert("ERRO Cadastro - Campo Escola possui Diário Eletrônico sem resposta!!!");
        return false;
    } else {
        return true;
    }
}
function mostraSenha() {
    document.getElementById("senha").style.display = "block";
}
function escondeSenha() {
    document.getElementById("senha").style.display = "none";
}
function mostraCadImp() {
    document.getElementById("senha").style.display = "block";
}
function escondeCadImp() {
    document.getElementById("senha").style.display = "none";
}
function testeVlan() {
    if (document.getElementById("vlan").value == '300') {
        document.getElementById("cadImp").style.display = "block";
    } else {
        document.getElementById("cadImp").style.display = "none";
    }
}

function pegaMes() {
    document.getElementById("linkprint").href = './relatorios/contas_analitico.php?periodo=' + document.getElementById("mes").value;
}
function submitFormRelPorTipo() {
    document.getElementById("filtro_diretoria_circuito").submit();
}
function submitFormFornecedor() {
    document.getElementById("filtro_fornecedor").submit();
}
function pegaMesSint() {
    document.getElementById("linkprint").href = './relatorios/contas_sintetico.php?periodo=' + document.getElementById("mes").value + '&fatura=' + document.getElementById("fatura").value;
}
function validaCadastroPortaSw() {
    if ((document.getElementById("vlan").value == '300') && (document.getElementById("Imp").value == '0') && (document.getElementById("limpar").value == '0')) {
        alert("ERRO Cadastro - Impressora Não Selecionada!!!");
        return false;
    } else if ((document.getElementById("vlan").value == '300') && (document.getElementById("modImp").value == '0') && (document.getElementById("limpar").value == '0')) {
        alert("ERRO Cadastro - Modelo Impressora não Selecionado!!!");
        return false;
    } else {
        return true;
    }


}

function mostraOpcaoTela() {
    if (document.getElementById("opcaoTexto").value === '1') {
        document.getElementById("divTela").style.display = "none";
    } else if (document.getElementById("opcaoTexto").value === '0') {
        document.getElementById("divTela").style.display = "block";
    }

}

function mostraTelaPorta() {
    document.getElementById("limpaTela").style.display = "block";
    document.getElementById("limpar").value = '0';
}
function escondeTelaPorta() {
    document.getElementById("limpaTela").style.display = "none";
    document.getElementById("limpar").value = '1';
}
function validaSenha() {
    if (document.renoveSenha.pass.value === "") {
        alert("Digite uma senha!");
        return false;
    } else if (document.renoveSenha.repass.value === "") {
        alert("Digite a Repetição de Senha!");
        return false;
    } else if (document.renoveSenha.pass.value === "12345678"
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

    if (cpf == '')
        return true;
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
    for (i = 0; i < 9; i ++)
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
    if (isNaN(num)) { // isNaN = is not a number
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
//seleciona todos os item campo select
function selecionatudoselect(Item) {
    var selecionados = document.getElementById(Item);
    for (i = 0; i <= selecionados.length - 1; i++) {
        selecionados.options[i].selected = true;
    }

}
//Move dados de campo Select
function move(MenuOrigem, MenuDestino) {
    var arrMenuOrigem = new Array();
    var arrMenuDestino = new Array();
    var arrLookup = new Array();
    var i;
    for (i = 0; i < MenuDestino.options.length; i++) {
        arrLookup[MenuDestino.options[i].text] = MenuDestino.options[i].value;
        arrMenuDestino[i] = MenuDestino.options[i].text;
    }
    var fLength = 0;
    var tLength = arrMenuDestino.length;
    for (i = 0; i < MenuOrigem.options.length; i++) {
        arrLookup[MenuOrigem.options[i].text] = MenuOrigem.options[i].value;
        if (MenuOrigem.options[i].selected && MenuOrigem.options[i].value != "") {
            arrMenuDestino[tLength] = MenuOrigem.options[i].text;
            tLength++;
        } else {
            arrMenuOrigem[fLength] = MenuOrigem.options[i].text;
            fLength++;
        }
    }
    arrMenuOrigem.sort();
    arrMenuDestino.sort();
    MenuOrigem.length = 0;
    MenuDestino.length = 0;
    var c;
    for (c = 0; c < arrMenuOrigem.length; c++) {
        var no = new Option();
        no.value = arrLookup[arrMenuOrigem[c]];
        no.text = arrMenuOrigem[c];
        MenuOrigem[c] = no;
    }
    for (c = 0; c < arrMenuDestino.length; c++) {
        var no = new Option();
        no.value = arrLookup[arrMenuDestino[c]];
        no.text = arrMenuDestino[c];
        MenuDestino[c] = no;
    }
}

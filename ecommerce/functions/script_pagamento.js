const tipoPagamento = document.getElementById("caixaSelecionaTipo"),
btnCartao = document.getElementById("cartao"),
btnBoleto = document.getElementById("boleto"),
btnPaypal = document.getElementById("paypal"),
btnPix = document.getElementById("pix"),
sessaoCartao = document.getElementById("caixaSelecionaCartao"),
sessaoBoleto = document.getElementById("caixaSelecionaBoleto"),
sessaoPaypal = document.getElementById("caixaSelecionaPaypal"),
sessaoPix = document.getElementById("caixaSelecionaPix");

switch (localStorage.getItem("pagamentoNome")){

    case "Cartão" :
        btnCartao.checked = true;
        mostraCartao();
        break

    case "Boleto" :
        btnBoleto.checked = true;
        mostraBoleto();
        break

    case "Paypal" :
        btnPaypal.checked = true;
        mostraPaypal();
        break

    case "Pix" :
        btnPix.checked = true;
        mostraPix();
        break

}

function mostraCartao() {

    sessaoCartao.style.visibility = 'visible';
    sessaoCartao.style.height = 'auto';

    document.getElementById("formaCartao").required = true;
    document.getElementById("numeroCartao").required = true;
    document.getElementById("validadeCartao").required = true;
    document.getElementById("codigoSeguranca").required = true;
    document.getElementById("nomeCartao").required = true;
    document.getElementById("cpfCartao").required = true;
    document.getElementById("telefoneCartao").required = true;
    document.getElementById("dataNascCartao").required = true;
    document.getElementById("parcelas").required = true;

}

function mostraBoleto() {

    sessaoBoleto.style.visibility = 'visible';
    sessaoBoleto.style.height = 'auto';
    document.getElementById("nomeBoleto").required = true;
    document.getElementById("cpfBoleto").required = true;

}

function mostraPaypal() {

    sessaoPaypal.style.visibility = 'visible';
    sessaoPaypal.style.height = 'auto';

}

function mostraPix() {

    sessaoPix.style.visibility = 'visible';
    sessaoPix.style.height = 'auto';
    document.getElementById("cpfPix").required = true;


}

tipoPagamento.addEventListener('change', e =>{

    //Opção Cartão

    if (btnCartao.checked == true) {

        localStorage.setItem("pagamentoNome","Cartão")
        mostraCartao();
        

    } else if (btnCartao.checked == false) {

        sessaoCartao.style.visibility = 'hidden';
        sessaoCartao.style.height = '0';
        
        document.getElementById("formaCartao").required = false;
        document.getElementById("numeroCartao").required = false;
        document.getElementById("validadeCartao").required = false;
        document.getElementById("codigoSeguranca").required = false;
        document.getElementById("nomeCartao").required = false;
        document.getElementById("cpfCartao").required = false;
        document.getElementById("telefoneCartao").required = false;
        document.getElementById("dataNascCartao").required = false;
        document.getElementById("parcelas").required = false;

        document.getElementById("formaCartao").value = "";
        document.getElementById("numeroCartao").value = "";
        document.getElementById("validadeCartao").value = "";
        document.getElementById("codigoSeguranca").value = "";
        document.getElementById("nomeCartao").value = "";
        document.getElementById("cpfCartao").value = "";
        document.getElementById("telefoneCartao").value = "";
        document.getElementById("dataNascCartao").value = "";
        document.getElementById("parcelas").value = "";

    }
    

    //Opção Boleto
    
    if (btnBoleto.checked == true) {

        localStorage.setItem("pagamentoNome","Boleto");
        mostraBoleto();
       

    } else if (btnBoleto.checked == false) {

        sessaoBoleto.style.visibility = 'hidden';
        sessaoBoleto.style.height = '0';
        document.getElementById("nomeBoleto").required = false;
        document.getElementById("cpfBoleto").required = false;

        document.getElementById("nomeBoleto").value = "";
        document.getElementById("cpfBoleto").value = "";

    }


    //Opção Paypal

    if (btnPaypal.checked == true) {

        localStorage.setItem("pagamentoNome","Paypal");
        mostraPaypal();
    
    } else if (btnPaypal.checked == false) {

        sessaoPaypal.style.visibility = 'hidden';
        sessaoPaypal.style.height = '0';

    }


    //Opção Pix

    if (btnPix.checked == true) {

        localStorage.setItem("pagamentoNome","Pix");
        mostraPix();
        
    } else if (btnPix.checked == false) {

        sessaoPix.style.visibility = 'hidden';
        sessaoPix.style.height = '0';
        document.getElementById("cpfPix").required = false;

        document.getElementById("cpfPix").value = "";

    }


})
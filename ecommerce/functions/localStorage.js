//Local Storage do Endereco do Pedido


let ruaPedido = document.getElementById('rua');
let cepPedido = document.getElementById('cep');
let numeroPedido = document.getElementById('numero');
let bairroPedido = document.getElementById('bairro');
let cidadePedido = document.getElementById('cidade');


function salvaEnderecoLocalStorage(){

    let endereco = {
        rua : ruaPedido.value,
        cep : cepPedido.value,
        numero : numeroPedido.value,
        bairro : bairroPedido.value,
        cidade : cidadePedido.value
    }

    localStorage.setItem("endereco" , JSON.stringify(endereco));
    console.log("Endereço salvo no localStorage:", endereco);
}

function preencheEnderecoLocalStorage(){

    let endereco = JSON.parse(localStorage.getItem("endereco"))

    if(endereco){

        ruaPedido.value = endereco.rua;
        cepPedido.value = endereco.cep;
        numeroPedido.value = endereco.numero;
        bairroPedido.value = endereco.bairro;
        cidadePedido.value =  endereco.cidade;

        console.log(btoa(localStorage.getItem("endereco")));
    }

}


//Local Storage das Informações do Pagamento do Pedido


let formaCartao = document.getElementById('formaCartao');
let numeroCartao = document.getElementById('numeroCartao');
let validadeCartao = document.getElementById('validadeCartao');
let codigoSeguranca = document.getElementById('codigoSeguranca');
let cartao = document.getElementById('cartao');
let cpfCartao = document.getElementById('cpfCartao');
let telefoneCartao = document.getElementById('telefoneCartao');
let dataNascCartao = document.getElementById('dataNascCartao');
let parcelas = document.getElementById('parcelas');

let nomeBoleto = document.getElementById('nomeBoleto');
let cpfBoleto = document.getElementById('cpfBoleto');

let pixBoleto = document.getElementById('cpfPix');


function salvaPagamentoLocalStorage(){

    switch(localStorage.getItem("pagamentoNome")){

        case "Cartão" :

            localStorage.removeItem("boleto")
            localStorage.removeItem("pix")

            let cartao = {

                tipo : formaCartao.value,
                numero : numeroCartao.value,
                validade : validadeCartao.value,
                codigo : codigoSeguranca.value,
                nome : cartao.value,
                cpf : cpfCartao.value,
                telefone : telefoneCartao.value,
                dataNasc : dataNascCartao.value,
                parcelas : parcelas.value

            }
        
            localStorage.setItem("cartao" , JSON.stringify(cartao))
            break

        case "Boleto" :

        localStorage.removeItem("cartao")
        localStorage.removeItem("pix")

        let boleto = {

            nome : nomeBoleto.value,
            cpf : cpfBoleto.value
            
        }
    
        localStorage.setItem("boleto" , JSON.stringify(boleto))
        break

        case "Pix" :

        localStorage.removeItem("cartao")
        localStorage.removeItem("boleto")

        let pix = {

            cpf : cpfPix.value
            
        }
    
        localStorage.setItem("pix" , JSON.stringify(pix))
        break

    } 
}

function preenchePagamentoLocalStorage(){

    let cartao = JSON.parse(localStorage.getItem("cartao"))
    let boleto = JSON.parse(localStorage.getItem("boleto"))
    let pix = JSON.parse(localStorage.getItem("pix"))

    switch(localStorage.getItem("pagamentoNome")){

        case "Cartão" :

            console.log(parcelas.value)

            formaCartao.value = cartao.tipo,
            numeroCartao.value = cartao.numero;
            validadeCartao.value = cartao.validade;
            codigoSeguranca.value = cartao.codigo;
            cartao.value = cartao.nome;
            cpfCartao.value = cartao.cpf;
            telefoneCartao.value = cartao.telefone;
            dataNascCartao.value = cartao.dataNasc;
            parcelas.value = cartao.parcelas;

            console.log(btoa(localStorage.getItem("cartao")))

            break

        case "Boleto" :

            nomeBoleto.value = boleto.nome;
            cpfBoleto.value = boleto.cpf;

            console.log(btoa(localStorage.getItem("boleto")))

            break

        case "Pix" :

            cpfPix.value = pix.cpf;

            console.log(btoa(localStorage.getItem("pix")))

            break

    } 


}


//Deletar Local Storage do Pedido

function deletaCamposLocalStorage(){

    localStorage.removeItem("dadosPessoais")
    localStorage.removeItem("endereco")
    localStorage.removeItem("nomePagamento")
    localStorage.removeItem("cartao")
    localStorage.removeItem("boleto")
    localStorage.removeItem("pix")


}

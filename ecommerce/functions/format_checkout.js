function formatarCPF(cpf) {
    cpf = cpf.replace(/\D/g, ''); // Remove caracteres não numéricos
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2'); // Aplica o primeiro ponto
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2'); // Aplica o segundo ponto
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Aplica o traço
    return cpf;
}

function formatarCEP(cep) {
    cep = cep.replace(/\D/g, ''); // Remove caracteres não numéricos
    cep = cep.replace(/(\d{5})(\d)/, '$1-$2'); // Aplica o traço
    return cep;
}

function formatarCelular(celular) {
    celular = celular.replace(/\D/g, ''); // Remove caracteres não numéricos
    celular = celular.replace(/^(\d{2})(\d)/g, '($1) $2'); // Formata o DDD e o primeiro dígito
    celular = celular.replace(/(\d{5})(\d)/, '$1-$2'); // Adiciona o traço
    return celular;
}

function formatarTelefone(telefone) {
    telefone = telefone.replace(/\D/g, ''); // Remove caracteres não numéricos
    telefone = telefone.replace(/^(\d{2})(\d)/g, '($1) $2'); // Formata o DDD e o primeiro dígito
    telefone = telefone.replace(/(\d{4})(\d)/, '$1-$2'); // Adiciona o traço
    return telefone;
}

function formatarNumeroCartao(numeroCartao) {
    numeroCartao = numeroCartao.replace(/\D/g, ''); // Remove caracteres não numéricos
    numeroCartao = numeroCartao.replace(/(\d{4})(\d)/, '$1 $2'); // Aplica o primeiro espaço
    numeroCartao = numeroCartao.replace(/(\d{4})(\d)/, '$1 $2'); // Aplica o segundo espaço
    numeroCartao = numeroCartao.replace(/(\d{4})(\d)/, '$1 $2'); // Aplica o terceiro espaço
    return numeroCartao;
}

function formatarValidadeCartao(validadeCartao) {
    validadeCartao = validadeCartao.replace(/\D/g, ''); // Remove caracteres não numéricos
    validadeCartao = validadeCartao.replace(/(\d{2})(\d)/, '$1/$2'); // Aplica a barra 
    return validadeCartao;
}

// Vincula a formatação aos campos quando o usuário digita
document.addEventListener('DOMContentLoaded', function() {

    let cpfDOM = document.getElementById('cpf');
    let cpfCartaoDOM = document.getElementById('cpfCartao');
    let cpfBoletoDOM = document.getElementById('cpfBoleto');
    let cpfPixDOM = document.getElementById('cpfPix');

    if (cpfDOM){
        cpfDOM.textContent = formatarCPF(cpfDOM.textContent);

        cpfDOM.addEventListener('input', function(e) {
            e.target.value = formatarCPF(e.target.value);
        });
    }

    if (cpfCartaoDOM){

        cpfCartaoDOM.textContent = formatarCPF(cpfCartaoDOM.textContent);

        cpfCartaoDOM.addEventListener('input', function(e) {
            e.target.value = formatarCPF(e.target.value);
        });

    }

    if (cpfBoletoDOM){

        cpfBoletoDOM.textContent = formatarCPF(cpfBoletoDOM.textContent);

        cpfBoletoDOM.addEventListener('input', function(e) {
            e.target.value = formatarCPF(e.target.value);
        });

    } 

    if (cpfPixDOM){

        cpfPixDOM.textContent = formatarCPF(cpfPixDOM.textContent);

        cpfPixDOM.addEventListener('input', function(e) {
            e.target.value = formatarCPF(e.target.value);
        });

    }

    let cepDOM = document.getElementById('cep');

    if (cepDOM){
        cepDOM.textContent = formatarCEP(cepDOM.textContent);

        cepDOM.addEventListener('input', function(e) {
            e.target.value = formatarCEP(e.target.value);
        });
    }

    let celularDOM = document.getElementById('celular');
    let celularCartaoDOM = document.getElementById('celularCartao');

    if(celularDOM){
        celularDOM.textContent = formatarCelular(celularDOM.textContent);

        celularDOM.addEventListener('input', function(e) {
            e.target.value = formatarCelular(e.target.value);
        });
    }

    if(celularCartaoDOM){
        celularCartaoDOM.textContent = formatarCelular(celularCartaoDOM.textContent);

        celularCartaoDOM.addEventListener('input', function(e) {
            e.target.value = formatarCelular(e.target.value);
        });
    }

    let numeroCartaoDOM = document.getElementById('numeroCartao');

    if (numeroCartaoDOM){
        numeroCartaoDOM.textContent = formatarNumeroCartao(numeroCartaoDOM.textContent);
        
        numeroCartaoDOM.addEventListener('input', function(e) {
            e.target.value = formatarNumeroCartao(e.target.value);
        }); 
    }

    let validadeCartaoDOM = document.getElementById('validadeCartao');

    if (validadeCartaoDOM){
        validadeCartaoDOM.textContent = formatarValidadeCartao(validadeCartaoDOM.textContent);
        
        validadeCartaoDOM.addEventListener('input', function(e) {
            e.target.value = formatarValidadeCartao(e.target.value);
        }); 
    }
    
});

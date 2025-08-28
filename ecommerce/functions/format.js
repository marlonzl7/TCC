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

// Vincula a formatação aos campos quando o usuário digita
document.addEventListener('DOMContentLoaded', function() {

    let cpfDOM = document.getElementById('cpf');

    if (cpfDOM){
        cpfDOM.addEventListener('input', function(e) {
            e.target.value = formatarCPF(e.target.value);
        });

        cpfDOM.value = formatarCPF(cpfDOM.value);
    }

    let cepDOM = document.getElementById('cep');

    if (cepDOM){
        cepDOM.addEventListener('input', function(e) {
            e.target.value = formatarCEP(e.target.value);
        });

        cepDOM.value = formatarCEP(cepDOM.value);
    }

    let celularDOM = document.getElementById('celular');

    if(celularDOM){
        celularDOM.addEventListener('input', function(e) {
            console.log(e.target.value)
            e.target.value = formatarCelular(e.target.value);
        });

        celularDOM.value = formatarCelular(celularDOM.value);
    }

    let telefoneDOM = document.getElementById('telefoneFixo')

    if (telefoneDOM){
        telefoneDOM.addEventListener('input', function(e) {
            e.target.value = formatarTelefone(e.target.value);
        });

        telefoneDOM.value = formatarTelefone(telefoneDOM.value);
    }
    
});


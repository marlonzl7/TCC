document.addEventListener("DOMContentLoaded", function() {
    // Verifica e converte o endereço
    const endereco = localStorage.getItem("endereco") ? JSON.parse(localStorage.getItem("endereco")) : null;
    const pagamentoNome = localStorage.getItem("pagamentoNome");
    let pagamento;

    // Verifica e converte o pagamento com base no tipo
    if (pagamentoNome === "Cartão" && localStorage.getItem("cartao")) {
        pagamento = JSON.parse(localStorage.getItem("cartao"));
    } else if (pagamentoNome === "Boleto" && localStorage.getItem("boleto")) {
        pagamento = JSON.parse(localStorage.getItem("boleto"));
    } else if (pagamentoNome === "Pix" && localStorage.getItem("pix")) {
        pagamento = JSON.parse(localStorage.getItem("pix"));
    }

    // logs de depuração para verificar os valores antes do envio
    console.log("Endereço:", endereco);
    console.log("Pagamento Nome:", pagamentoNome);
    console.log("Pagamento:", pagamento);

    // Confirmar que os dados estão definidos antes de fazer o fetch
    if (endereco && pagamento && pagamentoNome) {
        fetch("finalizarCompraController.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `endereco=${encodeURIComponent(JSON.stringify(endereco))}&pagamento=${encodeURIComponent(JSON.stringify(pagamento))}&pagamentoNome=${encodeURIComponent(pagamentoNome)}`
        })
        .then(response => response.text())
        .then(result => {
            console.log("Resultado da requisição:", result);

            // Redirecionamento manual para a página de sucesso
            window.location.href = '../views/compra-realizada.php';
        })
        .catch(error => console.error("Erro:", error));
    } else {
        console.error("Erro: Dados incompletos para finalizar a compra");
    }
});

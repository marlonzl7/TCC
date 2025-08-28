document.addEventListener("DOMContentLoaded", function () {
    // Função para enviar a requisição AJAX
    function enviarRequisicao(acao, id_produto, quantidade = 1) {
      console.log(
        `Ação: ${acao}, Produto ID: ${id_produto}, Quantidade: ${quantidade}`
      );
      fetch("../controllers/carrinhoController.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          acao: acao,
          id_produto: id_produto,
          quantidade: quantidade,
          ajax: 1,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Resposta do servidor:", data);
  
          // Atualiza o HTML dos itens e o total na página do carrinho
          document.getElementById("itensCarrinho").innerHTML = data.itens;
          document.getElementById("total").textContent = data.total;
  
          // Atualiza o total no menu
          document.getElementById("menu-total").textContent = data.menu_total;
  
          adicionarEventosBotoes(); // Re-adiciona os eventos aos novos botões
        })
        .catch((error) => console.error("Erro na requisição:", error));
    }
  
    // Função para adicionar eventos aos botões
    function adicionarEventosBotoes() {
      // Botões para aumentar a quantidade
      document.querySelectorAll(".aumentar").forEach((button) => {
        button.addEventListener("click", function () {
          let produtoRow = this.closest("tr"); // Seleciona a linha do produto
          let id_produto = produtoRow.dataset.produtoId; // Obtém o ID do produto
          let quantidadeAtual = parseInt(
            produtoRow.querySelector(".quantity").textContent
          ); // Quantidade no carrinho
          let quantidadeDisponivel = parseInt(
            produtoRow.dataset.quantidadeDisponivel
          ); // Quantidade no estoque
  
          console.log(
            `Produto ID: ${id_produto}, Quantidade Atual: ${quantidadeAtual}, Quantidade Disponível: ${quantidadeDisponivel}`
          );
  
          // Verifica se ainda pode adicionar
          if (quantidadeAtual < quantidadeDisponivel) {
            enviarRequisicao("aumentar", id_produto);
          } else {
            alert("Quantidade máxima disponível atingida!");
          }
        });
      });
  
      // Botões para diminuir a quantidade
      document.querySelectorAll(".diminuir").forEach((button) => {
        button.addEventListener("click", function () {
          let produtoRow = this.closest("tr");
          let id_produto = produtoRow.dataset.produtoId;
  
          enviarRequisicao("diminuir", id_produto);
        });
      });
  
      // Botões para remover o item
      document.querySelectorAll(".delete").forEach((button) => {
        button.addEventListener("click", function () {
          let produtoRow = this.closest("tr");
          let id_produto = produtoRow.dataset.produtoId;
  
          enviarRequisicao("remover", id_produto);
        });
      });
    }
  
    // Inicializa os eventos dos botões ao carregar a página
    adicionarEventosBotoes();
  });
  
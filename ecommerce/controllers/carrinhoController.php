<?php
require_once '../models/Carrinho.php';

session_start();

if (isset($_SESSION['id_cliente'])) {
    $id_cliente = $_SESSION['id_cliente'];
    $carrinho = new Carrinho($id_cliente);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $acao = $_POST['acao'] ?? null;
        $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT) ?: 1;

        if ($acao && $id_produto) {
            switch ($acao) {
                case 'adicionar':
                    $carrinho->adicionarItem($id_produto, $quantidade);
                    break;
                case 'aumentar':
                    $carrinho->adicionarItem($id_produto, 1);
                    break;
                case 'diminuir':
                    $carrinho->adicionarItem($id_produto, -1);
                    break;
                case 'remover':
                    $carrinho->removerItem($id_produto);
                    break;
            }

            // Se a requisição não é AJAX, redireciona o usuário para o carrinho
            if (!isset($_POST['ajax'])) {
                header("Location: ../views/carrinho.php");
                exit;
            }

            // Caso seja uma requisição AJAX, retorna o HTML atualizado
            $itens = $carrinho->exibirItens();
            $total = $carrinho->calcularTotal();

            ob_start();
            include '../views/carrinhoItens.php';
            $html_itens = ob_get_clean();

            echo json_encode([
                'itens' => $html_itens,
                'total' => number_format($total, 2, ',', '.'),
                'menu_total' => number_format($total, 2, ',', '.')
            ]);
        }
    }
} else {
    // Redireciona para o login se o cliente não estiver logado
    header("Location: ../views/carrinhoAcessoNegado.php");
    exit;
}

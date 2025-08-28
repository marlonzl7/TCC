<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menu.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Produto.php');

if (isset($_GET['pesquisa']) && !empty($_GET['pesquisa'])) {
    $pesquisa = $_GET['pesquisa'];
    $produtos = Produto::buscarTodosProdutos($pesquisa);
} else {
    $produtos = Produto::listarTodosProdutos();
}

?>
    <main>
        <!-- Conteúdo principal desta página -->
        <div class="head">
            <h1>Bem-vindo ao painel administrativo</h1>
            <p>Esta é a página de gerenciamento de produtos.</p>
        </div>
        <div class="container">
            <div class="input-group">
                <div class="links">
                    <a href="../painelAdministrativo/cadastrarProduto.php" class="crud-link">Cadastrar Produto</a>
                    <a href="../painelAdministrativo/cadastrarCategoria.php" class="crud-link">Cadastrar Categoria</a>
                </div>
                <form action="" method="get">
                    <div class="search-container">
                        <input type="search" name="pesquisa" placeholder="Busque por um produto" class="search-input" value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>">
                        <img src="/TCC/ecommerce/assets/images/icons/search-icon.svg" class="search-icon" alt="ícone pesquisa">
                    </div>
                </form>
            </div>
            <div class="table-container">
                <table class="table" id="product-table">
                    <thead>
                        <tr>
                            <th class="table-title">ID</th>
                            <th class="table-title">Nome</th>
                            <th class="table-title">Categoria</th>
                            <th class="table-title">Preço</th>
                            <th class="table-title">Coleção</th>
                            <th class="table-title">Estoque</th>
                            <th class="table-title">Editar</th>
                            <th class="table-title">Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($produtos)) : ?>
                            <?php foreach ($produtos as $produto) : ?>
                                <tr>
                                    <td class="table-content"><?php echo htmlspecialchars($produto['id_produto']) ?></td>
                                    <td class="table-content"><?php echo htmlspecialchars($produto['nome']) ?></td>
                                    <td class="table-content"><?php echo htmlspecialchars($produto['nome_categoria']) ?></td>
                                    <td class="table-content"><?php echo number_format($produto['preco'], 2, ',', '.') ?></td>
                                    <td class="table-content"><?php echo empty($produto['colecao']) ? "--" : htmlspecialchars($produto['colecao']); ?></td>
                                    <td class="table-content"><?php echo htmlspecialchars($produto['qtd_em_estoque']) ?></td>
                                    <form action="./editarProduto.php" method="post">
                                        <input type="hidden" name="id_produto" value="<?php echo htmlspecialchars($produto['id_produto']) ?>">
                                        <td class="table-content">
                                            <button type="submit" class="crud-btn">
                                                <img src="/TCC/ecommerce/admin/assets/images/icons/edit-icon.svg" alt="editar produto">
                                            </button>
                                        </td>
                                    </form>
                                    <form action="../../controllers/removerProdutoController.php" method="post">
                                        <input type="hidden" name="id_produto" value="<?php echo htmlspecialchars($produto['id_produto']) ?>">
                                        <td class="table-content">
                                            <button type="submit" class="crud-btn">
                                                <img src="/TCC/ecommerce/admin/assets/images/icons/delete-icon.svg" alt="remover administrador">
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="table-content">Nenhum produto encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div> <!-- Fechando a div .main-container -->
</body>
</html>

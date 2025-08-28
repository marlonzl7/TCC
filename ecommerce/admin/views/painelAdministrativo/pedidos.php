<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menu.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Pedido.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Cliente.php');

if (isset($_GET['pesquisa']) && !empty($_GET['pesquisa'])) {
    $pesquisa = $_GET['pesquisa'];
    $pedidos = Pedido::buscarPedido($pesquisa);
} else {
    $pedidos = Pedido::listarPedidos();
}

?>
    <main>
        <!-- Conteúdo principal desta página -->
        <div class="head">
            <h1>Bem-vindo ao painel administrativo</h1>
            <p>Esta é a página de gerenciamento de pedidos.</p>
        </div>
        <div class="container">
            <form action="" method="get">
                <div class="search-container">
                    <input type="search" name="pesquisa" placeholder="Busque por um Pedido" id="pesquisa" class="search-input" value="<?php  echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>">
                    <img src="/TCC/ecommerce/assets/images/icons/search-icon.svg" class="search-icon">
                </div>
            </form>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="table-title">ID</th>
                            <th class="table-title">Cliente</th>
                            <th class="table-title">Data</th>
                            <th class="table-title">Situação</th>
                            <th class="table-title">Total</th>
                            <th class="table-title">Editar</th>
                            <th class="table-title">Visualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos)) : ?>
                            <?php foreach ($pedidos as $pedido) : ?>
                                <tr>
                                    <td class="table-content"><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
                                    <td class="table-content"><?php echo htmlspecialchars($pedido['nome_cliente']); ?></td>
                                    <td class="table-content"><?php echo htmlspecialchars($pedido['data_pedido']); ?></td>
                                    <td class="table-content"><?php echo htmlspecialchars($pedido['status']); ?></td>
                                    <td class="table-content"><?php echo number_format($pedido['total'], 2, ',', '.') ?></td>
                                    <form action="../painelAdministrativo/editarPedido.php" method="post">
                                        <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($pedido['id_pedido']); ?>">
                                        <td class="table-content">
                                            <button type="submit" class="crud-btn">
                                                <img src="/TCC/ecommerce/admin/assets/images/icons/edit-icon.svg" alt="editar produto">
                                            </button>
                                        </td>
                                    </form>
                                    <form action="../painelAdministrativo/visualizarPedido.php" method="post">
                                        <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($pedido['id_pedido']); ?>">
                                        <td class="table-content">
                                            <button type="submit" class="crud-btn">
                                                <img src="/TCC/ecommerce/admin/assets/images/icons/view-icon-fill.svg" alt="">
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="table-content">Nenhum pedido encontrado.</td>
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

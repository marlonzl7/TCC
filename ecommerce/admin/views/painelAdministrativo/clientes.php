<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menu.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Cliente.php');

$email = $_SESSION['email'];

if (isset($_GET['pesquisa']) && !empty($_GET['pesquisa'])) {
    $pesquisa = $_GET['pesquisa'];
    $cliente = Cliente::buscarCliente($pesquisa);
} else {
    $cliente = Cliente::listarCliente();
}

?>
<main>
    <!-- Conteúdo principal desta página -->
    <div class="head">
        <h1>Bem-vindo ao painel administrativo</h1>
        <p>Esta é a página de clientes.</p>
    </div>
    <div class="container">
        <form action="" method="get">
            <div class="search-container">
                <input type="search" name="pesquisa" placeholder="Busque por um cliente" id="pesquisa"
                    class="search-input"
                    value="<?php  echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>">
                <img src="/TCC/ecommerce/assets/images/icons/search-icon.svg" class="search-icon" alt="ícone pesquisa">
            </div>
        </form>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="table-title">ID</th>
                        <th class="table-title align">Nome</th>
                        <th class="table-title align">Email</th>
                        <th class="table-title">Editar</th>
                        <th class="table-title">Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cliente)) : ?>
                    <?php foreach ($cliente as $clientes) : ?>
                    <tr>
                        <td class="table-content"><?php echo htmlspecialchars($clientes['id_cliente']) ?></td>
                        <td class="table-content align"><?php echo htmlspecialchars($clientes['nome']) ?></td>
                        <td class="table-content align"><?php echo htmlspecialchars($clientes['email']) ?></td>
                        <form action="../../views/painelAdministrativo/editarCliente.php" method="post">
                            <input type="hidden" name="id_usuario"
                                value="<?php echo htmlspecialchars($clientes['id_usuario']) ?>">
                            <input type="hidden" name="email"
                                value="<?php echo htmlspecialchars($clientes['email']) ?>">
                            <td class="table-content">
                                <button type="submit" class="crud-btn">
                                    <img src="/TCC/ecommerce/admin/assets/images/icons/edit-icon.svg"
                                        alt="editar Osmen">
                                </button>
                            </td>
                        </form>
                        <form action="../../controllers/removerClienteController.php" method="post">
                            <input type="hidden" name="id_usuario"
                                value="<?php echo htmlspecialchars($clientes['id_usuario']) ?>">
                            <input type="hidden" name="id_cliente"
                                value="<?php echo htmlspecialchars($clientes['id_cliente']) ?>">
                            <td class="table-content">
                                <button type="submit" class="crud-btn">
                                    <img src="/TCC/ecommerce/admin/assets/images/icons/delete-icon.svg"
                                        alt="deletar cliente">
                                </button>
                            </td>
                        </form>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="5" class="table-content">Nenhum cliente encontrado.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</div> <!-- Fechando a div .main-container (div do menu) -->
</body>

</html>
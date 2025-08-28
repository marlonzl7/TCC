<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menu.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Administrador.php');

$id_admin = $_SESSION['id_admin'];
$email = $_SESSION['email'];

if (isset($_GET['pesquisa']) && !empty($_GET['pesquisa'])) {
    $pesquisa = $_GET['pesquisa'];
    $administradores = Administrador::buscarAdministrador($pesquisa);
} else {
    $administradores = Administrador::listarAdministradores();
}

?>
    <main>
        <!-- Conteúdo principal desta página -->
        <div class="head">
            <h1>Bem-vindo ao painel administrativo</h1>
            <p>Esta é a página principal do painel.</p>
        </div>
        <div class="container">
            <form action="" method="get">
                <div class="search-container">
                    <input type="search" name="pesquisa" placeholder="Busque por um Administrador" id="pesquisa" class="search-input" value="<?php  echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>">
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
                        <?php if (!empty($administradores)) : ?>
                            <?php foreach ($administradores as $administrador) : ?>
                                <tr>
                                    <td class="table-content"><?php echo htmlspecialchars($administrador['id_admin']) ?></td>
                                    <td class="table-content align"><?php echo htmlspecialchars($administrador['nome']) ?></td>
                                    <td class="table-content align"><?php echo htmlspecialchars($administrador['email']) ?></td>
                                    <form action="../../views/painelAdministrativo/editarAdmin.php" method="post">
                                        <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($administrador['id_admin']) ?>">
                                        <td class="table-content">
                                            <button type="submit" class="crud-btn">
                                                <img src="/TCC/ecommerce/admin/assets/images/icons/edit-icon.svg" alt="editar admin">
                                            </button>
                                        </td>
                                    </form>
                                    <form action="../../controllers/removerAdminController.php" method="post">
                                        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($administrador['id_usuario']) ?>">
                                        <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($administrador['id_admin']) ?>">
                                        <td class="table-content">
                                            <button type="submit" class="crud-btn">
                                                <img src="/TCC/ecommerce/admin/assets/images/icons/delete-icon.svg" alt="deletar admin">
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="table-content">Nenhum administrador encontrado.</td>
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

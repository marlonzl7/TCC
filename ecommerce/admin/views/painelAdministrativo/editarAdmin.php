<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/admin/includes/menuSimples.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/TCC/ecommerce/models/Administrador.php');

$idAdminEditar = filter_input(INPUT_POST, 'id_admin', FILTER_SANITIZE_NUMBER_INT);

if ($idAdminEditar) {
    $informacoesAdmin = Administrador::infoAdministrador($idAdminEditar); // ou $admin->infoAdministrador($idAdminEditar)
} else {
    $informacoesAdmin = null;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TCC/ecommerce/admin/assets/estilo/editar.css">
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
    <title>Document</title>
</head>
<body>
    <main>
        <div class="container">
            <header class="head">
                <h1>Editar Administrador</h1>
                <p>Você só pode editar o nome de Administrador</p>
            </header>
            <form action="/TCC/ecommerce/admin/controllers/editarAdminController.php" method="post">
                <?php if (empty($informacoesAdmin)) : ?>
                    <h3>Administrador não encontrado</h3>
                <?php else : ?>
                    <div class="input-group">
                        <?php foreach ($informacoesAdmin as $info) : ?>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($info['id_admin']); ?>">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" value="<?php echo htmlspecialchars($info['nome']); ?>">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="btn">
                    <button type="submit">Editar</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
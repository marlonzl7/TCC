<?php
require_once '../config/DatabaseConnect.php';
require_once '../models/Produto.php';

$produto = new Produto();
 
// Busca produtos com base nos parâmetros da URL
$pesquisa = $_GET['busca'] ?? '';
$filtro = $_GET['filtro'] ?? '';
$colecao = $_GET['colecao'] ?? '';
$preco = $_GET['selected'] ?? ''; // 'asc' ou 'desc'

$produtos = [];

// Determina qual método chamar baseado nos parâmetros recebidos
if (!empty($colecao)) {
    $produtos = $produto->buscarProdutoPorColecao($colecao, $preco);
} elseif (!empty($filtro)) {
    $produtos = $produto->buscarProdutoPorCategoria($filtro, $preco);
} elseif (!empty($pesquisa)) {
    $produtos = $produto->buscarProduto($pesquisa, $preco);
} else {
    $produtos = $produto->listarProdutos();
}

?>
<?php require_once '../includes/menu.php'; ?>
<head>
    <link rel="stylesheet" href="../assets/estilo/index.css">
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
</head>
    <label for="Select">Ordenar por:</label>
    <select id="Select">
        <option value="">Nenhum</option>
        <option value="desc" <?php echo $preco == 'desc' ? 'selected' : ''; ?>>Maior preço</option>
        <option value="asc" <?php echo $preco == 'asc' ? 'selected' : ''; ?>>Menor preço</option>
    </select>
    <section>
    <?php if (empty($produtos)): ?>
            <h2 class="produtos-indisponiveis">Nenhum produto disponível</h2>
        <?php else: ?>
            <div class="produtos">
                <?php foreach ($produtos as $produto): ?>
                    <a class="produto paginacao" href="../views/infoProduto.php?id=<?php echo htmlspecialchars($produto['id_produto']); ?>">
                        <img src="<?php echo htmlspecialchars($produto['url']); ?>" alt="">
                        <p class="titulo-produto"><?php echo htmlspecialchars($produto['nome']); ?></p>
                        <p class="preco-produto">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        <p class="parcela">em até <span>6x</span> de <span>R$ <?php echo number_format($produto['preco']  / 6, 2, ",", ".");?></span></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <div id="pagination-controls">
        <!-- Controles de paginação -->
    </div>
    </section>
    <?php require_once '../includes/rodape.php'; ?>
</body>
</html>
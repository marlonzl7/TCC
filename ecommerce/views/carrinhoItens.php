<?php foreach ($itens as $item) : ?>
<tr data-produto-id="<?= htmlspecialchars($item['id_produto']) ?>"
    data-quantidade-disponivel="<?= htmlspecialchars($item['qtd_em_estoque']) ?>">
    <td class="product">
        <img src="<?= htmlspecialchars($item['url']) ?>" alt="Imagem do produto" class="product-image">
        <div class="product-desc">
            <p><?= htmlspecialchars($item['nome']) ?></p>
            <p class="categoria"><?= htmlspecialchars($item['nome_categoria']) ?></p>
        </div>
    </td>
    <td class="preco">R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
    <td>
        <div class="quantity-buttons">
            <button class="diminuir">-</button>
            <span class="quantity"><?= htmlspecialchars($item['quantidade']) ?></span>
            <button class="aumentar">+</button>
        </div>
    </td>
    <td>
        <div class="preco">R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></div>
    </td>
    <td>
        <button class="delete">
            <img src="../assets/images/icons/delete-icon.svg" alt="">
        </button>
    </td>
</tr>
<?php endforeach; ?>
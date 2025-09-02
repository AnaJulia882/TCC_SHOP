<?php @include 'shared/header.php'; ?>

<section class="heading">
    <h3>Sua Wishlist</h3>
    <p> <a href="/home">Início</a> / Wishlist </p>
</section>

<section class="wishlist">
    <h1 class="title">Produtos Adicionados</h1>
    <div class="box-container">
        <?php if (!empty($wishlist)): ?>
            <?php foreach ($wishlist as $item): ?>
                <form class="box" method="POST">
                    <!-- Botão para remover da wishlist -->
                    <a href="?delete=<?= $item['id']; ?>" class="fas fa-times" onclick="return confirm('Excluir este item?');"></a>
                    
                    <!-- Link para ver o produto -->
                    <a href="view_page.php?pid=<?= $item['id_produto']; ?>" class="fas fa-eye"></a>
                    
                    <img src="images/<?= htmlspecialchars($item['imagem']); ?>" alt="" class="image">
                    <div class="nome"><?= htmlspecialchars($item['nome']); ?></div>
                    <div class="preco">R$<?= number_format($item['preco'], 2, ',', '.'); ?></div>

                    <!-- Campos ocultos para enviar dados do produto -->
                    <input type="hidden" name="id_produto" value="<?= $item['id_produto']; ?>">
                    <input type="hidden" name="nome_produto" value="<?= htmlspecialchars($item['nome']); ?>">
                    <input type="hidden" name="preco_produto" value="<?= $item['preco']; ?>">
                    <input type="hidden" name="imagem_produto" value="<?= $item['imagem']; ?>">
                    <input type="hidden" name="quantidade_produto" value="1">
                    <input type="hidden" name="id_wishlist" value="<?= $item['id']; ?>">

                    <!-- Botão para adicionar ao carrinho -->
                    <input type="submit" name="adicionar_carrinho" value="Adicionar ao carrinho" class="btn">
                </form>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty">Nenhum item na wishlist</p>
        <?php endif; ?>
    </div>
</section>

<?php @include 'shared/footer.php'; ?>

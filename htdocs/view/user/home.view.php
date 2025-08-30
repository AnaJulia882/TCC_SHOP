<?php @include 'shared/header.php'; ?>

<section class="home">
    <div class="content">
        <h3>Novas Coleções</h3>
    </div>
</section>

<section class="products">
    <h1 class="title">Últimos Produtos</h1>
    <div class="box-container">
        <?php
        // Garante que $produtos sempre exista
        if (isset($produtos) && is_array($produtos) && count($produtos) > 0):
            foreach ($produtos as $produto_atual):
        ?>
        <form action="" method="POST" class="box">
            <a href="/visualizar?id_produto=<?= $produto_atual['id']; ?>" class="fas fa-eye"></a>
            <div class="preco">R$<?= number_format($produto_atual['preco'], 2, ',', '.'); ?></div>
            <img src="/images/<?= htmlspecialchars($produto_atual['imagem']); ?>" alt="<?= htmlspecialchars($produto_atual['nome']); ?>" class="image">
            <div class="nome"><?= htmlspecialchars($produto_atual['nome']); ?></div>
            <input type="number" name="quantidade_produto" value="1" min="1" class="qty">
            <input type="hidden" name="id" value="<?= $produto_atual['id']; ?>">
            <input type="hidden" name="nome" value="<?= htmlspecialchars($produto_atual['nome']); ?>">
            <input type="hidden" name="preco" value="<?= $produto_atual['preco']; ?>">
            <input type="hidden" name="imagem" value="<?= htmlspecialchars($produto_atual['imagem']); ?>">
            <input type="submit" name="adicionar_lista_desejos" value="Adicionar à lista de desejos" class="option-btn">
            <input type="submit" name="adicionar_carrinho" value="Adicionar ao carrinho" class="btn">
        </form>
        <?php
            endforeach;
        else:
            echo '<p class="empty">Nenhum produto adicionado ainda!</p>';
        endif;
        ?>
    </div>

    <div class="more-btn">
        <a href="/shop" class="option-btn">Carregar mais</a>
    </div>
</section>

<section class="home-contato">
    <div class="content">
        <h3>Tem alguma dúvida?</h3>
        <a href="/contato" class="btn">Contate-nos</a>
    </div>
</section>

<?php @include 'shared/footer.php'; ?>

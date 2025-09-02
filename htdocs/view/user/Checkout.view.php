<?php @include 'shared/header.php'; ?>

<section class="heading">
    <h3>Finalizar Pedido</h3>
    <p> <a href="/home">Início</a> / Finalizar Pedido </p>
</section>

<section class="display-order">
    <?php
    $total_geral = 0;
    if ($carrinho_items && $carrinho_items->num_rows > 0):
        while ($item = $carrinho_items->fetch_assoc()):
            $subtotal = $item['preco'] * $item['quantidade'];
            $total_geral += $subtotal;
    ?>
        <p><?= htmlspecialchars($item['nome']); ?> <span>(R$<?= number_format($item['preco'], 2, ',', '.'); ?> x <?= $item['quantidade']; ?>)</span></p>
    <?php endwhile; else: ?>
        <p class="empty">Seu carrinho está vazio</p>
    <?php endif; ?>
    <div class="grand-total">Total geral: <span>R$<?= number_format($total_geral, 2, ',', '.'); ?></span></div>
</section>

<section class="checkout">
    <?php
    if (!empty($mensagens)) {
        foreach ($mensagens as $msg) {
            echo "<div class='message'>{$msg}</div>";
        }
    }
    ?>

    <form action="" method="POST">
        <h3>Faça seu pedido</h3>
        <div class="flex">
            <div class="inputBox"><span>Seu nome:</span><input type="text" name="nome" required></div>
            <div class="inputBox"><span>Telefone:</span><input type="text" name="telefone" required></div>
            <div class="inputBox"><span>Email:</span><input type="email" name="email" required></div>
            <div class="inputBox"><span>Método de pagamento:</span>
                <select name="metodo_pagamento" id="metodo_pagamento" required onchange="mostrarPIX(this.value)">
                    <option value="Pagamento na entrega">Pagamento na entrega</option>
                    <option value="PIX">PIX</option>
                </select>
            </div>
            <div id="pix_qrcode" style="display:none; margin-top:10px;">
                <p>Escaneie o QR code para pagar via PIX:</p>
                <img src="images/qrcode_pix.png" alt="QR Code PIX" style="max-width:200px;">
                <!-- Aqui você pode gerar dinamicamente o QR code se quiser -->
            </div>

            <div class="inputBox"><span>Endereço 1:</span><input type="text" name="endereco1" required></div>
            <div class="inputBox"><span>Endereço 2:</span><input type="text" name="endereco2" required></div>
            <div class="inputBox"><span>Cidade:</span><input type="text" name="cidade" required></div>
            <div class="inputBox"><span>Estado:</span><input type="text" name="estado" required></div>
            <div class="inputBox"><span>País:</span><input type="text" name="pais" required></div>
            <div class="inputBox"><span>CEP:</span><input type="text" name="cep" required></div>
        </div>
        <input type="submit" name="finalizar_pedido" value="Finalizar Pedido" class="btn">
    </form>
</section>

<script>
function mostrarPIX(valor) {
    const pixDiv = document.getElementById('pix_qrcode');
    if (valor === 'PIX') {
        pixDiv.style.display = 'block';
    } else {
        pixDiv.style.display = 'none';
    }
}
</script>

<?php @include 'shared/footer.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
   <meta charset="UTF-8" />
   <title>Pedidos - Painel Admin</title>
   <link rel="stylesheet" href="/css/admin_style.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<?php @include 'shared/admin_header.php'; ?>

<section class="placed-orders">
    <h1 class="title">Pedidos Realizados</h1>
    <div class="box-container">
        <?php if (count($orders) > 0): ?>
            <?php foreach ($orders as $order): ?>
                <div class="box">
                    <p>ID do Usuário: <span><?= $order['id_usuario']; ?></span></p>
                    <p>Data do Pedido: <span><?= $order['data_pedido']; ?></span></p>
                    <p>Nome: <span><?= $order['nome']; ?></span></p>
                    <p>Telefone: <span><?= $order['telefone']; ?></span></p>
                    <p>Email: <span><?= $order['email']; ?></span></p>
                    <p>Endereço: <span><?= $order['endereco']; ?></span></p>
                    <p>Total de Produtos: <span><?= $order['produtos_totais']; ?></span></p>
                    <p>Preço Total: <span>R$<?= $order['preco_total']; ?>,00</span></p>
                    <p>Forma de Pagamento: <span><?= $order['metodo_pagamento']; ?></span></p>

                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                        <select name="update_payment">
                            <option disabled selected><?= $order['status_pagamento']; ?></option>
                            <option value="pendente">Pendente</option>
                            <option value="completo">Concluído</option>
                        </select>
                        <input type="submit" name="update_order" value="Atualizar" class="option-btn">
                        <a href="?delete=<?= $order['id']; ?>" class="delete-btn" onclick="return confirm('Deseja excluir este pedido?');">Excluir</a>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty">Nenhum pedido realizado ainda!</p>
        <?php endif; ?>
    </div>
</section>

<script src="js/admin_script.js"></script>
</body>
</html>

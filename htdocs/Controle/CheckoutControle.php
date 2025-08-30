<?php
@include_once 'config/config.php';
include_once 'modelo/CheckoutModelo.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: /checkout');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$modelo = new CheckoutModelo($conn);
$mensagem = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ordem'])) {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $metodo_pagamento = mysqli_real_escape_string($conn, $_POST['metodo_pagamento']);
    $endereco = mysqli_real_escape_string($conn, 'aptº ' . $_POST['flat'] . ', ' . $_POST['rua'] . ', ' . $_POST['cidade'] . ', ' . $_POST['pais'] . ' - ' . $_POST['pin_code']);
    $data_pedido = date('Y-m-d'); // compatível com coluna DATE

    $carrinho = $modelo->getCarrinhoByUsuario($id_usuario);
    $carrinho_total = 0;
    $produtos = [];

    while ($item = $carrinho->fetch_assoc()) {
        $produtos[] = $item['nome'] . ' (' . $item['quantidade'] . ')';
        $carrinho_total += $item['preco'] * $item['quantidade'];
    }

    $total_produtos = implode(', ', $produtos);

    if ($carrinho_total === 0) {
        $mensagem[] = 'Seu carrinho está vazio!';
    } elseif ($modelo->pedidoExiste($nome, $telefone, $email, $metodo_pagamento, $endereco, $total_produtos, $carrinho_total)) {
        $mensagem[] = 'Pedido já realizado anteriormente!';
    } else {
        $modelo->createPedido($id_usuario, $nome, $telefone, $email, $metodo_pagamento, $endereco, $total_produtos, $carrinho_total, $data_pedido);
        $modelo->limparCarrinho($id_usuario);
        $mensagem[] = 'Pedido realizado com sucesso!';
    }
}

$carrinho_items = $modelo->getCarrinhoByUsuario($id_usuario);
include 'view/user/checkout.view.php';
?>

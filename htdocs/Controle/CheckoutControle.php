<?php
@include_once 'config/config.php';
include_once 'modelo/CheckoutModelo.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /login');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$modelo = new CheckoutModelo($conn);
$mensagens = [];

// Processa o formulário de checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_pedido'])) {

    // Captura os dados do formulário
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $metodo_pagamento = mysqli_real_escape_string($conn, $_POST['metodo_pagamento']);

    // Monta o endereço completo
    $endereco = mysqli_real_escape_string($conn,
        $_POST['endereco1'] . ', ' .
        $_POST['endereco2'] . ', ' .
        $_POST['cidade'] . ', ' .
        $_POST['estado'] . ', ' .
        $_POST['pais'] . ' - ' .
        $_POST['cep']
    );

    // Data do pedido
    $data_pedido = date('Y-m-d');

    // Pega os itens do carrinho
    $carrinho_items = $modelo->getCarrinhoByUsuario($id_usuario);
    $carrinho_total = 0;
    $produtos = [];

    if ($carrinho_items->num_rows === 0) {
        $mensagens[] = 'Seu carrinho está vazio!';
    } else {
        while ($item = $carrinho_items->fetch_assoc()) {
            $produtos[] = $item['nome'] . ' (' . $item['quantidade'] . ')';
            $carrinho_total += $item['preco'] * $item['quantidade'];
        }

        $total_produtos = implode(', ', $produtos);

        // Verifica se o pedido já existe
        if ($modelo->pedidoExiste($nome, $telefone, $email, $metodo_pagamento, $endereco, $total_produtos, $carrinho_total)) {
            $mensagens[] = 'Pedido já realizado anteriormente!';
        } else {
            // Cria o pedido
            $modelo->createPedido($id_usuario, $nome, $telefone, $email, $metodo_pagamento, $endereco, $total_produtos, $carrinho_total, $data_pedido);
            
            // Limpa o carrinho
            $modelo->limparCarrinho($id_usuario);

            $mensagens[] = 'Pedido realizado com sucesso!';

            // Redireciona para página de confirmação (opcional)
            // header('Location: /pedido_concluido');
            // exit;
        }
    }
}

// Recupera novamente os itens do carrinho para exibir
$carrinho_items = $modelo->getCarrinhoByUsuario($id_usuario);

// Inclui a view
include 'view/user/checkout.view.php';
?>

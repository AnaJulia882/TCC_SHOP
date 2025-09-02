<?php
@include_once 'config/config.php';
include_once 'modelo/ModeloLoja.php';
include_once 'modelo/CarrinhoModelo.php';
include_once 'modelo/ModeloWishlist.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario_id = $_SESSION['id_usuario'] ?? null;
$modeloShop = new ModeloShop($conn);
$modeloCarrinho = new ModeloCarrinho($conn);
$modeloWishlist = new ModeloWishlist($conn);
$mensagens = [];

// Adicionar à lista de desejos
if (isset($_POST['adicionar_wishlist'])) {
    if ($usuario_id) {
        $mensagens[] = $modeloWishlist->getWishlistById($usuario_id, $_POST, $modeloCarrinho);
    } else {
        $mensagens[] = 'Faça login para adicionar à lista de desejos.';
    }
}

// Adicionar ao carrinho
if (isset($_POST['adicionar_carrinho'])) {
    if ($usuario_id) {
        $mensagens[] = $modeloCarrinho->adicionarItem($usuario_id, $_POST, $modeloWishlist);
    } else {
        $mensagens[] = 'Faça login para adicionar ao carrinho.';
    }
}

// Busca todos os produtos usando ModeloShop
$produtos = $modeloShop->getAllProdutos();

// Carrega a view da loja
include 'view/user/shop.view.php';
?>

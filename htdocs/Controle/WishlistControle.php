<?php
@include_once 'config/config.php';
@include_once 'modelo/ModeloWishlist.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: /login');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$modelo = new ModeloWishlist($conn);

// Remover item individual
if (isset($_GET['delete'])) {
    $modelo->deleteItem($_GET['delete']);
    header('Location: /wishlist');
    exit;
}

// Remover todos os itens
if (isset($_GET['delete_all'])) {
    $modelo->deleteAllByUsuario($id_usuario);
    header('Location: /wishlist');
    exit;
}

// Adicionar item ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_carrinho'])) {
    $id_produto   = $_POST['id_produto'] ?? null;
    $nome_produto = $_POST['nome_produto'] ?? '';
    $preco        = $_POST['preco_produto'] ?? 0;
    $imagem       = $_POST['imagem_produto'] ?? '';
    $quantidade   = $_POST['quantidade_produto'] ?? 1;
    $id_wishlist  = $_POST['id_wishlist'] ?? null; // opcional se quiser remover da wishlist

    if ($id_usuario && $id_produto) {
        $modelo->adicionarCarrinho($id_usuario, $id_produto, $nome_produto, $preco, $quantidade, $imagem);
        // Remover da wishlist após adicionar ao carrinho
        if ($id_wishlist) {
            $modelo->deleteItem($id_wishlist);
        }
        header('Location: /wishlist');
        exit;
    }
}

// Buscar itens da wishlist
$wishlist = $modelo->getWishlistById($id_usuario);

include 'view/user/wishlist.view.php';
?>

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

if (isset($_GET['delete'])) {
    $modelo->deleteItem($_GET['delete']);
    header('Location: /wishlist');
    exit;
}

if (isset($_GET['delete_all'])) {
    $modelo->deleteAllByUsuario($id_usuario);
    header('Location: /wishlist');
    exit;
}

$wishlist = $modelo->getWishlistById($id_usuario);
include 'view/user/wishlist.view.php';

?>
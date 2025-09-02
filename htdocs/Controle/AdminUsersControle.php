<?php
@include_once 'config/config.php';
include_once 'modelo/AdminUsuarioModelo.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_admin'])) {
    header('Location: /admin-usuarios');
    exit;
}

$modelo = new AdminUsuarioModelo($conn);

if (isset($_GET['delete'])) {
    $modelo->deleteUsuario($_GET['delete']);
    header('Location: /admin-usuarios');
    exit;
}

$usuarios = $modelo->getAllUsuarios();
include 'view/admin/admin_usuarios.view.php';

?>
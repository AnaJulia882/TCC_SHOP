<?php
@include_once 'config/config.php';
include_once 'modelo/AdminContatoModelo.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o admin está logado
if (!isset($_SESSION['id_admin'])) {
    header('Location: /login'); // redireciona para login se não estiver logado
    exit;
}

$modelo = new AdminContatoModelo($conn);

// Excluir mensagem
if (isset($_GET['delete'])) {
    $modelo->deleteMensagem($_GET['delete']);
    header('Location: /admin-contatos');
    exit;
}

// Pega todas as mensagens como array
$mensagens = $modelo->getAllMensagens();

// Inclui a view
include 'view/admin/admin_contatos.view.php';

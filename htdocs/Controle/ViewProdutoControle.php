<?php
// Inclui o arquivo de configuração
@include_once 'config/config.php';
// Inclui o modelo de visualização de produto
include_once 'modelo/ModeloViewProduto.php';

// Inicia a sessão, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /visualizar');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$modelo = new ModeloViewProduto($conn);
$mensagens = [];

$produto = null;

// Obtém produto pelo ID passado na URL
if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];
    $produto = $modelo->getProdutoById($id_produto);
}

// Processa ações do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['adicionar_lista_desejos'])) {
        include 'Controle/wIshlistControle.php';
    }

    if (isset($_POST['adicionar_carrinho'])) {
        include 'Controle/CarrinhoControle.php';
    }
}

// Inclui a view da página de visualização do produto
include 'view/user/view_page.view.php';
?>

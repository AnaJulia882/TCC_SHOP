<?php
@include_once 'config/config.php';
include_once 'modelo/HomeModelo.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_usuario = $_SESSION['id_usuario'] ?? null;
$modelo = new HomeModelo($conn);
$mensagens = [];

// POST: adicionar ao carrinho ou lista de desejos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produto     = $_POST['id'] ?? null;
    $nome_produto   = $_POST['nome'] ?? '';
    $preco_produto  = $_POST['preco'] ?? 0;
    $imagem_produto = $_POST['imagem'] ?? '';
    $quantidade     = $_POST['quantidade_produto'] ?? 1;

    // Adicionar à lista de desejos
    if (isset($_POST['adicionar_lista_desejos'])) {
        if (!$id_usuario) {
            $mensagens[] = 'Faça login para adicionar à lista de desejos.';
        } elseif ($modelo->estaNaListaDesejos($id_usuario, $nome_produto)) {
            $mensagens[] = 'Já adicionado à lista de desejos.';
        } elseif ($modelo->estaNoCarrinho($id_usuario, $nome_produto)) {
            $mensagens[] = 'Já adicionado ao carrinho.';
        } else {
            $modelo->adicionarListaDesejos($id_usuario, $id_produto, $nome_produto, $preco_produto, $imagem_produto);
            $mensagens[] = 'Produto adicionado à lista de desejos.';
        }
    }

    // Adicionar ao carrinho
    if (isset($_POST['adicionar_carrinho'])) {
        if (!$id_usuario) {
            $mensagens[] = 'Faça login para adicionar ao carrinho.';
        } elseif ($modelo->estaNoCarrinho($id_usuario, $nome_produto)) {
            $mensagens[] = 'Já adicionado ao carrinho.';
        } else {
            if ($modelo->estaNaListaDesejos($id_usuario, $nome_produto)) {
                $modelo->removerListaDesejos($id_usuario, $nome_produto);
            }
            $modelo->adicionarCarrinho($id_usuario, $id_produto, $nome_produto, $preco_produto, $quantidade, $imagem_produto);
            $mensagens[] = 'Produto adicionado ao carrinho.';
        }
    }
}

// Buscar produtos recentes
$result = $modelo->obterProdutosRecentes(); // retorna mysqli_result

$produtos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
}

// Inclui a view
include 'view/user/home.view.php';
?>

<?php
@include_once 'config/config.php';
include_once 'modelo/ModeloProduto.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o admin está logado
if (!isset($_SESSION['id_admin'])) {
    header('Location: /login');
    exit;
}

$produtoModelo = new ModeloProduto($conn);
$mensagens = [];

// Adicionar novo produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $preco = floatval(str_replace(',', '.', $_POST['preco']));
    $detalhes = mysqli_real_escape_string($conn, $_POST['detalhes']);
    
    $imagem = $_FILES['imagem']['name'];
    $imagem_tmp = $_FILES['imagem']['tmp_name'];
    $tamanho_imagem = $_FILES['imagem']['size'];
    
    $pasta_imagens = __DIR__ . '/../images/';
    $imagem_nome = time() . '_' . $imagem; // evita sobrescrever imagens
    $caminho_imagem = $pasta_imagens . $imagem_nome;

    if ($produtoModelo->produtoExiste($nome)) {
        $mensagens[] = 'O nome do produto já existe!';
    } else {
        if ($produtoModelo->createProduto($nome, $detalhes, $preco, $imagem_nome)) {
            if ($tamanho_imagem <= 2 * 1024 * 1024) {
                if (move_uploaded_file($imagem_tmp, $caminho_imagem)) {
                    $mensagens[] = 'Produto adicionado com sucesso!';
                } else {
                    $mensagens[] = 'Erro ao mover a imagem!';
                }
            } else {
                $mensagens[] = 'A imagem é muito grande!';
            }
        } else {
            $mensagens[] = 'Erro ao adicionar produto.';
        }
    }
}

// Excluir produto
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $imagem = $produtoModelo->getImagemPorId($id);
    if ($imagem && file_exists(__DIR__ . '/../images/' . $imagem)) {
        unlink(__DIR__ . '/../images/' . $imagem);
    }
    $produtoModelo->deleteProduto($id);
    header('Location: /admin-produtos');
    exit;
}

// Buscar todos os produtos
$result = $produtoModelo->getAll();
$produtos = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row;
    }
}

include 'view/admin/admin_produtos.view.php';
?>

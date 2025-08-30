<?php
@include_once 'config/config.php';
include_once 'modelo/AdminPedidoModelo.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redireciona se não for admin
if (!isset($_SESSION['id_admin'])) {
    header('Location: /login');
    exit;
}

$modelo = new AdminPedidoModelo($conn);
$mensagem = [];

// Atualiza status do pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    $id_pedido = $_POST['order_id'];
    $novo_status = $_POST['update_payment'];
    $modelo->updateStatusPagamento($id_pedido, $novo_status);
    $mensagem[] = 'Status do pagamento atualizado!';
}

// Deleta pedido
if (isset($_GET['delete'])) {
    $modelo->deletePedido($_GET['delete']);
    header('Location: /admin-pedidos');
    exit;
}

// Pega todos os pedidos como array
$resultado = $modelo->getAllPedidos();
$orders = [];
if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $orders[] = $row;
    }
}

include 'view/admin/admin_pedidos.view.php';
?>

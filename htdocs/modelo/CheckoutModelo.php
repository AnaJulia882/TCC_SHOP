<?php
class CheckoutModelo
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Retorna todos os itens do carrinho do usuário
    public function getCarrinhoByUsuario($usuario_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM carrinho WHERE id_usuario = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result(); // sempre retorna mysqli_result
    }

    // Verifica se um pedido igual já existe
    public function pedidoExiste($nome, $telefone, $email, $metodo, $endereco, $produtos, $total)
    {
        $stmt = $this->conn->prepare("SELECT * FROM pedidos WHERE nome = ? AND telefone = ? AND email = ? AND metodo_pagamento = ? AND endereco = ? AND produtos_totais = ? AND preco_total = ?");
        $stmt->bind_param("ssssssi", $nome, $telefone, $email, $metodo, $endereco, $produtos, $total);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result && $result->num_rows > 0);
    }

    // Cria um novo pedido
    public function createPedido($usuario_id, $nome, $telefone, $email, $metodo, $endereco, $produtos, $total, $data_pedido)
    {
        $stmt = $this->conn->prepare("INSERT INTO pedidos (id_usuario, nome, telefone, email, metodo_pagamento, endereco, produtos_totais, preco_total, data_pedido) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssss", $usuario_id, $nome, $telefone, $email, $metodo, $endereco, $produtos, $total, $data_pedido);
        return $stmt->execute();
    }

    // Limpa o carrinho do usuário
    public function limparCarrinho($usuario_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM carrinho WHERE id_usuario = ?");
        $stmt->bind_param("i", $usuario_id);
        return $stmt->execute();
    }
}
?>

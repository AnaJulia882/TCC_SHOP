<?php 
class AdminPedidoModelo {     
    private $conexao;     

    public function __construct($conexao) {         
        $this->conexao = $conexao;     
    }      

    public function getAllPedidos() {         
        return mysqli_query($this->conexao, "SELECT * FROM pedidos");     
    }      

    public function updateStatusPagamento($id, $status) {         
        $stmt = $this->conexao->prepare("UPDATE pedidos SET status_pagamento = ? WHERE id = ?");         
        $stmt->bind_param("si", $status, $id);         
        return $stmt->execute();     
    }      

    public function deletePedido($id) {         
        $stmt = $this->conexao->prepare("DELETE FROM pedidos WHERE id = ?");         
        $stmt->bind_param("i", $id);         
        return $stmt->execute();     
    } 
}  
?>

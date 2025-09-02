<?php
class ModeloWishlist
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Deleta todos os itens do usuário
    public function deleteAllByUsuario($id_usuario)
    {
        return mysqli_query($this->conn, "DELETE FROM wishlist WHERE id_usuario = '$id_usuario'");
    }

    // Deleta um item específico da wishlist
    public function deleteItem($id)
    {
        return mysqli_query($this->conn, "DELETE FROM wishlist WHERE id = '$id'");
    }

    // Retorna todos os itens da wishlist do usuário
    public function getWishlistById($id_usuario)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM wishlist WHERE id_usuario = '$id_usuario'");
        $items = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
        }
        return $items; // sempre retorna array, mesmo que vazio
    }

    // Adiciona um item ao carrinho
    public function adicionarCarrinho($id_usuario, $id_produto, $nome, $preco, $quantidade, $imagem)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO carrinho (id_usuario, id_produto, nome, preco, quantidade, imagem) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("iisdis", $id_usuario, $id_produto, $nome, $preco, $quantidade, $imagem);
        return $stmt->execute();
    }
}

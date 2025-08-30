<?php
class ModeloListaDesejos
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function deleteAllByUsuario($id_usuario)
    {
    return mysqli_query($this->conn, "SELECT * FROM wishlist WHERE id_usuario = '$id_usuario'");
    }

    public function deleteItem($id)
    {
    return mysqli_query($this->conn, "DELETE FROM wishlist WHERE id = '$id'");
    }

    public function getWishlistById($id_usuario)
    {
    return mysqli_query($this->conn, "DELETE FROM wishlist WHERE id_usuario = '$id_usuario'");
    }
}

<?php
class AdminContatoModelo
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllMensagens()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM mensagens ORDER BY id DESC");
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // retorna um array associativo
        } else {
            return []; // retorna array vazio caso não haja resultados
        }
    }

    public function deleteMensagem($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM mensagens WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

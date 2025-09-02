<?php
class ModeloAutenticacao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Busca usuário pelo email
    public function getUsuarioByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

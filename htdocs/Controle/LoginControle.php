<?php
@include_once 'config/config.php';
include_once 'modelo/ModeloAutenticacao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$modelo = new ModeloAutenticacao($conn);
$mensagens = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha']; // senha em texto puro

    // Busca o usuário pelo email
    $usuario = $modelo->getUsuarioByEmail($email);

    // Verifica se o usuário existe e se a senha bate
    if ($usuario && password_verify($senha, $usuario['senha'])) {
    if ($usuario['tipo_usuario'] === 'admin') {
        $_SESSION['id_admin']      = $usuario['id'];
        $_SESSION['nome_usuario']  = $usuario['nome'];    
        $_SESSION['email_usuario'] = $usuario['email'];
        header('Location: /admin-painel');
    } else {
        $_SESSION['id_usuario']    = $usuario['id'];
        $_SESSION['nome_usuario']  = $usuario['nome'];    
        $_SESSION['email_usuario'] = $usuario['email'];
        header('Location: /home');
    }
    exit;
}
}

// Inclui a view de login
include 'view/user/login.view.php';
?>

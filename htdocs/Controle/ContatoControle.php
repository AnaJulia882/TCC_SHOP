<?php

@include_once 'config/config.php';
include_once 'modelo/ContatoModelo.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: /login');
    exit;
}

$id_usuario = $_SESSION['id_usuario']; 
$modelo = new ContatoModelo($conn); 
$mensagens = []; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $nome    = mysqli_real_escape_string($conn, $_POST['nome']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $telefone  = mysqli_real_escape_string($conn, $_POST['telefone']);
    $mensagem = mysqli_real_escape_string($conn, $_POST['mensagem']);

    if ($modelo->mensagemExiste($nome, $email, $telefone, $mensagem)) {
        $mensagens[] = 'Mensagem já enviada anteriormente!';
    } else {
        $modelo->salvarMensagem($id_usuario, $nome, $email, $telefone, $mensagem);
        $mensagens[] = 'Mensagem enviada com sucesso!';
    }
}

include 'view/user/contato.view.php';
?>

<?php
// Inclui o arquivo de configuração
@include_once 'config/config.php';
// Inclui o arquivo do modelo de registro
include_once 'modelo/ModeloRegistro.php';

// Inicia a sessão, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cria instância do modelo de registro
$modelo = new ModeloRegistro($conn);
$mensagens = [];

// Processa o cadastro quando o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $nome      = mysqli_real_escape_string($conn, $_POST['nome']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $senha     = $_POST['senha']; // não precisa escapar
    $conf_senha = $_POST['conf_senha']; // não precisa escapar

    if ($modelo->emailExiste($email)) {
        $mensagens[] = 'Email já cadastrado!';
    } elseif ($senha !== $conf_senha) {
        $mensagens[] = 'As senhas não coincidem!';
    } else {
        // Hash da senha antes de salvar
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $modelo->registrarUsuario($nome, $email, $senha_hash);
        $mensagens[] = 'Conta criada com sucesso!';
        header('Location: /login');
        exit;
    }
}

// Inclui a view de registro
include 'view/user/registro.view.php';
?>

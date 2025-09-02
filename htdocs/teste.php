<?php
$conn = mysqli_connect('localhost', 'root', '', 'shop_db');

if (!$conn) {
    die('Erro ao conectar: ' . mysqli_connect_error());
} else {
    echo 'Conexão OK!';
}
?>
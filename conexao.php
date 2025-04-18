<?php
$host = 'localhost';
$usuario = 'root';
$senha = 'root';
$banco = 'estoque';

// Criar a conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>

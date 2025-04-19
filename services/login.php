<?php
ob_start();
session_start();
include_once 'conexao.php';

// Mostrar todos os erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = trim($_POST['senha']);

    $sql = "SELECT id_usuario, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se encontrou o usuário
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifica a senha usando password_verify
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['id_usuario'] = $user['id_usuario'];

                // Redireciona para o dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Usuário não encontrado!";
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta!";
    }

    $conn->close();
}
?>

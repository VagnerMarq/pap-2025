<?php
ob_start();

session_start();
include_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    $sql = "SELECT id_usuario, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

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

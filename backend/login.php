<?php
session_start();
include 'db_connection.php'; // Arquivo que conecta ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Consulta para verificar usuário
    $sql = "SELECT id_usuario, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifica senha
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            
            // Consulta para buscar empresas associadas
            $sql_empresas = "SELECT id_empresa, nome FROM empresas WHERE id_usuario = ?";
            $stmt = $conn->prepare($sql_empresas);
            $stmt->bind_param("i", $user['id_usuario']);
            $stmt->execute();
            $empresas = $stmt->get_result();
            
            if ($empresas->num_rows == 1) {
                // Se houver apenas uma empresa, loga diretamente
                $empresa = $empresas->fetch_assoc();
                $_SESSION['id_empresa'] = $empresa['id_empresa'];
                header("Location: dashboard.php");
            } else {
                // Se houver mais de uma, redireciona para escolha
                $_SESSION['empresas'] = $empresas->fetch_all(MYSQLI_ASSOC);
                header("Location: escolher_empresa.php");
            }
            exit();
        } else {
            echo "<script>alert('Senha incorreta!'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado!'); window.location.href='index.html';</script>";
    }
}
?>

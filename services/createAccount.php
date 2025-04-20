<?php
session_start();
require_once 'conexao.php';

// Ativa mensagens de erro
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
  $name = trim($_POST['name']);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $empresa = trim($_POST['empresa']);
  $senha = trim($_POST['senha']);

  // Verifica se o email já existe
  $stmtCheck = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
  $stmtCheck->bind_param("s", $email);
  $stmtCheck->execute();
  $stmtCheck->store_result();

  if ($stmtCheck->num_rows > 0) {
    echo "E-mail já cadastrado!";
  } else {
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, empresa, senha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $empresa, $senhaHash);

    if ($stmt->execute()) {
      $_SESSION['id_usuario'] = $stmt->insert_id;
      $_SESSION['nome'] = $name;
      $_SESSION['email'] = $email;
      $_SESSION['empresa'] = $empresa;
      $_SESSION['logado'] = true;

      header("Location: dashboard.php");
      exit();
    } else {
      echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
  }

  $stmtCheck->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Sistema de Gestão de Inventário</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <div class="background">
      <div class="login-container" id="login-container">
        <img src="../assets/images/logo.svg" alt="InvSys" class="logo" />
        <h2>Bem-vindo ao Sistema de Gestão de Inventário</h2>

        <!--<form id="loginForm" onsubmit="return validarLogin(event)" action="login.php" method="POST">-->
        <form id="loginForm" action="createAccount.php" method="POST">
          <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Digite seu email"
              required
            />
            <div class="error-message" id="emailError"></div>
          </div>

          <div class="input-group">
            <i class="fas fa-lock"></i>
            <input
              type="password"
              id="senha"
              name="senha"
              placeholder="Digite sua senha"
              required
            />

            <div class="strength-meter">
              <div id="strengthBar"></div>
            </div>
            <div class="error-message" id="senhaError"></div>
          </div>

          <div class="login-attempts" id="loginAttempts"></div>

          <button type="submit" name="submit" id="loginButton">
            <span>Entrar</span>
            <div class="loading" id="loading"></div>
          </button>
          <p class="forgot-password">
            <a href="services/createAccount.php">Cadastrar-me</a>
          </p>
          <p class="forgot-password">
            <a href="#" onclick="recuperarSenha()">Esqueceu a senha?</a>
          </p>
        </form>
      </div>

      <div class="login-container" id="empresa-container" style="display: none">
        <h2>Selecione sua Empresa</h2>
        <form id="empresaForm" onsubmit="return selecionarEmpresa(event)">
          <div class="input-group">
            <i class="fas fa-building"></i>
            <select id="empresa" name="empresa" required>
              <option value="">Selecione uma empresa...</option>
              <option value="empresa1">Farmácia Principal</option>
              <option value="empresa2">Farmácia Filial</option>
            </select>
          </div>
          <button type="submit">Continuar</button>
        </form>
      </div>
    </div>

    <!--<script src="./assets/js/login.js"></script>-->
  </body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Sistema de Gestão de Inventário</title>
    <link rel="stylesheet" href="./assets/css/login.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <div class="background">
      <div class="login-container" id="login-container">
        <img src="./assets/images/logo.svg" alt="InvSys" class="logo" />
        <h2>Bem-vindo ao Sistema de Gestão de Inventário</h2>

        <!--<form id="loginForm" onsubmit="return validarLogin(event)" action="login.php" method="POST">-->
        <form id="loginForm" action="services/login.php" method="POST">
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
    </div>

    <!--<script src="./assets/js/login.js"></script>-->
  </body>
</html>

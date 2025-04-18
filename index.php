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
        <form id="loginForm" action="login.php" method="POST">
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

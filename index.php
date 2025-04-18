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

        <form id="loginForm" onsubmit="return validarLogin(event)">
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
            <i
              class="fas fa-eye password-toggle"
              onclick="togglePassword()"
            ></i>

            <div class="strength-meter">
              <div id="strengthBar"></div>
            </div>
            <div class="error-message" id="senhaError"></div>
          </div>

          <div class="login-attempts" id="loginAttempts"></div>

          <button type="submit" id="loginButton">
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

    <script>
      // Usuários do sistema (em produção, isso viria do backend)
      const usuarios = [
        {
          email: "admin@pharmasys.com",
          senha: "Admin@123",
          nome: "Administrador",
          empresas: ["empresa1", "empresa2"],
        },
        {
          email: "usuario@pharmasys.com",
          senha: "Usuario@123",
          nome: "Usuário",
          empresas: ["empresa1"],
        },
      ];

      let tentativasLogin = 0;
      const MAX_TENTATIVAS = 3;
      let tempoEspera = 0;

      function validarLogin(event) {
        event.preventDefault();

        const email = document.getElementById("email").value;
        const senha = document.getElementById("senha").value;

        // Resetar mensagens de erro
        document.getElementById("emailError").style.display = "none";
        document.getElementById("senhaError").style.display = "none";

        // Validar email
        if (!validarEmail(email)) {
          mostrarErro("emailError", "Email inválido");
          return false;
        }

        // Validar senha
        if (!validarSenha(senha)) {
          mostrarErro("senhaError", "Senha deve ter no mínimo 8 caracteres");
          return false;
        }

        // Verificar tentativas de login
        if (tentativasLogin >= MAX_TENTATIVAS) {
          if (tempoEspera === 0) {
            tempoEspera = 30;
            const timer = setInterval(() => {
              tempoEspera--;
              document.getElementById(
                "loginAttempts"
              ).textContent = `Aguarde ${tempoEspera} segundos para tentar novamente`;
              if (tempoEspera === 0) {
                clearInterval(timer);
                tentativasLogin = 0;
                document.getElementById("loginButton").disabled = false;
                document.getElementById("loginAttempts").textContent = "";
              }
            }, 1000);
          }
          document.getElementById("loginButton").disabled = true;
          return false;
        }

        // Mostrar loading
        const button = document.getElementById("loginButton");
        const buttonText = button.querySelector("span");
        const loading = document.getElementById("loading");
        buttonText.style.display = "none";
        loading.style.display = "block";
        button.disabled = true;

        // Simular delay de autenticação
        setTimeout(() => {
          const usuario = autenticar(email, senha);
          if (usuario) {
            if (usuario.empresas.length > 1) {
              document.getElementById("login-container").style.display = "none";
              document.getElementById("empresa-container").style.display =
                "block";
            } else {
              window.location.href = "home.html";
            }
          } else {
            tentativasLogin++;
            atualizarTentativas();
            mostrarErro("senhaError", "Email ou senha incorretos");
            buttonText.style.display = "block";
            loading.style.display = "none";
            button.disabled = false;
          }
        }, 1000);

        return false;
      }

      function validarEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
      }

      function validarSenha(senha) {
        return senha.length >= 8;
      }

      function mostrarErro(elementId, mensagem) {
        const elemento = document.getElementById(elementId);
        elemento.textContent = mensagem;
        elemento.style.display = "block";
      }

      function atualizarTentativas() {
        const tentativasRestantes = MAX_TENTATIVAS - tentativasLogin;
        document.getElementById(
          "loginAttempts"
        ).textContent = `Tentativas restantes: ${tentativasRestantes}`;
      }

      function togglePassword() {
        const senhaInput = document.getElementById("senha");
        const toggleIcon = document.querySelector(".password-toggle");

        if (senhaInput.type === "password") {
          senhaInput.type = "text";
          toggleIcon.classList.remove("fa-eye");
          toggleIcon.classList.add("fa-eye-slash");
        } else {
          senhaInput.type = "password";
          toggleIcon.classList.remove("fa-eye-slash");
          toggleIcon.classList.add("fa-eye");
        }
      }

      function medirForcaSenha(senha) {
        let forca = 0;

        // Comprimento mínimo
        if (senha.length >= 8) forca += 25;

        // Letras maiúsculas e minúsculas
        if (/[a-z]/.test(senha) && /[A-Z]/.test(senha)) forca += 25;

        // Números
        if (/\d/.test(senha)) forca += 25;

        // Caracteres especiais
        if (/[^A-Za-z0-9]/.test(senha)) forca += 25;

        return forca;
      }

      document.getElementById("senha").addEventListener("input", function (e) {
        const senha = e.target.value;
        const forca = medirForcaSenha(senha);
        const strengthBar = document.getElementById("strengthBar");

        strengthBar.style.width = `${forca}%`;

        if (forca <= 25) {
          strengthBar.style.backgroundColor = "#dc3545";
        } else if (forca <= 50) {
          strengthBar.style.backgroundColor = "#ffc107";
        } else if (forca <= 75) {
          strengthBar.style.backgroundColor = "#17a2b8";
        } else {
          strengthBar.style.backgroundColor = "#28a745";
        }
      });

      function recuperarSenha() {
        const email = document.getElementById("email").value;
        if (!email) {
          alert("Por favor, digite seu email para recuperar a senha");
          return;
        }

        if (!validarEmail(email)) {
          alert("Por favor, digite um email válido");
          return;
        }

        alert(`Um link de recuperação de senha será enviado para ${email}`);
      }

      function autenticar(email, senha) {
        return usuarios.find((u) => u.email === email && u.senha === senha);
      }

      function selecionarEmpresa(event) {
        event.preventDefault();
        const empresa = document.getElementById("empresa").value;
        if (!empresa) {
          alert("Por favor, selecione uma empresa");
          return false;
        }
        window.location.href = "home.html";
        return false;
      }
    </script>
  </body>
</html>

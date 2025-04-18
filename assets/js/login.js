// Função para validar o login antes de enviar
function validarLogin(event) {
  event.preventDefault(); // Impede o envio tradicional do formulário

  // Obtém os valores do formulário
  const email = document.getElementById('email').value;
  const senha = document.getElementById('senha').value;

  // Cria um objeto FormData com os dados do formulário
  const data = new FormData();
  data.append('email', email);
  data.append('senha', senha);

  // Envia os dados para o login.php via AJAX
  fetch("./login.php", {
    method: "POST",
    body: data
  })
    .then(response => response.json()) // Espera uma resposta em formato JSON
    .then(data => {
      if (data.status === 'success') {
        // Redireciona o usuário conforme a resposta do PHP
        window.location.href = data.redirect;
      } else {
        // Exibe o erro retornado pelo PHP
        alert(data.message);
      }
    })
    .catch(error => {
      console.error('Erro no login:', error);
      alert('Ocorreu um erro. Tente novamente mais tarde.');
    });
}

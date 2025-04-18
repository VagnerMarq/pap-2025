<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movimentações - Sistema de Gestão de Inventário</title>
    <link rel="stylesheet" href="../assets/css/estilo.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <!-- Flatpickr para seleção de data -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
    <style>
      .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
      }

      #toggleAdmin {
        background: #6c757d;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: background-color 0.3s;
      }

      #toggleAdmin:hover {
        background: #5a6268;
      }

      #toggleAdmin.is-admin {
        background: #28a745;
      }

      #toggleAdmin.is-admin:hover {
        background: #218838;
      }
    </style>
  </head>
  <body>
    <header>
      <button class="profile-toggle">
        <i class="fas fa-user-circle"></i>
      </button>
      <div class="search-container">
        <input
          type="text"
          class="search-input"
          placeholder="Pesquisar movimentações..."
        />
        <i class="fas fa-search search-icon"></i>
      </div>
      <div class="header-actions">
        <button class="btn-primary" onclick="abrirModalEntrada()">
          <i class="fas fa-arrow-down"></i> Entrada
        </button>
        <button class="btn-primary" onclick="abrirModalSaida()">
          <i class="fas fa-arrow-up"></i> Saída
        </button>
        <button class="btn-primary" onclick="abrirModalTransferencia()">
          <i class="fas fa-exchange-alt"></i> Transferência
        </button>
      </div>
    </header>

    <?php require_once '../services/header.php' ?>

    <!-- Menu Lateral -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="profile-info">
          <i class="fas fa-user-circle"></i>
          <span>Usuário</span>
        </div>
        <button class="close-sidebar">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="menu-section">
        <h3>GESTÃO DE INVENTÁRIO</h3>
        <a href="produtos.html">
          <i class="fas fa-box"></i>
          <span>Produtos</span>
        </a>
        <a href="armazens.html">
          <i class="fas fa-warehouse"></i>
          <span>Armazéns</span>
        </a>
        <a href="categorias.html">
          <i class="fas fa-tags"></i>
          <span>Categorias</span>
        </a>
        <a href="fornecedores.html">
          <i class="fas fa-industry"></i>
          <span>Fornecedores</span>
        </a>
      </div>

      <div class="menu-section">
        <h3>CONTROLE</h3>
        <a href="movimentacoes.html" class="active">
          <i class="fas fa-exchange-alt"></i>
          <span>Movimentações</span>
        </a>
        <a href="#">
          <i class="fas fa-boxes"></i>
          <span>Inventário</span>
        </a>
      </div>

      <div class="menu-section">
        <h3>RELATÓRIOS</h3>
        <a href="relatorios.html">
          <i class="fas fa-chart-bar"></i>
          <span>Relatórios</span>
        </a>
      </div>

      <div class="menu-section">
        <h3>SISTEMA</h3>
        <a href="#">
          <i class="fas fa-users"></i>
          <span>Usuários</span>
        </a>
        <a href="#">
          <i class="fas fa-cog"></i>
          <span>Configurações</span>
        </a>
        <a href="loginn.html">
          <i class="fas fa-sign-out-alt"></i>
          <span>Sair</span>
        </a>
      </div>
    </aside>

    <main>
      <div class="content">
        <div class="page-header">
          <h1>Movimentações</h1>
        </div>

        <div class="filters">
          <select id="tipoMovimentacao">
            <option value="">Tipo</option>
            <option value="entrada">Entrada</option>
            <option value="saida">Saída</option>
            <option value="transferencia">Transferência</option>
          </select>
          <select id="status">
            <option value="">Status</option>
            <option value="pendente">Pendente</option>
            <option value="concluido">Concluído</option>
            <option value="cancelado">Cancelado</option>
          </select>
          <div class="filter-group">
            <label for="data-inicio">Data Início</label>
            <input
              type="text"
              id="data-inicio"
              class="date-input"
              placeholder="Selecione a data"
            />
          </div>
          <div class="filter-group">
            <label for="data-fim">Data Fim</label>
            <input
              type="text"
              id="data-fim"
              class="date-input"
              placeholder="Selecione a data"
            />
          </div>
        </div>

        <div class="table-container">
          <table class="data-table">
            <thead>
              <tr>
                <th>Data/Hora</th>
                <th>Tipo</th>
                <th>Medicamento</th>
                <th>Quantidade</th>
                <th>Armazém</th>
                <th>Responsável</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <!-- Dados serão inseridos via JavaScript -->
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <!-- Modal Nova Movimentação -->
    <div id="modalNovaMovimentacao" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Nova Movimentação</h2>
          <button
            class="close-modal"
            onclick="closeModal('modalNovaMovimentacao')"
          >
            &times;
          </button>
        </div>
        <form id="formMovimentacao">
          <div class="form-group">
            <label for="tipoModal">Tipo de Movimentação</label>
            <select id="tipoModal" required>
              <option value="entrada">Entrada</option>
              <option value="saida">Saída</option>
              <option value="transferencia">Transferência</option>
            </select>
          </div>
          <div class="form-group">
            <label for="medicamento">Medicamento</label>
            <select id="medicamento" required>
              <option value="">Selecione um medicamento</option>
            </select>
          </div>
          <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" id="quantidade" required min="1" />
          </div>
          <div class="form-group">
            <label for="armazem">Armazém</label>
            <select id="armazem" required>
              <option value="principal">Armazém Principal</option>
              <option value="secundario">Armazém Secundário</option>
            </select>
          </div>
          <div class="form-group">
            <label for="data-movimentacao">Data</label>
            <input
              type="text"
              id="data-movimentacao"
              class="date-input"
              required
            />
          </div>
          <div class="form-group">
            <label for="motivo">Motivo</label>
            <textarea id="motivo" rows="3"></textarea>
          </div>
          <div class="form-actions">
            <button
              type="button"
              class="btn-secondary"
              onclick="closeModal('modalNovaMovimentacao')"
            >
              Cancelar
            </button>
            <button type="submit" class="btn-primary">Salvar</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      // Dados de exemplo
      const movimentacoes = [
        {
          id: 1,
          data: "2025-02-18 15:30",
          tipo: "entrada",
          medicamento: "Dipirona Sódica",
          quantidade: 50,
          armazem: "Armazém Principal",
          responsavel: "João Silva",
          status: "concluido",
        },
        {
          id: 2,
          data: "2025-02-18 14:15",
          tipo: "saida",
          medicamento: "Amoxicilina",
          quantidade: 20,
          armazem: "Armazém Principal",
          responsavel: "Maria Santos",
          status: "pendente",
        },
        {
          id: 3,
          data: "2025-02-18 13:00",
          tipo: "transferencia",
          medicamento: "Rivotril",
          quantidade: 15,
          armazem: "Armazém Secundário",
          responsavel: "Pedro Costa",
          status: "concluido",
        },
      ];

      // Função para formatar data
      function formatarData(data) {
        return new Date(data).toLocaleString("pt-BR");
      }

      // Função para renderizar a tabela
      function renderizarTabela(dados) {
        const tbody = document.querySelector(".data-table tbody");
        tbody.innerHTML = "";

        dados.forEach((mov) => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
                    <td>${formatarData(mov.data)}</td>
                    <td>${formatarTipo(mov.tipo)}</td>
                    <td>${mov.medicamento}</td>
                    <td>${mov.quantidade}</td>
                    <td>${mov.armazem}</td>
                    <td>${mov.responsavel}</td>
                    <td>${formatarStatus(mov.status)}</td>
                    <td class="actions">
                        <button onclick="verDetalhes(${
                          mov.id
                        })" class="btn-icon" title="Ver Detalhes">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="editarMovimentacao(${
                          mov.id
                        })" class="btn-icon" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        ${
                          isAdmin()
                            ? `
                            <button onclick="excluirMovimentacao(${mov.id})" class="btn-icon text-danger" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        `
                            : ""
                        }
                    </td>
                `;
          tbody.appendChild(tr);
        });
      }

      // Função para formatar tipo
      function formatarTipo(tipo) {
        const tipoMap = {
          entrada: "Entrada",
          saida: "Saída",
          transferencia: "Transferência",
        };
        return tipoMap[tipo] || tipo;
      }

      // Função para formatar status
      function formatarStatus(status) {
        const statusMap = {
          pendente: "Pendente",
          concluido: "Concluído",
          cancelado: "Cancelado",
        };
        return statusMap[status] || status;
      }

      // Função para pesquisar movimentações
      function pesquisarMovimentacoes(query) {
        query = query.toLowerCase().trim();
        if (!query) {
          renderizarTabela(movimentacoes);
          return;
        }

        const resultados = movimentacoes.filter(
          (mov) =>
            mov.medicamento.toLowerCase().includes(query) ||
            mov.armazem.toLowerCase().includes(query) ||
            mov.responsavel.toLowerCase().includes(query) ||
            mov.tipo.toLowerCase().includes(query)
        );

        renderizarTabela(resultados);
      }

      // Event listener para pesquisa
      document.querySelector(".search-input").addEventListener("input", (e) => {
        pesquisarMovimentacoes(e.target.value);
      });

      // Controle do menu lateral
      const toggleMenu = () => {
        const sidebar = document.querySelector(".sidebar");
        const main = document.querySelector("main");
        sidebar.classList.toggle("show");
        main.classList.toggle("sidebar-open");
      };

      // Event listeners para menu
      document
        .querySelector(".profile-toggle")
        .addEventListener("click", toggleMenu);
      document
        .querySelector(".close-sidebar")
        .addEventListener("click", toggleMenu);

      // Fechar menu ao clicar fora
      document.addEventListener("click", (e) => {
        const sidebar = document.querySelector(".sidebar");
        const profileToggle = document.querySelector(".profile-toggle");

        if (
          !sidebar.contains(e.target) &&
          !profileToggle.contains(e.target) &&
          sidebar.classList.contains("show")
        ) {
          toggleMenu();
        }
      });

      // Funções do modal
      function showModal(modalId) {
        document.getElementById(modalId).style.display = "flex";
      }

      function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
      }

      // Verificar se o usuário é administrador
      function isAdmin() {
        // Aqui você implementaria a lógica real de verificação de administrador
        // Por exemplo, verificando a sessão do usuário ou token JWT
        return false; // Por enquanto retorna false para simular usuário normal
      }

      // Função para excluir movimentação
      function excluirMovimentacao(id) {
        if (!isAdmin()) {
          alert("Apenas administradores podem excluir movimentações.");
          return;
        }

        if (confirm("Tem certeza que deseja excluir esta movimentação?")) {
          // Aqui você implementaria a lógica para excluir a movimentação
          console.log("Excluindo movimentação:", id);

          // Exemplo de remoção do item da lista
          const index = movimentacoes.findIndex((mov) => mov.id === id);
          if (index !== -1) {
            movimentacoes.splice(index, 1);
            renderizarTabela(movimentacoes);
            alert("Movimentação excluída com sucesso!");
          }
        }
      }

      // Inicializar o estado do botão ao carregar a página
      window.addEventListener("load", () => {
        renderizarTabela(movimentacoes);

        // Evento de pesquisa
        const searchInput = document.querySelector(".search-input");
        searchInput.addEventListener("input", pesquisarMovimentacoes);

        // Eventos de filtro de data
        const dataInputs = document.querySelectorAll(".date-input");
        dataInputs.forEach((input) => {
          input.addEventListener("change", aplicarFiltros);
        });

        // Eventos de select
        const selects = document.querySelectorAll("select");
        selects.forEach((select) => {
          select.addEventListener("change", aplicarFiltros);
        });

        // Inicialização do Flatpickr para os campos de data
        flatpickr(".date-input", {
          locale: "pt",
          dateFormat: "Y-m-d",
          allowInput: true,
        });
      });

      // Função para aplicar filtros
      function aplicarFiltros() {
        const dataInicio = document.getElementById("data-inicio").value;
        const dataFim = document.getElementById("data-fim").value;
        const tipo = document.getElementById("tipoMovimentacao").value;
        const status = document.getElementById("status").value;
        const termoPesquisa = document
          .querySelector(".search-input")
          .value.toLowerCase();

        let dadosFiltrados = movimentacoes.filter((mov) => {
          let passouFiltro = true;

          // Filtro de data início
          if (dataInicio) {
            const dataMovimentacao = new Date(mov.data);
            const dataInicioFiltro = new Date(dataInicio);
            dataInicioFiltro.setHours(0, 0, 0, 0);
            if (dataMovimentacao < dataInicioFiltro) {
              passouFiltro = false;
            }
          }

          // Filtro de data fim
          if (dataFim) {
            const dataMovimentacao = new Date(mov.data);
            const dataFimFiltro = new Date(dataFim);
            dataFimFiltro.setHours(23, 59, 59, 999);
            if (dataMovimentacao > dataFimFiltro) {
              passouFiltro = false;
            }
          }

          // Filtro de tipo
          if (tipo && mov.tipo !== tipo) {
            passouFiltro = false;
          }

          // Filtro de status
          if (status && mov.status !== status) {
            passouFiltro = false;
          }

          // Filtro de pesquisa
          if (termoPesquisa) {
            const termos = [
              mov.medicamento.toLowerCase(),
              mov.armazem.toLowerCase(),
              mov.responsavel.toLowerCase(),
              mov.tipo.toLowerCase(),
            ];
            if (!termos.some((termo) => termo.includes(termoPesquisa))) {
              passouFiltro = false;
            }
          }

          return passouFiltro;
        });

        renderizarTabela(dadosFiltrados);
      }
    </script>
  </body>
</html>

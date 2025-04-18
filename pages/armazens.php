<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestão de Armazéns - Sistema de Gestão de Inventário</title>
    <link rel="stylesheet" href="../assets/css/estilo.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
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
          placeholder="Pesquisar armazéns..."
        />
        <i class="fas fa-search search-icon"></i>
      </div>
      <button class="btn-primary" onclick="abrirModalNovoArmazem()">
        <i class="fas fa-plus"></i> Novo Armazém
      </button>
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
        <a href="produtos.php">
          <i class="fas fa-box"></i>
          <span>Produtos</span>
        </a>
        <a href="#">
          <i class="fas fa-tags"></i>
          <span>Categorias</span>
        </a>
        <a href="fornecedores.php">
          <i class="fas fa-industry"></i>
          <span>Fornecedores</span>
        </a>
      </div>

      <div class="menu-section">
        <h3>CONTROLE</h3>
        <a href="movimentacoes.php">
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
        <a href="relatorios.php">
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
        <a href="../index.php">
          <i class="fas fa-sign-out-alt"></i>
          <span>Sair</span>
        </a>
      </div>
    </aside>

    <main>
      <div class="content">
        <div class="page-header">
          <h1>Gestão de Armazéns e Localizações</h1>
        </div>

        <div class="grid-container">
          <!-- Cards de Armazéns -->
          <div class="warehouse-grid" id="warehouseGrid">
            <!-- Será preenchido via JavaScript -->
          </div>
        </div>
      </div>

      <!-- Modal Novo Armazém -->
      <div id="modalNovoArmazem" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Novo Armazém</h2>
            <button
              class="close-modal"
              onclick="closeModal('modalNovoArmazem')"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <form id="formArmazem">
              <div class="form-row">
                <div class="form-group">
                  <label for="codigo">Código</label>
                  <input type="text" id="codigo" required />
                </div>
                <div class="form-group">
                  <label for="nome">Nome</label>
                  <input type="text" id="nome" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="endereco">Endereço</label>
                  <input type="text" id="endereco" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="capacidade">Capacidade (m³)</label>
                  <input type="number" id="capacidade" required />
                </div>
                <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <select id="tipo" required>
                    <option value="">Selecione...</option>
                    <option value="geral">Armazém Geral</option>
                    <option value="refrigerado">Refrigerado</option>
                    <option value="seguranca">Alta Segurança</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" rows="3"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              class="btn-secondary"
              onclick="closeModal('modalNovoArmazem')"
            >
              Cancelar
            </button>
            <button class="btn-primary" onclick="salvarArmazem()">
              Salvar
            </button>
          </div>
        </div>
      </div>

      <!-- Modal Detalhes do Armazém -->
      <div id="modalDetalhesArmazem" class="modal">
        <div class="modal-content modal-lg">
          <div class="modal-header">
            <h2>Detalhes do Armazém</h2>
            <button
              class="close-modal"
              onclick="closeModal('modalDetalhesArmazem')"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="tabs">
              <button class="tab-btn active" onclick="trocarTab('info')">
                Informações
              </button>
              <button class="tab-btn" onclick="trocarTab('estoque')">
                Estoque
              </button>
              <button class="tab-btn" onclick="trocarTab('localizacoes')">
                Localizações
              </button>
            </div>
            <div id="tabInfo" class="tab-content active">
              <!-- Será preenchido via JavaScript -->
            </div>
            <div id="tabEstoque" class="tab-content">
              <div class="table-container">
                <table>
                  <thead>
                    <tr>
                      <th>Código</th>
                      <th>Produto</th>
                      <th>Quantidade</th>
                      <th>Localização</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="tabelaEstoque">
                    <!-- Será preenchido via JavaScript -->
                  </tbody>
                </table>
              </div>
            </div>
            <div id="tabLocalizacoes" class="tab-content">
              <button
                class="btn-primary mb-3"
                onclick="abrirModalNovaLocalizacao()"
              >
                <i class="fas fa-plus"></i> Nova Localização
              </button>
              <div class="locations-grid" id="gridLocalizacoes">
                <!-- Será preenchido via JavaScript -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <script>
      // Dados de exemplo
      const armazens = [
        {
          id: 1,
          codigo: "ARM001",
          nome: "Armazém Principal",
          endereco: "Rua Principal, 123",
          capacidade: 1000,
          tipo: "geral",
          ocupacao: 65,
          localizacoes: [
            { id: 1, codigo: "A01", descricao: "Prateleira A1", ocupacao: 80 },
            { id: 2, codigo: "A02", descricao: "Prateleira A2", ocupacao: 45 },
            { id: 3, codigo: "B01", descricao: "Prateleira B1", ocupacao: 70 },
          ],
        },
      ];

      function renderizarArmazens() {
        const grid = document.getElementById("warehouseGrid");
        grid.innerHTML = "";

        armazens.forEach((armazem) => {
          const card = document.createElement("div");
          card.className = "warehouse-card";
          card.innerHTML = `
                    <div class="warehouse-header">
                        <h3>${armazem.nome}</h3>
                        <span class="warehouse-code">${armazem.codigo}</span>
                    </div>
                    <div class="warehouse-body">
                        <div class="warehouse-info">
                            <p><i class="fas fa-map-marker-alt"></i> ${armazem.endereco}</p>
                            <p><i class="fas fa-warehouse"></i> ${armazem.tipo}</p>
                        </div>
                        <div class="warehouse-stats">
                            <div class="stat">
                                <span class="stat-label">Ocupação</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: ${armazem.ocupacao}%"></div>
                                </div>
                                <span class="stat-value">${armazem.ocupacao}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="warehouse-footer">
                        <button class="btn-icon" onclick="verDetalhes(${armazem.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="editarArmazem(${armazem.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon" onclick="excluirArmazem(${armazem.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
          grid.appendChild(card);
        });
      }

      function trocarTab(tab) {
        document
          .querySelectorAll(".tab-btn")
          .forEach((btn) => btn.classList.remove("active"));
        document
          .querySelectorAll(".tab-content")
          .forEach((content) => content.classList.remove("active"));

        document
          .querySelector(`[onclick="trocarTab('${tab}')"]`)
          .classList.add("active");
        document
          .getElementById(`tab${tab.charAt(0).toUpperCase() + tab.slice(1)}`)
          .classList.add("active");
      }

      function verDetalhes(id) {
        const armazem = armazens.find((a) => a.id === id);
        if (armazem) {
          document.getElementById("tabInfo").innerHTML = `
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Código:</label>
                            <span>${armazem.codigo}</span>
                        </div>
                        <div class="info-item">
                            <label>Nome:</label>
                            <span>${armazem.nome}</span>
                        </div>
                        <div class="info-item">
                            <label>Endereço:</label>
                            <span>${armazem.endereco}</span>
                        </div>
                        <div class="info-item">
                            <label>Tipo:</label>
                            <span>${armazem.tipo}</span>
                        </div>
                        <div class="info-item">
                            <label>Capacidade:</label>
                            <span>${armazem.capacidade} m³</span>
                        </div>
                        <div class="info-item">
                            <label>Ocupação:</label>
                            <span>${armazem.ocupacao}%</span>
                        </div>
                    </div>
                `;

          renderizarLocalizacoes(armazem.localizacoes);
          showModal("modalDetalhesArmazem");
        }
      }

      function renderizarLocalizacoes(localizacoes) {
        const grid = document.getElementById("gridLocalizacoes");
        grid.innerHTML = "";

        localizacoes.forEach((loc) => {
          const card = document.createElement("div");
          card.className = "location-card";
          card.innerHTML = `
                    <div class="location-header">
                        <h4>${loc.codigo}</h4>
                        <span class="location-ocupation">${loc.ocupacao}%</span>
                    </div>
                    <div class="location-body">
                        <p>${loc.descricao}</p>
                        <div class="progress-bar">
                            <div class="progress" style="width: ${loc.ocupacao}%"></div>
                        </div>
                    </div>
                `;
          grid.appendChild(card);
        });
      }

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

      function abrirModalNovoArmazem() {
        document.getElementById("formArmazem").reset();
        showModal("modalNovoArmazem");
      }

      function salvarArmazem() {
        // Implementar salvamento
        closeModal("modalNovoArmazem");
        renderizarArmazens();
      }

      function editarArmazem(id) {
        // Implementar edição
      }

      function excluirArmazem(id) {
        if (confirm("Tem certeza que deseja excluir este armazém?")) {
          // Implementar exclusão
        }
      }

      // Event listeners
      document
        .querySelector(".profile-toggle")
        .addEventListener("click", toggleMenu);
      document
        .querySelector(".close-sidebar")
        .addEventListener("click", toggleMenu);

      // Inicialização
      document.addEventListener("DOMContentLoaded", () => {
        renderizarArmazens();
      });
    </script>
  </body>
</html>

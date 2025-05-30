<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestão de Fornecedores - Sistema de Gestão de Inventário</title>
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
          placeholder="Pesquisar fornecedores..."
        />
        <i class="fas fa-search search-icon"></i>
      </div>
      <button class="btn-primary" onclick="abrirModalNovoFornecedor()">
        <i class="fas fa-plus"></i> Novo Fornecedor
      </button>
    </header>

    <?php require_once '../services/header.php' ?>

    <!-- Menu Lateral -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="profile-info">
          <a href="../services/dashboard.php">
            <i class="fas fa-user-circle"></i>
            <span>Usuário</span>
          </a>
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
          <h1>Gestão de Fornecedores</h1>
        </div>

        <div class="filters mb-4">
          <div class="filter-group">
            <label>Status:</label>
            <select id="filterStatus">
              <option value="">Todos</option>
              <option value="ativo">Ativo</option>
              <option value="inativo">Inativo</option>
            </select>
          </div>
          <div class="filter-group">
            <label>Categoria:</label>
            <select id="filterCategoria">
              <option value="">Todas</option>
            </select>
          </div>
        </div>

        <div class="grid-container">
          <div class="suppliers-grid" id="fornecedoresGrid">
            <!-- Será preenchido via JavaScript -->
          </div>
        </div>
      </div>

      <!-- Modal Novo/Editar Fornecedor -->
      <div id="modalFornecedor" class="modal">
        <div class="modal-content modal-lg">
          <div class="modal-header">
            <h2 id="modalTitle">Novo Fornecedor</h2>
            <button class="close-modal" onclick="closeModal('modalFornecedor')">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <form id="formFornecedor">
              <div class="form-row">
                <div class="form-group">
                  <label for="codigo">Código</label>
                  <input type="text" id="codigo" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="email">E-mail</label>
                  <input type="email" id="email" required />
                </div>
                <div class="form-group">
                  <label for="telefone">Telefone</label>
                  <input type="tel" id="telefone" required />
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
                  <label for="categorias">Categorias de Produtos</label>
                  <select id="categorias" multiple>
                    <!-- Será preenchido via JavaScript -->
                  </select>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select id="status" required>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
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
              onclick="closeModal('modalFornecedor')"
            >
              Cancelar
            </button>
            <button class="btn-primary" onclick="salvarFornecedor()">
              Salvar
            </button>
          </div>
        </div>
      </div>

      <!-- Modal Detalhes do Fornecedor -->
      <div id="modalDetalhes" class="modal">
        <div class="modal-content modal-lg">
          <div class="modal-header">
            <h2>Detalhes do Fornecedor</h2>
            <button class="close-modal" onclick="closeModal('modalDetalhes')">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="tabs">
              <button class="tab-btn active" onclick="trocarTab('info')">
                Informações
              </button>
              <button class="tab-btn" onclick="trocarTab('produtos')">
                Produtos
              </button>
              <button class="tab-btn" onclick="trocarTab('historico')">
                Histórico
              </button>
            </div>
            <div id="tabInfo" class="tab-content active">
              <!-- Será preenchido via JavaScript -->
            </div>
            <div id="tabProdutos" class="tab-content">
              <div class="table-container">
                <table>
                  <thead>
                    <tr>
                      <th>Código</th>
                      <th>Produto</th>
                      <th>Última Compra</th>
                      <th>Preço Médio</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="tabelaProdutos">
                    <!-- Será preenchido via JavaScript -->
                  </tbody>
                </table>
              </div>
            </div>
            <div id="tabHistorico" class="tab-content">
              <div class="timeline">
                <!-- Será preenchido via JavaScript -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <script>
      // Dados de exemplo
      const fornecedores = [
        {
          id: 1,
          codigo: "FOR001",
          email: "contato@exemplo.com",
          telefone: "(11) 1234-5678",
          endereco: "Rua Exemplo, 123",
          status: "ativo",
          categorias: ["Eletrônicos", "Informática"],
          observacoes: "Fornecedor principal de equipamentos eletrônicos",
        },
      ];

      function renderizarFornecedores() {
        const grid = document.getElementById("fornecedoresGrid");
        grid.innerHTML = "";

        fornecedores.forEach((fornecedor) => {
          const card = document.createElement("div");
          card.className = "supplier-card";
          card.innerHTML = `
                    <div class="supplier-header">
                        <h3>Código: ${fornecedor.codigo}</h3>
                        <span class="badge ${fornecedor.status}">${
            fornecedor.status
          }</span>
                    </div>
                    <div class="supplier-body">
                        <div class="supplier-info">
                            <p><i class="fas fa-envelope"></i> ${
                              fornecedor.email
                            }</p>
                            <p><i class="fas fa-phone"></i> ${
                              fornecedor.telefone
                            }</p>
                            <p><i class="fas fa-map-marker-alt"></i> ${
                              fornecedor.endereco
                            }</p>
                            <p><i class="fas fa-tag"></i> ${fornecedor.categorias.join(
                              ", "
                            )}</p>
                        </div>
                    </div>
                    <div class="supplier-footer">
                        <button class="btn-icon" onclick="verDetalhes(${
                          fornecedor.id
                        })">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="editarFornecedor(${
                          fornecedor.id
                        })">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon" onclick="excluirFornecedor(${
                          fornecedor.id
                        })">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
          grid.appendChild(card);
        });
      }

      function formatarData(data) {
        return new Date(data).toLocaleDateString("pt-BR");
      }

      function formatarMoeda(valor) {
        return valor.toLocaleString("pt-BR", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2,
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

      function abrirModalNovoFornecedor() {
        document.getElementById("modalTitle").textContent = "Novo Fornecedor";
        document.getElementById("formFornecedor").reset();
        showModal("modalFornecedor");
      }

      function verDetalhes(id) {
        const fornecedor = fornecedores.find((f) => f.id === id);
        if (fornecedor) {
          document.getElementById("tabInfo").innerHTML = `
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Razão Social:</label>
                            <span>${fornecedor.razaoSocial}</span>
                        </div>
                        <div class="info-item">
                            <label>Nome Fantasia:</label>
                            <span>${fornecedor.nomeFantasia || "-"}</span>
                        </div>
                        <div class="info-item">
                            <label>CNPJ:</label>
                            <span>${fornecedor.cnpj}</span>
                        </div>
                        <div class="info-item">
                            <label>E-mail:</label>
                            <span>${fornecedor.email}</span>
                        </div>
                        <div class="info-item">
                            <label>Telefone:</label>
                            <span>${fornecedor.telefone}</span>
                        </div>
                        <div class="info-item">
                            <label>Status:</label>
                            <span class="badge ${fornecedor.status}">${
            fornecedor.status
          }</span>
                        </div>
                    </div>
                `;
          showModal("modalDetalhes");
        }
      }

      function editarFornecedor(id) {
        const fornecedor = fornecedores.find((f) => f.id === id);
        if (fornecedor) {
          document.getElementById("modalTitle").textContent =
            "Editar Fornecedor";
          // Preencher formulário com dados do fornecedor
          showModal("modalFornecedor");
        }
      }

      function excluirFornecedor(id) {
        if (confirm("Tem certeza que deseja excluir este fornecedor?")) {
          // Implementar exclusão
        }
      }

      function salvarFornecedor() {
        // Implementar salvamento
        closeModal("modalFornecedor");
        renderizarFornecedores();
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
        renderizarFornecedores();
      });
    </script>
  </body>
</html>

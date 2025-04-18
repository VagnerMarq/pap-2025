<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestão de Produtos - Sistema de Gestão de Inventário</title>
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
          placeholder="Pesquisar produtos..."
        />
        <i class="fas fa-search search-icon"></i>
      </div>
      <button class="btn-primary" onclick="abrirModalNovoProduto()">
        <i class="fas fa-plus"></i> Novo Produto
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
          <h1>Gestão de Produtos</h1>
        </div>

        <div class="filters">
          <div class="filter-group">
            <label>Status:</label>
            <select id="filterStatus">
              <option value="">Todos</option>
              <option value="disponivel">Disponível</option>
              <option value="baixo_estoque">Baixo Estoque</option>
              <option value="indisponivel">Indisponível</option>
            </select>
          </div>
          <div class="filter-group">
            <label>Categoria:</label>
            <select id="filterCategoria">
              <option value="">Todas</option>
            </select>
          </div>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody id="produtosTableBody">
              <!-- Dados serão inseridos via JavaScript -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Novo Produto -->
      <div id="modalNovoProduto" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Novo Produto</h2>
            <button
              class="close-modal"
              onclick="closeModal('modalNovoProduto')"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <form id="formProduto">
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
                  <label for="categoria">Categoria</label>
                  <select id="categoria" required>
                    <option value="">Selecione...</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="fornecedor">Fornecedor</label>
                  <select id="fornecedor" required>
                    <option value="">Selecione...</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="quantidade">Quantidade</label>
                  <input type="number" id="quantidade" required />
                </div>
                <div class="form-group">
                  <label for="preco">Preço</label>
                  <input type="number" id="preco" step="0.01" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="estoqueMinimo">Estoque Mínimo</label>
                  <input type="number" id="estoqueMinimo" required />
                </div>
                <div class="form-group">
                  <label for="validade">Data de Validade</label>
                  <input type="date" id="validade" />
                </div>
              </div>
              <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" rows="3"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              class="btn-secondary"
              onclick="closeModal('modalNovoProduto')"
            >
              Cancelar
            </button>
            <button class="btn-primary" onclick="salvarProduto()">
              Salvar
            </button>
          </div>
        </div>
      </div>
    </main>

    <script>
      // Dados de exemplo para produtos
      const produtos = [
        {
          id: 1,
          codigo: "PROD001",
          nome: "Produto Exemplo 1",
          categoria: "Categoria A",
          quantidade: 100,
          preco: 29.99,
          status: "disponivel",
        },
        // Adicione mais produtos conforme necessário
      ];

      function verificarEstoque(quantidade, minimo) {
        if (quantidade <= 0) return "indisponivel";
        if (quantidade <= minimo) return "baixo_estoque";
        return "disponivel";
      }

      function renderizarTabela(dados) {
        const tbody = document.getElementById("produtosTableBody");
        tbody.innerHTML = "";

        dados.forEach((produto) => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
                    <td>${produto.codigo}</td>
                    <td>${produto.nome}</td>
                    <td>${produto.categoria}</td>
                    <td>${produto.quantidade}</td>
                    <td>R$ ${produto.preco.toFixed(2)}</td>
                    <td><span class="status-badge ${
                      produto.status
                    }">${formatarStatus(produto.status)}</span></td>
                    <td>
                        <button class="btn-icon" onclick="verDetalhes(${
                          produto.id
                        })">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="editarProduto(${
                          produto.id
                        })">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon" onclick="excluirProduto(${
                          produto.id
                        })">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
          tbody.appendChild(tr);
        });
      }

      function atualizarContadores(dados) {
        const total = dados.length;
        const baixoEstoque = dados.filter(
          (p) => p.status === "baixo_estoque"
        ).length;
        const indisponiveis = dados.filter(
          (p) => p.status === "indisponivel"
        ).length;

        // Atualizar contadores na interface (se necessário)
      }

      function pesquisarProdutos(query) {
        const resultados = produtos.filter(
          (produto) =>
            produto.nome.toLowerCase().includes(query.toLowerCase()) ||
            produto.codigo.toLowerCase().includes(query.toLowerCase())
        );
        renderizarTabela(resultados);
        atualizarContadores(resultados);
      }

      function formatarData(data) {
        return new Date(data).toLocaleDateString("pt-BR");
      }

      function formatarStatus(status) {
        const statusMap = {
          disponivel: "Disponível",
          baixo_estoque: "Baixo Estoque",
          indisponivel: "Indisponível",
        };
        return statusMap[status] || status;
      }

      // Event listener para pesquisa
      document.querySelector(".search-input").addEventListener("input", (e) => {
        pesquisarProdutos(e.target.value);
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

      function verDetalhes(id) {
        const produto = produtos.find((p) => p.id === id);
        if (produto) {
          // Implementar visualização de detalhes
          alert(`Detalhes do produto ${produto.nome}`);
        }
      }

      function editarProduto(id) {
        // Implementar edição de produto
      }

      function excluirProduto(id) {
        if (confirm("Tem certeza que deseja excluir este produto?")) {
          // Implementar exclusão de produto
        }
      }

      function salvarProduto() {
        // Implementar salvamento de produto
        const form = document.getElementById("formProduto");
        // Validar e salvar dados do formulário
        closeModal("modalNovoProduto");
      }

      function abrirModalNovoProduto() {
        document.getElementById("formProduto").reset();
        showModal("modalNovoProduto");
      }
    </script>
  </body>
</html>

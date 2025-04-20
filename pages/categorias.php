<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestão de Categorias - Sistema de Gestão de Inventário</title>
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
          placeholder="Pesquisar categorias..."
        />
        <i class="fas fa-search search-icon"></i>
      </div>
      <button class="btn-primary" onclick="abrirModalNovaCategoria()">
        <i class="fas fa-plus"></i> Nova Categoria
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
          <h1>Gestão de Categorias</h1>
        </div>

        <div class="grid-container">
          <div class="category-tree">
            <h3>Estrutura de Categorias</h3>
            <div id="categoryTree" class="tree-view">
              <!-- Será preenchido via JavaScript -->
            </div>
          </div>

          <div class="category-details">
            <div class="card">
              <div class="card-header">
                <h3>Detalhes da Categoria</h3>
              </div>
              <div class="card-body">
                <form id="formCategoria">
                  <div class="form-group">
                    <label for="nome">Nome da Categoria</label>
                    <input type="text" id="nome" required />
                  </div>
                  <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="categoriaPai">Categoria Pai</label>
                    <select id="categoriaPai">
                      <option value="">Nenhuma (Categoria Principal)</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="cor">Cor</label>
                    <input type="color" id="cor" value="#0077b6" />
                  </div>
                  <div class="form-group">
                    <label for="icone">Ícone</label>
                    <div class="icon-selector">
                      <button type="button" class="btn-icon selected">
                        <i class="fas fa-box"></i>
                      </button>
                      <button type="button" class="btn-icon">
                        <i class="fas fa-boxes"></i>
                      </button>
                      <button type="button" class="btn-icon">
                        <i class="fas fa-cube"></i>
                      </button>
                      <button type="button" class="btn-icon">
                        <i class="fas fa-cubes"></i>
                      </button>
                    </div>
                  </div>
                  <div class="form-actions">
                    <button
                      type="button"
                      class="btn-secondary"
                      onclick="limparFormulario()"
                    >
                      Limpar
                    </button>
                    <button type="submit" class="btn-primary">Salvar</button>
                  </div>
                </form>
              </div>
            </div>

            <div class="card mt-4">
              <div class="card-header">
                <h3>Produtos na Categoria</h3>
              </div>
              <div class="card-body">
                <div class="table-container">
                  <table>
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Estoque</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="produtosCategoria">
                      <!-- Será preenchido via JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Nova Categoria -->
      <div id="modalNovaCategoria" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Nova Categoria</h2>
            <button
              class="close-modal"
              onclick="closeModal('modalNovaCategoria')"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <form id="formNovaCategoria">
              <div class="form-group">
                <label for="nomeNova">Nome</label>
                <input type="text" id="nomeNova" required />
              </div>
              <div class="form-group">
                <label for="descricaoNova">Descrição</label>
                <textarea id="descricaoNova" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="categoriaPaiNova">Categoria Pai</label>
                <select id="categoriaPaiNova">
                  <option value="">Nenhuma (Categoria Principal)</option>
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              class="btn-secondary"
              onclick="closeModal('modalNovaCategoria')"
            >
              Cancelar
            </button>
            <button class="btn-primary" onclick="salvarNovaCategoria()">
              Salvar
            </button>
          </div>
        </div>
      </div>
    </main>

    <script>
      // Dados de exemplo
      const categorias = [
        {
          id: 1,
          nome: "Eletrônicos",
          descricao: "Produtos eletrônicos em geral",
          cor: "#0077b6",
          icone: "fa-microchip",
          subCategorias: [
            {
              id: 2,
              nome: "Computadores",
              descricao: "Computadores e notebooks",
              cor: "#00b4d8",
              icone: "fa-laptop",
            },
            {
              id: 3,
              nome: "Smartphones",
              descricao: "Telefones celulares",
              cor: "#90e0ef",
              icone: "fa-mobile-alt",
            },
          ],
        },
      ];

      function renderizarArvore(
        categorias,
        parentElement = document.getElementById("categoryTree")
      ) {
        categorias.forEach((categoria) => {
          const item = document.createElement("div");
          item.className = "tree-item";
          item.innerHTML = `
                    <div class="tree-item-content" onclick="selecionarCategoria(${
                      categoria.id
                    })">
                        <i class="fas ${categoria.icone}" style="color: ${
            categoria.cor
          }"></i>
                        <span>${categoria.nome}</span>
                        ${
                          categoria.subCategorias
                            ? '<i class="fas fa-chevron-right"></i>'
                            : ""
                        }
                    </div>
                `;

          if (categoria.subCategorias && categoria.subCategorias.length > 0) {
            const subItems = document.createElement("div");
            subItems.className = "tree-subitems";
            renderizarArvore(categoria.subCategorias, subItems);
            item.appendChild(subItems);
          }

          parentElement.appendChild(item);
        });
      }

      function selecionarCategoria(id) {
        // Implementar seleção de categoria
        console.log("Categoria selecionada:", id);
      }

      function abrirModalNovaCategoria() {
        document.getElementById("formNovaCategoria").reset();
        showModal("modalNovaCategoria");
      }

      function salvarNovaCategoria() {
        // Implementar salvamento
        closeModal("modalNovaCategoria");
      }

      function limparFormulario() {
        document.getElementById("formCategoria").reset();
      }

      // Event listeners
      document
        .querySelector(".profile-toggle")
        .addEventListener("click", toggleMenu);
      document
        .querySelector(".close-sidebar")
        .addEventListener("click", toggleMenu);

      document
        .getElementById("formCategoria")
        .addEventListener("submit", function (e) {
          e.preventDefault();
          // Implementar salvamento do formulário
        });

      // Inicialização
      document.addEventListener("DOMContentLoaded", () => {
        renderizarArvore(categorias);
      });
    </script>
    <script src="../assets/js/sidebar.js"></script>
  </body>
</html>

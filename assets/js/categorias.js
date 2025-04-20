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
              <div class="tree-item-content" onclick="selecionarCategoria(${categoria.id
      })">
                  <i class="fas ${categoria.icone}" style="color: ${categoria.cor
      }"></i>
                  <span>${categoria.nome}</span>
                  ${categoria.subCategorias
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

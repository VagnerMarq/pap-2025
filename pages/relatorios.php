<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Relatórios - Sistema de Gestão de Inventário</title>
    <link rel="stylesheet" href="../assets/css/estilo.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
      .reports-container {
        padding: 2rem;
      }

      .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
      }

      .report-title {
        font-size: 1.5rem;
        color: #333;
        margin: 0;
      }

      .report-actions {
        display: flex;
        gap: 1rem;
      }

      .date-filter {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .date-filter select,
      .date-filter input {
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.9rem;
      }

      .export-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #0077b6;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
      }

      .export-btn:hover {
        background: #005b8c;
      }

      .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
      }

      .metric-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .metric-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
      }

      .metric-title {
        font-size: 1rem;
        color: #666;
        margin: 0;
      }

      .metric-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
      }

      .metric-value {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin: 0.5rem 0;
      }

      .metric-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
      }

      .trend-up {
        color: #28a745;
      }
      .trend-down {
        color: #dc3545;
      }

      .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
      }

      .chart-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
      }

      .chart-title {
        font-size: 1.1rem;
        color: #333;
        margin: 0;
      }

      .chart-actions {
        display: flex;
        gap: 0.5rem;
      }

      .chart-filter {
        padding: 0.25rem 0.75rem;
        border: 1px solid #ddd;
        border-radius: 15px;
        font-size: 0.9rem;
        background: none;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .chart-filter.active {
        background: #0077b6;
        color: white;
        border-color: #0077b6;
      }

      .table-section {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
      }

      .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
      }

      .table-title {
        font-size: 1.1rem;
        color: #333;
        margin: 0;
      }

      .data-table {
        width: 100%;
        border-collapse: collapse;
      }

      .data-table th {
        background: #f8f9fa;
        padding: 1rem;
        text-align: left;
        font-weight: 500;
        color: #666;
        border-bottom: 2px solid #ddd;
      }

      .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
        color: #333;
      }

      .data-table tr:hover {
        background: #f8f9fa;
      }

      .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 500;
      }

      .status-success {
        background: #d4edda;
        color: #28a745;
      }
      .status-warning {
        background: #fff3cd;
        color: #fd7e14;
      }
      .status-danger {
        background: #f8d7da;
        color: #dc3545;
      }

      @media (max-width: 1200px) {
        .charts-grid {
          grid-template-columns: 1fr;
        }
      }

      @media (max-width: 768px) {
        .report-header {
          flex-direction: column;
          gap: 1rem;
          align-items: stretch;
        }

        .date-filter {
          flex-direction: column;
        }

        .metrics-grid {
          grid-template-columns: 1fr;
        }
      }

      /* Estilos adicionados para as notificações */
      .dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 1rem;
        display: none;
      }

      .dropdown.show {
        display: block;
      }

      .dropdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
      }

      .mark-all-read {
        background: #0077b6;
        color: white;
        border: none;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.9rem;
        cursor: pointer;
      }

      .notifications-content {
        max-height: 300px;
        overflow-y: auto;
      }

      .notification-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.5rem;
        border-bottom: 1px solid #eee;
      }

      .notification-item:last-child {
        border-bottom: none;
      }

      .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
      }

      .notification-icon.danger {
        background: #dc3545;
      }

      .notification-icon.warning {
        background: #fd7e14;
      }

      .notification-icon.success {
        background: #28a745;
      }

      .notification-info {
        flex: 1;
      }

      .notification-title {
        font-size: 1rem;
        color: #333;
        margin: 0;
      }

      .notification-message {
        font-size: 0.9rem;
        color: #666;
      }

      .notifications-footer {
        margin-top: 1rem;
      }

      .view-all {
        background: #0077b6;
        color: white;
        border: none;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.9rem;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <header>
      <button class="profile-toggle">
        <i class="fas fa-user-circle"></i>
      </button>
      <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar..." />
        <i class="fas fa-search search-icon"></i>
      </div>
      <div class="header-actions">
        <button class="btn-icon" id="notificationsBtn" title="Notificações">
          <i class="fas fa-industry"></i>
          <span>Fornecedores</span>
        </button>
        <div id="notificationsDropdown" class="dropdown">
          <div class="dropdown-header">
            <h3>GESTÃO DE INVENTÁRIO</h3>
            <button class="mark-all-read">Marcar todas como lidas</button>
          </div>
          <div class="notifications-content">
            <!-- Notificações serão inseridas aqui dinamicamente -->
          </div>
          <div class="notifications-footer">
            <a href="notificacoes.html" class="view-all"
              >Ver todas as notificações</a
            >
          </div>
        </div>
      </div>
    </header>

    <?php require_once '../services/header.php' ?>

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
      <div class="reports-container">
        <div class="report-header">
          <h1 class="report-title">Relatórios e Análises</h1>
          <div class="report-actions">
            <div class="date-filter">
              <label for="periodFilter">Período:</label>
              <select id="periodFilter">
                <option value="today">Hoje</option>
                <option value="week">Esta Semana</option>
                <option value="month" selected>Este Mês</option>
                <option value="year">Este Ano</option>
                <option value="custom">Personalizado</option>
              </select>
              <input
                type="date"
                id="startDate"
                class="date-input"
                style="display: none"
              />
              <input
                type="date"
                id="endDate"
                class="date-input"
                style="display: none"
              />
            </div>
            <div class="report-type">
              <label for="reportType">Tipo de Relatório:</label>
              <select id="reportType">
                <option value="movimentacoes">Movimentações</option>
                <option value="estoque">Nível de Estoque</option>
                <option value="produtos">Produtos</option>
                <option value="fornecedores">Fornecedores</option>
                <option value="armazens">Armazéns</option>
              </select>
            </div>
            <div class="export-options">
              <button
                class="btn-icon"
                onclick="exportarPDF()"
                title="Exportar PDF"
              >
                <i class="fas fa-file-pdf"></i>
              </button>
              <button
                class="btn-icon"
                onclick="exportarExcel()"
                title="Exportar Excel"
              >
                <i class="fas fa-file-excel"></i>
              </button>
              <button
                class="btn-icon"
                onclick="exportarCSV()"
                title="Exportar CSV"
              >
                <i class="fas fa-file-csv"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="metrics-grid">
          <div class="metric-card">
            <div class="metric-header">
              <h3 class="metric-title">Vendas Totais</h3>
              <div class="metric-icon bg-blue">
                <i class="fas fa-shopping-cart"></i>
              </div>
            </div>
            <div class="metric-value">245.678 AOA</div>
            <div class="metric-trend">
              <i class="fas fa-arrow-up trend-up"></i>
              <span>12% vs. mês anterior</span>
            </div>
          </div>

          <div class="metric-card">
            <div class="metric-header">
              <h3 class="metric-title">Lucro Líquido</h3>
              <div class="metric-icon bg-green">
                <i class="fas fa-dollar-sign"></i>
              </div>
            </div>
            <div class="metric-value">98.271 AOA</div>
            <div class="metric-trend">
              <i class="fas fa-arrow-up trend-up"></i>
              <span>8% vs. mês anterior</span>
            </div>
          </div>

          <div class="metric-card">
            <div class="metric-header">
              <h3 class="metric-title">Produtos em Estoque</h3>
              <div class="metric-icon bg-orange">
                <i class="fas fa-box"></i>
              </div>
            </div>
            <div class="metric-value">1,234</div>
            <div class="metric-trend">
              <i class="fas fa-arrow-down trend-down"></i>
              <span>3% vs. mês anterior</span>
            </div>
          </div>

          <div class="metric-card">
            <div class="metric-header">
              <h3 class="metric-title">Produtos Vencendo</h3>
              <div class="metric-icon bg-red">
                <i class="fas fa-exclamation-circle"></i>
              </div>
            </div>
            <div class="metric-value">23</div>
            <div class="metric-trend">
              <i class="fas fa-arrow-up trend-down"></i>
              <span>5 novos esta semana</span>
            </div>
          </div>
        </div>

        <div class="charts-grid">
          <div class="chart-card">
            <div class="chart-header">
              <h3 class="chart-title">Vendas por Período</h3>
              <div class="chart-actions">
                <button class="chart-filter active">Diário</button>
                <button class="chart-filter">Semanal</button>
                <button class="chart-filter">Mensal</button>
              </div>
            </div>
            <div id="salesChart"></div>
          </div>

          <div class="chart-card">
            <div class="chart-header">
              <h3 class="chart-title">Top Produtos Vendidos</h3>
              <div class="chart-actions">
                <button class="chart-filter active">Quantidade</button>
                <button class="chart-filter">Valor</button>
              </div>
            </div>
            <div id="productsChart"></div>
          </div>
        </div>

        <div class="table-section">
          <div class="table-header">
            <h3 class="table-title">Últimas Transações</h3>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Data</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#12345</td>
                <td>Dipirona 500mg</td>
                <td>18/02/2025</td>
                <td>50</td>
                <td>2.500 AOA</td>
                <td>
                  <span class="status-badge status-success">Concluído</span>
                </td>
              </tr>
              <tr>
                <td>#12344</td>
                <td>Amoxicilina 500mg</td>
                <td>18/02/2025</td>
                <td>30</td>
                <td>4.500 AOA</td>
                <td>
                  <span class="status-badge status-warning">Pendente</span>
                </td>
              </tr>
              <tr>
                <td>#12343</td>
                <td>Paracetamol 750mg</td>
                <td>17/02/2025</td>
                <td>100</td>
                <td>3.000 AOA</td>
                <td>
                  <span class="status-badge status-success">Concluído</span>
                </td>
              </tr>
              <tr>
                <td>#12342</td>
                <td>Ibuprofeno 600mg</td>
                <td>17/02/2025</td>
                <td>25</td>
                <td>1.875 AOA</td>
                <td>
                  <span class="status-badge status-danger">Cancelado</span>
                </td>
              </tr>
              <tr>
                <td>#12341</td>
                <td>Omeprazol 20mg</td>
                <td>16/02/2025</td>
                <td>60</td>
                <td>3.600 AOA</td>
                <td>
                  <span class="status-badge status-success">Concluído</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <script>
      // Controle do menu lateral
      const toggleMenu = () => {
        const sidebar = document.querySelector(".sidebar");
        const main = document.querySelector("main");
        sidebar.classList.toggle("show");
        main.classList.toggle("sidebar-open");
      };

      document
        .querySelector(".profile-toggle")
        .addEventListener("click", toggleMenu);

      // Controle do filtro de período
      document
        .getElementById("periodFilter")
        .addEventListener("change", function (e) {
          const customInputs = document.querySelectorAll(
            "#startDate, #endDate"
          );
          if (e.target.value === "custom") {
            customInputs.forEach((input) => (input.style.display = "inline"));
          } else {
            customInputs.forEach((input) => (input.style.display = "none"));
          }
          updateCharts();
        });

      // Função para exportar relatório
      function exportReport() {
        alert("Exportando relatório...");
        // Implementar lógica de exportação
      }

      // Configuração dos gráficos
      function initCharts() {
        // Gráfico de Vendas
        const salesOptions = {
          series: [
            {
              name: "Vendas",
              data: [30000, 40000, 35000, 50000, 49000, 60000, 70000],
            },
          ],
          chart: {
            type: "area",
            height: 350,
            toolbar: {
              show: false,
            },
          },
          dataLabels: {
            enabled: false,
          },
          stroke: {
            curve: "smooth",
          },
          xaxis: {
            categories: [
              "12/02",
              "13/02",
              "14/02",
              "15/02",
              "16/02",
              "17/02",
              "18/02",
            ],
          },
          yaxis: {
            labels: {
              formatter: function (value) {
                return value.toLocaleString("pt-AO") + " AOA";
              },
            },
          },
          tooltip: {
            y: {
              formatter: function (value) {
                return value.toLocaleString("pt-AO") + " AOA";
              },
            },
          },
          colors: ["#0077b6"],
        };

        const salesChart = new ApexCharts(
          document.querySelector("#salesChart"),
          salesOptions
        );
        salesChart.render();

        // Gráfico de Produtos
        const productsOptions = {
          series: [
            {
              data: [400, 350, 300, 250, 200],
            },
          ],
          chart: {
            type: "bar",
            height: 350,
            toolbar: {
              show: false,
            },
          },
          plotOptions: {
            bar: {
              borderRadius: 4,
              horizontal: true,
            },
          },
          dataLabels: {
            enabled: false,
          },
          xaxis: {
            categories: [
              "Dipirona 500mg",
              "Amoxicilina 500mg",
              "Paracetamol 750mg",
              "Ibuprofeno 600mg",
              "Omeprazol 20mg",
            ],
          },
          colors: ["#28a745"],
        };

        const productsChart = new ApexCharts(
          document.querySelector("#productsChart"),
          productsOptions
        );
        productsChart.render();
      }

      // Inicializar gráficos quando a página carregar
      document.addEventListener("DOMContentLoaded", initCharts);

      // Filtros dos gráficos
      document.querySelectorAll(".chart-filter").forEach((button) => {
        button.addEventListener("click", function () {
          const parent = this.closest(".chart-actions");
          parent
            .querySelectorAll(".chart-filter")
            .forEach((b) => b.classList.remove("active"));
          this.classList.add("active");
          updateCharts();
        });
      });

      // Atualizar gráficos baseado nos filtros
      function updateCharts() {
        // Implementar lógica de atualização dos gráficos
        console.log("Atualizando gráficos...");
      }

      // Gerenciamento de estado das notificações
      class NotificationManager {
        constructor() {
          this.storageKey = "pharmacyNotifications";
          this.readNotifications = this.getReadNotifications();
        }

        getReadNotifications() {
          const stored = localStorage.getItem(this.storageKey);
          return stored ? JSON.parse(stored) : [];
        }

        markAsRead(notificationId) {
          if (!this.readNotifications.includes(notificationId)) {
            this.readNotifications.push(notificationId);
            localStorage.setItem(
              this.storageKey,
              JSON.stringify(this.readNotifications)
            );
          }
        }

        isRead(notificationId) {
          return this.readNotifications.includes(notificationId);
        }

        getUnreadCount() {
          return notifications.filter((n) => !this.isRead(n.id)).length;
        }
      }

      // Inicializar gerenciador de notificações
      const notificationManager = new NotificationManager();

      // Atualizar notificações na página
      function updateNotifications() {
        const notifications = [
          {
            id: 1,
            title: "Estoque Crítico: Dipirona",
            message: "Estoque abaixo do mínimo",
            icon: "fas fa-exclamation-circle",
            type: "danger",
          },
          {
            id: 2,
            title: "Vencimento Próximo",
            message: "5 medicamentos próximos",
            icon: "fas fa-clock",
            type: "warning",
          },
          {
            id: 3,
            title: "Nova Venda Registrada",
            message: "Pedido #12345 aprovado",
            icon: "fas fa-check-circle",
            type: "success",
          },
        ];

        const container = document.querySelector(".notifications-content");
        container.innerHTML = "";

        notifications.forEach((notification) => {
          if (!notificationManager.isRead(notification.id)) {
            const html = `
                        <div class="notification-item" data-id="${notification.id}">
                            <div class="notification-icon ${notification.type}">
                                <i class="${notification.icon}"></i>
                            </div>
                            <div class="notification-info">
                                <div class="notification-title">${notification.title}</div>
                                <div class="notification-message">${notification.message}</div>
                            </div>
                        </div>
                    `;
            container.insertAdjacentHTML("beforeend", html);
          }
        });

        // Atualizar contador
        const count = notificationManager.getUnreadCount();
        const badge = document.querySelector(".badge");
        badge.textContent = count;
        badge.style.display = count > 0 ? "inline" : "none";
      }

      // Controle do dropdown de notificações
      const notificationsBtn = document.getElementById("notificationsBtn");
      const notificationsDropdown = document.getElementById(
        "notificationsDropdown"
      );

      notificationsBtn.addEventListener("click", () => {
        notificationsDropdown.classList.toggle("show");
        updateNotifications();
      });

      // Fechar dropdown quando clicar fora
      document.addEventListener("click", (e) => {
        if (
          !notificationsBtn.contains(e.target) &&
          !notificationsDropdown.contains(e.target)
        ) {
          notificationsDropdown.classList.remove("show");
        }
      });

      // Marcar notificação como lida ao clicar
      document
        .querySelector(".notifications-content")
        .addEventListener("click", (e) => {
          const item = e.target.closest(".notification-item");
          if (item) {
            const id = parseInt(item.dataset.id);
            notificationManager.markAsRead(id);
            updateNotifications();
          }
        });

      // Marcar todas como lidas
      document.querySelector(".mark-all-read").addEventListener("click", () => {
        const items = document.querySelectorAll(".notification-item");
        items.forEach((item) => {
          const id = parseInt(item.dataset.id);
          notificationManager.markAsRead(id);
        });
        updateNotifications();
      });

      // Inicializar notificações
      document.addEventListener("DOMContentLoaded", () => {
        updateNotifications();
      });
    </script>
  </body>
</html>

<?php

?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Sistema de Gestão de Inventário</title>
    <link rel="stylesheet" href="./assets/css/estilo.css" />
    <link rel="stylesheet" href="./assets/css/dashboard.css" />
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
        <input type="text" class="search-input" placeholder="Pesquisar..." />
        <i class="fas fa-search search-icon"></i>
      </div>
      <div class="header-actions">
        <button class="btn-icon" title="Notificações" id="notificationsBtn">
          <i class="fas fa-bell"></i>
          <span class="badge">3</span>
        </button>
        <div class="notifications-dropdown" id="notificationsDropdown">
          <div class="notifications-header">
            <h3 class="notifications-title">Notificações</h3>
            <button class="mark-all-read">Marcar todas como lidas</button>
          </div>
          <div class="notifications-list">
            <div class="notification-item unread">
              <div class="notification-icon bg-red">
                <i class="fas fa-exclamation-circle"></i>
              </div>
              <div class="notification-content">
                <h4 class="notification-title">Estoque Crítico</h4>
                <p class="notification-message">
                  Dipirona 500mg está com estoque abaixo do mínimo
                </p>
                <p class="notification-time">Há 5 minutos</p>
              </div>
              <div class="notification-dot"></div>
            </div>
            <div class="notification-item unread">
              <div class="notification-icon bg-orange">
                <i class="fas fa-clock"></i>
              </div>
              <div class="notification-content">
                <h4 class="notification-title">Vencimento Próximo</h4>
                <p class="notification-message">
                  5 medicamentos vencem em 30 dias
                </p>
                <p class="notification-time">Há 2 horas</p>
              </div>
              <div class="notification-dot"></div>
            </div>
            <div class="notification-item unread">
              <div class="notification-icon bg-green">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="notification-content">
                <h4 class="notification-title">Pedido Recebido</h4>
                <p class="notification-message">
                  Novo pedido de compra aprovado
                </p>
                <p class="notification-time">Há 3 horas</p>
              </div>
              <div class="notification-dot"></div>
            </div>
            <div class="notification-item">
              <div class="notification-icon bg-blue">
                <i class="fas fa-sync"></i>
              </div>
              <div class="notification-content">
                <h4 class="notification-title">Sistema Atualizado</h4>
                <p class="notification-message">
                  Nova versão do sistema instalada
                </p>
                <p class="notification-time">Há 1 dia</p>
              </div>
            </div>
          </div>
          <div class="notifications-footer">
            <a href="notificacoes.html" class="view-all"
              >Ver todas as notificações</a
            >
          </div>
        </div>
      </div>
    </header>

    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="profile-info">
          <i class="fas fa-user-circle"></i>
          <span>Administrador</span>
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
        <a href="movimentacoes.html">
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
        <a href="loginn.html">
          <i class="fas fa-sign-out-alt"></i>
          <span>Sair</span>
        </a>
      </div>
    </aside>

    <main>
      <div class="content">
        <div class="welcome-message">
          <h1 class="welcome-title">Bem-vindo, Administrador!</h1>
          <p class="welcome-subtitle">
            Confira o resumo das atividades do seu negócio
          </p>
        </div>

        <div class="dashboard-grid">
          <div class="card">
            <div class="card-header">
              <div class="card-icon bg-blue">
                <i class="fas fa-pills"></i>
              </div>
              <h3 class="card-title">Total de Medicamentos</h3>
            </div>
            <div class="card-value">1,234</div>
            <div class="card-trend">
              <i class="fas fa-arrow-up trend-up"></i>
              <span>12% desde o último mês</span>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <div class="card-icon bg-green">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <h3 class="card-title">Vendas do Mês</h3>
            </div>
            <div class="card-value">45.678 AOA</div>
            <div class="card-trend">
              <i class="fas fa-arrow-up trend-up"></i>
              <span>8% desde o último mês</span>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <div class="card-icon bg-orange">
                <i class="fas fa-exclamation-triangle"></i>
              </div>
              <h3 class="card-title">Estoque Baixo</h3>
            </div>
            <div class="card-value">23</div>
            <div class="card-trend">
              <i class="fas fa-arrow-down trend-down"></i>
              <span>5% desde o último mês</span>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <div class="card-icon bg-red">
                <i class="fas fa-calendar-times"></i>
              </div>
              <h3 class="card-title">Próx. ao Vencimento</h3>
            </div>
            <div class="card-value">12</div>
            <div class="card-trend">
              <i class="fas fa-arrow-up trend-down"></i>
              <span>2% desde o último mês</span>
            </div>
          </div>
        </div>

        <div class="chart-container">
          <div class="chart-header">
            <h3 class="chart-title">Vendas e Estoque</h3>
            <div class="chart-filters">
              <span class="chart-filter active">7 dias</span>
              <span class="chart-filter">30 dias</span>
              <span class="chart-filter">3 meses</span>
            </div>
          </div>
          <div id="mainChart" style="height: 300px"></div>
        </div>

        <div class="recent-activities">
          <h3 class="chart-title">Atividades Recentes</h3>
          <ul class="activity-list">
            <li class="activity-item">
              <div class="activity-icon bg-blue">
                <i class="fas fa-plus"></i>
              </div>
              <div class="activity-content">
                <h4 class="activity-title">Novo medicamento cadastrado</h4>
                <p class="activity-time">Há 2 horas</p>
              </div>
            </li>
            <li class="activity-item">
              <div class="activity-icon bg-green">
                <i class="fas fa-exchange-alt"></i>
              </div>
              <div class="activity-content">
                <h4 class="activity-title">Venda realizada</h4>
                <p class="activity-time">Há 4 horas</p>
              </div>
            </li>
            <li class="activity-item">
              <div class="activity-icon bg-orange">
                <i class="fas fa-box"></i>
              </div>
              <div class="activity-content">
                <h4 class="activity-title">Estoque atualizado</h4>
                <p class="activity-time">Há 6 horas</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="./assets/js/main.js"></script>
  </body>
</html>

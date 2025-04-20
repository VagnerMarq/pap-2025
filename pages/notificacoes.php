<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notificações - Sistema de Gestão de Inventário</title>
    <link rel="stylesheet" href="../assets/css/estilo.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <style> 
      .search-container {
        position: relative;
        flex: 1;
        max-width: 500px;
        margin: 0 2rem;
      }

      .search-input {
        width: 100%;
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        border: 1px solid #ddd;
        border-radius: 20px;
        font-size: 0.9rem;
      }

      .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
      }

      .header-actions {
        display: flex;
        gap: 1rem;
        position: relative;
      }

      .btn-icon {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #333;
        cursor: pointer;
        padding: 0.5rem;
        position: relative;
      }

      .badge {
        position: absolute;
        top: 0;
        right: 0;
        background: #dc3545;
        color: white;
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
      }

      /* Sidebar */
      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 250px;
        background: #1e2a31;
        color: #a4b1bc;
        padding-top: 0;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 99999;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      /* Sidebar Header */
      .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #263138;
        border-bottom: 1px solid #2d3a42;
        margin-bottom: 1rem;
      }

      .profile-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #fff;
      }

      .profile-info i {
        font-size: 1.2rem;
      }

      .close-sidebar {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0.5rem;
      }

      .close-sidebar:hover {
        color: #a4b1bc;
      }

      /* Menu Sections */
      .menu-section {
        margin-bottom: 1.5rem;
        padding: 0 1rem;
      }

      .menu-section h3 {
        color: #576974;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        padding: 0 0.5rem;
      }

      .menu-section a {
        display: flex;
        align-items: center;
        padding: 0.75rem 0.5rem;
        color: #a4b1bc;
        text-decoration: none;
        transition: all 0.2s ease;
        border-radius: 4px;
        margin-bottom: 0.25rem;
      }

      .menu-section a:hover {
        background: #263138;
        color: #fff;
      }

      .menu-section a.active {
        background: #263138;
        color: #fff;
      }

      .menu-section a i {
        width: 20px;
        margin-right: 0.75rem;
        text-align: center;
        font-size: 1.1rem;
        color: #4f94d7;
      }

      .menu-section a:hover i {
        color: #5ea3e6;
      }

      @media (max-width: 768px) {
        .sidebar {
          width: 100%;
        }
      }

      /* Main content */
      main {
        padding-top: 1rem;
        transition: margin-left 0.3s ease;
        min-height: calc(100vh - 64px);
      }

      main.sidebar-open {
        margin-left: 250px;
      }

      @media (max-width: 768px) {
        .search-container {
          display: none;
        }
      }

      /* Notificações */
      .notifications-page {
        padding: 2rem;
      }

      .notifications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
      }

      .filter-button {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .filter-button.active {
        background: #0077b6;
        color: white;
        border-color: #0077b6;
      }

      .mark-all-read {
        padding: 0.5rem 1rem;
        background: #0077b6;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
      }

      .mark-all-read:hover {
        background: #005b8c;
      }

      .notifications-list {
        display: grid;
        gap: 1rem;
      }

      .notification-item {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        display: flex;
        align-items: start;
        gap: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        cursor: pointer;
      }

      .notification-item:hover {
        transform: translateY(-2px);
      }

      .notification-item.unread {
        background: #f0f7ff;
        position: relative;
      }

      .notification-item.unread::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #0077b6;
        border-radius: 4px 0 0 4px;
      }

      .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        font-size: 1.2rem;
      }

      .notification-content {
        flex: 1;
      }

      .notification-title {
        font-size: 1.1rem;
        font-weight: 500;
        color: #333;
        margin: 0 0 0.5rem 0;
      }

      .notification-message {
        color: #666;
        margin: 0 0 0.5rem 0;
      }

      .notification-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        color: #999;
      }

      .notification-category {
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .category-tag {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        color: white;
      }

      .bg-blue {
        background: #0077b6;
      }
      .bg-green {
        background: #28a745;
      }
      .bg-orange {
        background: #fd7e14;
      }
      .bg-red {
        background: #dc3545;
      }

      .load-more {
        margin-top: 2rem;
        padding: 1rem;
        width: 100%;
        background: none;
        border: 2px dashed #ddd;
        border-radius: 10px;
        color: #666;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .load-more:hover {
        border-color: #0077b6;
        color: #0077b6;
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
          placeholder="Pesquisar produtos..."
        />
        <i class="fas fa-search search-icon"></i>
      </div>
      <button class="btn-icon" title="Notificações">
        <i class="fas fa-bell"></i>
        <span class="badge">3</span>
      </button>
    </header>

    <?php require_once '../services/header.php' ?>

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
      <div class="notifications-page">
        <div class="notifications-header">
          <h1 class="header-title">Notificações</h1>
          <div class="header-actions">
            <button class="filter-button active">Todas</button>
            <button class="filter-button">Não lidas</button>
            <button class="filter-button">Estoque</button>
            <button class="filter-button">Vendas</button>
            <button class="filter-button">Sistema</button>
            <button class="mark-all-read">
              <i class="fas fa-check-double"></i>
              Marcar todas como lidas
            </button>
          </div>
        </div>

        <div class="notifications-list"></div>

        <button class="load-more">
          <i class="fas fa-plus"></i> Carregar mais notificações
        </button>
      </div>
    </main>

    <script src="../assets/js/notification.js"></script>
    <script src="../assets/js/sidebar.js"></script>
  </body>
</html>

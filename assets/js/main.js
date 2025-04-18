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

// Função para formatar valores em Kwanza
function formatKwanza(value) {
  return new Intl.NumberFormat("pt-AO", {
    style: "currency",
    currency: "AOA",
    minimumFractionDigits: 2,
  }).format(value);
}

// Configuração do gráfico
const options = {
  series: [
    {
      name: "Vendas",
      data: [31000, 40000, 28000, 51000, 42000, 109000, 100000],
    },
    {
      name: "Estoque",
      data: [11000, 32000, 45000, 32000, 34000, 52000, 41000],
    },
  ],
  chart: {
    height: 300,
    type: "area",
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
    type: "datetime",
    categories: [
      "2024-02-12T00:00:00.000Z",
      "2024-02-13T00:00:00.000Z",
      "2024-02-14T00:00:00.000Z",
      "2024-02-15T00:00:00.000Z",
      "2024-02-16T00:00:00.000Z",
      "2024-02-17T00:00:00.000Z",
      "2024-02-18T00:00:00.000Z",
    ],
  },
  yaxis: {
    labels: {
      formatter: function (value) {
        return formatKwanza(value);
      },
    },
  },
  tooltip: {
    x: {
      format: "dd/MM/yy",
    },
    y: {
      formatter: function (value) {
        return formatKwanza(value);
      },
    },
  },
  colors: ["#0077b6", "#28a745"],
};

const chart = new ApexCharts(
  document.querySelector("#mainChart"),
  options
);
chart.render();

// Filtros do gráfico
document.querySelectorAll(".chart-filter").forEach((filter) => {
  filter.addEventListener("click", () => {
    document
      .querySelectorAll(".chart-filter")
      .forEach((f) => f.classList.remove("active"));
    filter.classList.add("active");
    // Aqui você pode adicionar a lógica para atualizar o gráfico com base no filtro
  });
});

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

const notificationManager = new NotificationManager();

// Atualizar notificações na página inicial
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

// Event Listeners
document.addEventListener("DOMContentLoaded", updateNotifications);

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

// Funcionalidade das notificações
const notificationsBtn = document.getElementById("notificationsBtn");
const notificationsDropdown = document.getElementById(
  "notificationsDropdown"
);

notificationsBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  notificationsDropdown.classList.toggle("show");
});

// Fechar dropdown ao clicar fora
document.addEventListener("click", (e) => {
  if (
    !notificationsDropdown.contains(e.target) &&
    !notificationsBtn.contains(e.target)
  ) {
    notificationsDropdown.classList.remove("show");
  }
});

// Marcar todas como lidas
document.querySelector(".mark-all-read").addEventListener("click", () => {
  document.querySelectorAll(".notification-item").forEach((item) => {
    item.classList.remove("unread");
    const dot = item.querySelector(".notification-dot");
    if (dot) dot.remove();
  });
  document.querySelector(".badge").textContent = "0";
});

// Marcar individual como lida
document.querySelectorAll(".notification-item").forEach((item) => {
  item.addEventListener("click", () => {
    if (item.classList.contains("unread")) {
      item.classList.remove("unread");
      const dot = item.querySelector(".notification-dot");
      if (dot) dot.remove();

      const badge = document.querySelector(".badge");
      const currentCount = parseInt(badge.textContent);
      badge.textContent = currentCount - 1;
    }
  });
});

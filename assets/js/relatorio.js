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
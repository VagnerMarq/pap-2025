// Estrutura de dados para notificações
const notifications = [
  {
    id: 1,
    title: "Estoque Crítico",
    message:
      "Dipirona 500mg está com estoque abaixo do mínimo (5 unidades restantes). Considere fazer um novo pedido.",
    icon: "fas fa-exclamation-circle",
    category: "Estoque",
    urgency: "Urgente",
    time: "Há 5 minutos",
    type: "bg-red",
  },
  {
    id: 2,
    title: "Vencimento Próximo",
    message:
      "5 medicamentos estão próximos ao vencimento (30 dias): Amoxicilina 500mg, Paracetamol 750mg, Ibuprofeno 600mg...",
    icon: "fas fa-clock",
    category: "Vencimento",
    urgency: "Importante",
    time: "Há 2 horas",
    type: "bg-orange",
  },
  {
    id: 3,
    title: "Pedido Recebido",
    message:
      "Novo pedido de compra #12345 foi aprovado. Total: 45.678 AOA. Clique para ver os detalhes.",
    icon: "fas fa-check-circle",
    category: "Vendas",
    urgency: "Sucesso",
    time: "Há 3 horas",
    type: "bg-green",
  },
  {
    id: 4,
    title: "Sistema Atualizado",
    message:
      "Nova versão do sistema (2.1.0) foi instalada com sucesso. Veja as novidades nos destaques.",
    icon: "fas fa-sync",
    category: "Sistema",
    urgency: "Informativo",
    time: "Há 1 dia",
    type: "bg-blue",
  },
];

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

  markAllAsRead() {
    const allIds = notifications.map((n) => n.id);
    this.readNotifications = allIds;
    localStorage.setItem(
      this.storageKey,
      JSON.stringify(this.readNotifications)
    );
  }

  isRead(notificationId) {
    return this.readNotifications.includes(notificationId);
  }

  getUnreadCount() {
    return notifications.filter((n) => !this.isRead(n.id)).length;
  }
}

const notificationManager = new NotificationManager();

// Renderizar notificações
function renderNotifications() {
  const container = document.querySelector(".notifications-list");
  container.innerHTML = "";

  notifications.forEach((notification) => {
    const isRead = notificationManager.isRead(notification.id);
    const html = `
              <div class="notification-item ${!isRead ? "unread" : ""
      }" data-id="${notification.id}">
                  <div class="notification-icon ${notification.type}">
                      <i class="${notification.icon}"></i>
                  </div>
                  <div class="notification-content">
                      <h3 class="notification-title">${notification.title
      }</h3>
                      <p class="notification-message">${notification.message
      }</p>
                      <div class="notification-meta">
                          <div class="notification-category">
                              <span class="category-tag ${notification.type
      }">${notification.category}</span>
                              <span>${notification.urgency}</span>
                          </div>
                          <span>${notification.time}</span>
                      </div>
                  </div>
              </div>
          `;
    container.insertAdjacentHTML("beforeend", html);
  });

  // Atualizar contador
  updateBadgeCount();
}

function updateBadgeCount() {
  const count = notificationManager.getUnreadCount();
  const badge = document.querySelector(".badge");
  badge.textContent = count;
  badge.style.display = count > 0 ? "inline" : "none";
}

// Event Listeners
document.addEventListener("DOMContentLoaded", () => {
  renderNotifications();
});

document.querySelector(".mark-all-read").addEventListener("click", () => {
  notificationManager.markAllAsRead();
  renderNotifications();
});

document
  .querySelector(".notifications-list")
  .addEventListener("click", (e) => {
    const item = e.target.closest(".notification-item");
    if (item) {
      const id = parseInt(item.dataset.id);
      notificationManager.markAsRead(id);
      renderNotifications();
    }
  });

// Filtros
document.querySelectorAll(".filter-button").forEach((button) => {
  button.addEventListener("click", () => {
    document
      .querySelectorAll(".filter-button")
      .forEach((b) => b.classList.remove("active"));
    button.classList.add("active");

    const filter = button.textContent.trim().toLowerCase();
    const items = document.querySelectorAll(".notification-item");

    items.forEach((item) => {
      const category = item
        .querySelector(".category-tag")
        .textContent.toLowerCase();
      const isUnread = item.classList.contains("unread");

      let shouldShow = true;
      if (filter === "não lidas") {
        shouldShow = isUnread;
      } else if (filter !== "todas") {
        shouldShow = category === filter;
      }

      item.style.display = shouldShow ? "flex" : "none";
    });
  });
});

// Pesquisa
const searchInput = document.querySelector(".search-input");
searchInput.addEventListener("input", (e) => {
  const query = e.target.value.toLowerCase();
  document.querySelectorAll(".notification-item").forEach((item) => {
    const title = item
      .querySelector(".notification-title")
      .textContent.toLowerCase();
    const message = item
      .querySelector(".notification-message")
      .textContent.toLowerCase();
    const shouldShow = title.includes(query) || message.includes(query);
    item.style.display = shouldShow ? "flex" : "none";
  });
});

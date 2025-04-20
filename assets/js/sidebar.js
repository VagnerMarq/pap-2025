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
  const closeSidebar = document.querySelector(".close-sidebar");

  if (
    !sidebar.contains(e.target) &&
    !profileToggle.contains(e.target) &&
    !closeSidebar.contains(e.target)
  ) {
    sidebar.classList.remove("show");
    document.querySelector("main").classList.remove("sidebar-open");
  }
});

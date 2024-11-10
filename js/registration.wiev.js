const accountContainer = document.getElementById("accountContainer");
const loginModal = document.getElementById("loginModal");
const closeModalBtn = document.getElementById("closeModalBtn");

// Відкрити модальне вікно при натисканні на nav__account-container
accountContainer.addEventListener("click", (event) => {
  event.preventDefault();
  loginModal.style.display = "block";
});

// Закрити модальне вікно при натисканні на хрестик
closeModalBtn.addEventListener("click", () => {
  loginModal.style.display = "none";
});

// Закрити модальне вікно при натисканні поза його межами
window.addEventListener("click", (event) => {
  if (event.target === loginModal) {
    loginModal.style.display = "none";
  }
});


const closeButton = document.querySelectorAll(".close");
const topBtn = document.querySelectorAll(".topBtn");

// Fermeture des messages flash
closeButton.forEach((element) => {
  element.addEventListener("click", () => {
    const alertDiv = element.closest(".alert");
    alertDiv.style.display = "none";
  });
});


// Gestion scroll
function goToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

topBtn.forEach((btn) => {
  btn.addEventListener("click", () => {
    goToTop();
  });
});

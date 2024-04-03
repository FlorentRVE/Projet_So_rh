// Fermeture des messages flash

const closeButton = document.querySelectorAll('.close');

closeButton.forEach(element => {
    element.addEventListener('click', () => {
      const alertDiv = element.closest('.alert');
      alertDiv.style.display = 'none';
    });
  });

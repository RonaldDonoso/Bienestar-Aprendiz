
function showInfo(id) {
    var info = document.getElementById('info' + id);
    info.classList.toggle('show');
  }

  
document.addEventListener("DOMContentLoaded", function() {
let detailButtons = document.querySelectorAll(".details-btn");

  detailButtons.forEach(function(button) {
      button.addEventListener("click", function() {
          let evento = this.parentNode;
          let info = evento.querySelector(".evento-info"); // Corrected class name here
          if (info.style.display === "none" || info.style.display === "") {
              info.style.display = "block";
              button.textContent = "Ocultar detalles";
          } else {
              info.style.display = "none";
              button.textContent = "Detalles";
          }
      });
  });
});

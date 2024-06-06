let slideIndex = 0;

function showSlides() {
  const slides = document.querySelectorAll('.slider img');
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = 'none';
  }
  if (slideIndex >= slides.length) {
    slideIndex = 0;
  }
  if (slideIndex < 0) {
    slideIndex = slides.length - 1;
  }
  slides[slideIndex].style.display = 'block';
}

function nextSlide() {
  slideIndex++;
  showSlides();
}

function prevSlide() {
  slideIndex--;
  showSlides();
}

showSlides();


////////////////////////////////////////

function showInfo(id) {
  var info = document.getElementById('info' + id);
  info.classList.toggle('show');
}

// segundo Slider //////////////////


  // Opcional: Agregar funcionalidad para el desplazamiento automático
  let slider = document.querySelector('.slider2');
  let slides = document.querySelectorAll('.slide');
  let slideWidth = (slides[0].offsetWidth + 10) * 3; // Ancho de tres slides más los márgenes

  function autoScroll() {
    slider.scrollLeft += slideWidth; // Desplaza un slide a la vez
    if (slider.scrollLeft >= (slider.scrollWidth - slider.offsetWidth)) {
      slider.scrollLeft = 0; // Vuelve al principio cuando se alcanza el final
    }
  }

  let scrollInterval = setInterval(autoScroll, 3000); // Cambia el slide cada 3 segundos

  // // Detener el desplazamiento automático al interactuar con el slider
  // slider.addEventListener('mouseenter', () => {
  //   clearInterval(scrollInterval);
  // });

  // slider.addEventListener('mouseleave', () => {
  //   scrollInterval = setInterval(autoScroll, 3000);
  // });

/////////////////////////////////////////////////

document.addEventListener("DOMContentLoaded", function() {
  let detailButtons = document.querySelectorAll(".details-btn");

  detailButtons.forEach(function(button) {
      button.addEventListener("click", function() {
          let evento = this.parentNode;
          let info = evento.querySelector(".evento-info");
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






/////////////////////////////////////////////////


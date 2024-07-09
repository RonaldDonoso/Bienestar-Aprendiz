
  let slider = document.querySelector('.slider2');
  let slides = document.querySelectorAll('.slide');
  let slideWidth = (slides[0].offsetWidth + 10) * 3; 

  function autoScroll() {
    slider.scrollLeft += slideWidth; 
    if (slider.scrollLeft >= (slider.scrollWidth - slider.offsetWidth)) {
      slider.scrollLeft = 0; 
    }
  }

  let scrollInterval = setInterval(autoScroll, 3000); 





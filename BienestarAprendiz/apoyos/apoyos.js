document.addEventListener("DOMContentLoaded", function() {
    let detailButtons = document.querySelectorAll(".details-btn");
    
    detailButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            let evento = this.parentNode;
            let info = evento.querySelector(".evento-info");
            let form = evento.querySelector("#postularse-form"); // Selecciona el formulario dentro del evento
            console.log(form); // Verificar si se selecciona el formulario correctamente
            console.log(form.style.display); // Verificar el estilo actual del formulario antes de cambiarlo
            if (info.style.display === "none" || info.style.display === "") {
                info.style.display = "block";
                button.textContent = "Ocultar detalles";
            } else {
                info.style.display = "none";
                button.textContent = "Detalles";
                // Ocultar el formulario cuando se ocultan los detalles del evento
                form.style.display = 'none';
                console.log(form.style.display); // Verificar si se ha cambiado correctamente el estilo del formulario
            }
        });
    });

    let showFormBtn = document.getElementById('show-form-btn');
    let form = document.getElementById('postularse-form');
    let mensaje = document.getElementById('mensaje');

    showFormBtn.addEventListener('click', function(event) {
        event.preventDefault();
        form.style.display = 'block';
        mensaje.textContent = ''; // Limpiar mensaje al mostrar el formulario
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('apoyos.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('La respuesta de la red no fue exitosa.');
            }
            return response.text();
        })
        .then(data => {
            if (data === "success") {
                mensaje.textContent = "La postulación se ha enviado correctamente.";
                mensaje.style.color = "green";
                form.reset(); // Limpiar el formulario después de enviar
            } else {
                throw new Error('La respuesta del servidor no fue la esperada.');
            }
        })
        .catch(error => {
            console.error('Hubo un problema con la operación de envío:', error);
            mensaje.textContent = "Hubo un problema al enviar la postulación. Por favor, inténtalo de nuevo más tarde.";
            mensaje.style.color = "red";
        });
    });
});

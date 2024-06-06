document.addEventListener("DOMContentLoaded", function() {
    let formBtn = document.getElementById('show-form-btn');
    let form = document.getElementById('postularse-form');

    formBtn.addEventListener('click', function(event) {
        event.preventDefault();
        form.style.display = 'block';
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('apoyos.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('La respuesta de la red no fue exitosa.');
        })
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Hubo un problema con la operación de envío:', error);
        });
    });
});

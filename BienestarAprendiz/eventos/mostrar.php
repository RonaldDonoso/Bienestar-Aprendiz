<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Corrected spelling of username
$password = "123456";
$dbname = "bd_bienestar";

// Verificar si se proporcionó un ID de evento
if(isset($_GET['id_evento'])) {
    $id_evento = $_GET['id_evento'];

    // Conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para obtener el evento por su ID
    $sqlEvento = "SELECT * FROM crear_evento WHERE id_evento = $id_evento";
    $resultEvento = $conn->query($sqlEvento);

    if ($resultEvento->num_rows > 0) {
        // Imprimir la información del evento
        $rowEvento = $resultEvento->fetch_assoc();
        echo '<div class="info-evento">';
        echo '<p>Nombre: ' . $rowEvento["nombre"] . '</p>';
        echo '<p>Descripción: ' . $rowEvento["descripcion"] . '</p>';
        echo '<p>Aforo: ' . $rowEvento["aforo"] . '</p>';
        echo '<p>Fecha del evento: ' . $rowEvento["fecha_evento"] . '</p>';
        echo '<p>Hora Evento: ' . $rowEvento["hora_evento"] . '</p>';
        echo '<p>Fecha Inicio Inscripcion: ' . $rowEvento["fecha_i_inscripcion"] . '</p>';
        echo '<p>Fecha Final Inscripcion: ' . $rowEvento["fecha_f_inscripcion"] . '</p>';
        echo '<p>Lugar: ' . $rowEvento["lugar"] . '</p>';

        // You can add more fields here as needed
        echo '</div>';
    } else {
        echo "No se encontro ningun evento con el ID especificado.";
    }

    $conn->close();
} else {
    echo "No se proporciono un ID de evento.";
}
?>

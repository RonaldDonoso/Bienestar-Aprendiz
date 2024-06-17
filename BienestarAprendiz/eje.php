<?php
// Verificar si se ha enviado el ID del evento a través de la URL
if(isset($_GET['id'])) {
    // Conexión a la base de datos
    require('config.php');

    // Establecer conexión con la base de datos
    $conn = mysqli_connect($host, $user, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener el ID del evento de la URL
    $id_evento = $_GET['id'];

    // Consulta SQL para obtener la información del evento
    $sql = "SELECT * FROM crear_evento WHERE id_evento = $id_evento";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar la información del evento
        $row = $result->fetch_assoc();
        echo "<h2>{$row['nombre']}</h2>";
        echo "<p><strong>Descripción:</strong> {$row['descripcion']}</p>";
        echo "<p><strong>Fecha del evento:</strong> {$row['f_evento']}</p>";
        echo "<p><strong>Aforo:</strong> {$row['aforo']}</p>";
        echo "<p><strong>Fecha del evento:</strong> {$row['fecha_evento']}</p>";
        echo "<p><strong>Hora del evento:</strong> {$row['hora_evento']}</p>";
        echo "<p><strong>Fecha inicio de inscripción:</strong> {$row['fecha_i_inscripcion']}</p>";
        echo "<p><strong>Fecha fin de inscripción:</strong> {$row['fecha_f_inscripcion']}</p>";
        echo "<p><strong>Lugar:</strong> {$row['lugar']}</p>";
        echo "<p><strong>Fecha del lugar:</strong> {$row['f_lugar']}</p>";
        echo "<p><strong>ID de clasificación del evento:</strong> {$row['id_clasificacion_evento']}</p>";
    } else {
        echo "No se encontró el evento.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "ID del evento no especificado.";
}
?>

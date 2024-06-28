<?php
// editar/editar_evento.php

// Incluir el archivo de conexión
require_once "../includes/db_connection.php";

// Función para obtener un evento por su ID
function obtenerEventoPorId($conn, $id_evento) {
    $id_evento = $conn->real_escape_string($id_evento); // Escapar el ID para prevenir SQL injection
    $sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y procesar la actualización del evento
    if (isset($_POST['id_evento'], $_POST['nombre'], $_POST['descripcion'], $_POST['fecha_evento'], $_POST['hora_evento'], $_POST['lugar'])) {
        // Obtener y validar datos del formulario
        $id_evento = $_POST['id_evento'];
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $fecha_evento = $_POST['fecha_evento'];
        $hora_evento = $_POST['hora_evento'];
        $lugar = $conn->real_escape_string($_POST['lugar']);

        // Actualizar el evento en la base de datos
        $sql = "UPDATE eventos SET nombre = '$nombre', descripcion = '$descripcion', fecha_evento = '$fecha_evento', hora_evento = '$hora_evento', lugar = '$lugar' WHERE id_evento = $id_evento";

        if ($conn->query($sql) === TRUE) {
            $mensaje_evento = "El evento se actualizó correctamente.";
        } else {
            $error_evento = "Hubo un problema al actualizar el evento. " . $conn->error;
        }
    } else {
        $error_evento = "Faltan datos del formulario.";
    }
}

// Obtener el ID del evento a editar desde el formulario de la lista de eventos
if (isset($_POST['id_evento'])) {
    $id_evento = $conn->real_escape_string($_POST['id_evento']);
} else {
    exit('ID de evento no proporcionado.');
}

// Función para obtener los detalles del evento por ID
$evento = obtenerEventoPorId($conn, $id_evento);

// Asegurarse de que el evento existe antes de mostrar el formulario de edición
if (!$evento) {
    // Si no se encuentra el evento, se podría redirigir a una página de error o manejar de otra forma
    exit('Evento no encontrado.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="editar.css">
</head>
<body>
    <div class="container">
        <h1>Editar Evento</h1>

        <?php if (isset($mensaje_evento)) : ?>
            <div class="mensaje success"><?php echo $mensaje_evento; ?></div>
        <?php elseif (isset($error_evento)) : ?>
            <div class="mensaje error"><?php echo $error_evento; ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input type="hidden" name="id_evento" value="<?php echo htmlspecialchars($evento['id_evento']); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($evento['nombre']); ?>" required>
            <br><br>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>
            <br><br>
            <label for="fecha_evento">Fecha del Evento:</label>
            <input type="date" id="fecha_evento" name="fecha_evento" value="<?php echo htmlspecialchars($evento['fecha_evento']); ?>" required>
            <br><br>
            <label for="hora_evento">Hora del Evento:</label>
            <input type="time" id="hora_evento" name="hora_evento" value="<?php echo htmlspecialchars($evento['hora_evento']); ?>" required>
            <br><br>
            <label for="lugar">Lugar:</label>
            <input type="text" id="lugar" name="lugar" value="<?php echo htmlspecialchars($evento['lugar']); ?>" required>
            <br><br>
            <input type="submit" value="Actualizar Evento">
            <a href="../admin.php" class="button">Volver Atrás</a>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos al finalizar
$conn->close();
?>

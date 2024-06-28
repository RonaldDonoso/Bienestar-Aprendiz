<?php

require_once "../includes/db_connection.php";

function obtenerEventoPorId($conn, $id_evento) {
    $id_evento = $conn->real_escape_string($id_evento); 
    $sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_evento'], $_POST['nombre'], $_POST['descripcion'], $_POST['fecha_evento'], $_POST['hora_evento'], $_POST['lugar'])) {
        $id_evento = $_POST['id_evento'];
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $fecha_evento = $_POST['fecha_evento'];
        $hora_evento = $_POST['hora_evento'];
        $lugar = $conn->real_escape_string($_POST['lugar']);

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

if (isset($_POST['id_evento'])) {
    $id_evento = $conn->real_escape_string($_POST['id_evento']);
} else {
    exit('ID de evento no proporcionado.');
}

$evento = obtenerEventoPorId($conn, $id_evento);

if (!$evento) {
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
$conn->close();
?>

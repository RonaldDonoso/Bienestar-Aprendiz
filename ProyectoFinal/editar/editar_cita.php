<?php
// editar/editar_cita.php

// Incluir el archivo de conexión
require_once "../includes/db_connection.php";

// Función para obtener una cita por su ID
function obtenerCitaPorId($conn, $id_cita) {
    $sql = "SELECT * FROM citas WHERE id_cita = $id_cita";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Inicializar variables para evitar errores de índice indefinido
$mensaje_cita = '';
$error_cita = '';
$cita = [];

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_cita'])) {
    // Procesar la actualización de la cita
    $id_cita = $_POST['id_cita'];
    $primer_nombre = isset($_POST['primer_nombre']) ? $_POST['primer_nombre'] : '';
    $segundo_nombre = isset($_POST['segundo_nombre']) ? $_POST['segundo_nombre'] : '';
    $primer_apellido = isset($_POST['primer_apellido']) ? $_POST['primer_apellido'] : '';
    $segundo_apellido = isset($_POST['segundo_apellido']) ? $_POST['segundo_apellido'] : '';
    $tipo_documento = isset($_POST['tipo_documento']) ? $_POST['tipo_documento'] : '';
    $numero_documento = isset($_POST['numero_documento']) ? $_POST['numero_documento'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $num_ficha = isset($_POST['num_ficha']) ? $_POST['num_ficha'] : '';
    $asunto = isset($_POST['asunto']) ? $_POST['asunto'] : '';
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
    $hora = isset($_POST['hora']) ? $_POST['hora'] : '';
    $estado_cita = isset($_POST['estado_cita']) ? $_POST['estado_cita'] : '';

    // Actualizar la cita en la base de datos
    $sql = "UPDATE citas SET 
                primer_nombre = '$primer_nombre', 
                segundo_nombre = '$segundo_nombre', 
                primer_apellido = '$primer_apellido', 
                segundo_apellido = '$segundo_apellido', 
                tipo_documento = '$tipo_documento', 
                numero_documento = '$numero_documento', 
                correo = '$correo', 
                telefono = '$telefono', 
                num_ficha = '$num_ficha', 
                asunto = '$asunto', 
                fecha = '$fecha', 
                hora = '$hora', 
                estado_cita = '$estado_cita' 
            WHERE id_cita = $id_cita";

    if ($conn->query($sql) === TRUE) {
        $mensaje_cita = "La cita se actualizó correctamente.";
    } else {
        $error_cita = "Hubo un problema al actualizar la cita. Inténtalo de nuevo.";
    }
}

// Obtener el ID de la cita a editar desde el formulario de la lista de citas
$id_cita = isset($_POST['id_cita']) ? $_POST['id_cita'] : '';

// Obtener los detalles de la cita por ID
if (!empty($id_cita)) {
    $cita = obtenerCitaPorId($conn, $id_cita);

    // Asegurarse de que la cita existe antes de mostrar el formulario de edición
    if (!$cita) {
        // Si no se encuentra la cita, se podría redirigir a una página de error o manejar de otra forma
        exit('Cita no encontrada.');
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="editar_cita.css">
</head>
<body>
    <div class="container">
        <h1>Editar Cita</h1>

        <?php if (!empty($mensaje_cita)) : ?>
            <div class="mensaje success"><?php echo $mensaje_cita; ?></div>
        <?php elseif (!empty($error_cita)) : ?>
            <div class="mensaje error"><?php echo $error_cita; ?></div>
        <?php endif; ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
            <label for="primer_nombre">Primer Nombre:</label>
            <input type="text" id="primer_nombre" name="primer_nombre" value="<?php echo isset($cita['primer_nombre']) ? $cita['primer_nombre'] : ''; ?>" required>
            <br><br>
            <label for="segundo_nombre">Segundo Nombre:</label>
            <input type="text" id="segundo_nombre" name="segundo_nombre" value="<?php echo isset($cita['segundo_nombre']) ? $cita['segundo_nombre'] : ''; ?>">
            <br><br>
            <label for="primer_apellido">Primer Apellido:</label>
            <input type="text" id="primer_apellido" name="primer_apellido" value="<?php echo isset($cita['primer_apellido']) ? $cita['primer_apellido'] : ''; ?>" required>
            <br><br>
            <label for="segundo_apellido">Segundo Apellido:</label>
            <input type="text" id="segundo_apellido" name="segundo_apellido" value="<?php echo isset($cita['segundo_apellido']) ? $cita['segundo_apellido'] : ''; ?>">
            <br><br>
            <label for="tipo_documento">Tipo de Documento:</label>
            <select id="tipo_documento" name="tipo_documento" required>
                <option value="cedula" <?php if ($cita['tipo_documento'] === 'cedula') echo 'selected'; ?>>Cédula</option>
                <option value="tarjeta de identidad" <?php if ($cita['tipo_documento'] === 'tarjeta de identidad') echo 'selected'; ?>>Tarjeta de Identidad</option>
            </select>
            <br><br>
            <label for="numero_documento">Número de Documento:</label>
            <input type="text" id="numero_documento" name="numero_documento" value="<?php echo isset($cita['numero_documento']) ? $cita['numero_documento'] : ''; ?>" required>
            <br><br>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo isset($cita['correo']) ? $cita['correo'] : ''; ?>" required>
            <br><br>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo isset($cita['telefono']) ? $cita['telefono'] : ''; ?>" required>
            <br><br>
            <label for="num_ficha">Número de Ficha:</label>
            <input type="text" id="num_ficha" name="num_ficha" value="<?php echo isset($cita['num_ficha']) ? $cita['num_ficha'] : ''; ?>" required>
            <br><br>
            <label for="asunto">Asunto:</label>
            <input type="text" id="asunto" name="asunto" value="<?php echo isset($cita['asunto']) ? $cita['asunto'] : ''; ?>" required>
            <br><br>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo isset($cita['fecha']) ? $cita['fecha'] : ''; ?>" required>
            <br><br>
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" value="<?php echo isset($cita['hora']) ? $cita['hora'] : ''; ?>" required>
            <br><br>
            <label for="estado_cita">Estado de la Cita:</label>
            <select id="estado_cita" name="estado_cita" required>
                <option value="pendiente" <?php if ($cita['estado_cita'] === 'pendiente') echo 'selected'; ?>>Pendiente</option>
                <option value="finalizada" <?php if ($cita['estado_cita'] === 'finalizada') echo 'selected'; ?>>Finalizada</option>
                <option value="en proceso" <?php if ($cita['estado_cita'] === 'en proceso') echo 'selected'; ?>>En Proceso</option>
            </select>
            <br><br>
            <input type="submit" name="actualizar_cita" value="Actualizar Cita"> <!-- Agregar un name al botón para identificarlo -->
            <a href="../admin.php" class="button">Volver Atrás</a>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos al finalizar
$conn->close();
?>

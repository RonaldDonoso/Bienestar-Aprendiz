<?php

require_once "../includes/db_connection.php";

function obtenerFormularioApoyoPorId($conn, $id_formulario_apoyo) {
    $id_formulario_apoyo = $conn->real_escape_string($id_formulario_apoyo); 
    $sql = "SELECT * FROM formulario_apoyo WHERE id_formulario_apoyo = $id_formulario_apoyo";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_formulario_apoyo'], $_POST['nombre_apoyo'], $_POST['primer_nombre'], $_POST['primer_apellido'], $_POST['correo'])) {
        $id_formulario_apoyo = $_POST['id_formulario_apoyo'];
        $nombre_apoyo = $conn->real_escape_string($_POST['nombre_apoyo']);
        $primer_nombre = $conn->real_escape_string($_POST['primer_nombre']);
        $segundo_nombre = $conn->real_escape_string($_POST['segundo_nombre']);
        $primer_apellido = $conn->real_escape_string($_POST['primer_apellido']);
        $segundo_apellido = $conn->real_escape_string($_POST['segundo_apellido']);
        $correo = $conn->real_escape_string($_POST['correo']);

        $sql = "UPDATE formulario_apoyo SET nombre_apoyo = '$nombre_apoyo', primer_nombre = '$primer_nombre', segundo_nombre = '$segundo_nombre', primer_apellido = '$primer_apellido', segundo_apellido = '$segundo_apellido', correo = '$correo' WHERE id_formulario_apoyo = $id_formulario_apoyo";

        if ($conn->query($sql) === TRUE) {
            $mensaje_formulario = "El formulario de apoyo se actualizó correctamente.";
        } else {
            $error_formulario = "Hubo un problema al actualizar el formulario de apoyo. " . $conn->error;
        }
    } else {
        $error_formulario = "Faltan datos del formulario.";
    }
}

if (isset($_POST['id_formulario_apoyo'])) {
    $id_formulario_apoyo = $conn->real_escape_string($_POST['id_formulario_apoyo']);
} else {
    exit('ID de formulario de apoyo no proporcionado.');
}

$formulario = obtenerFormularioApoyoPorId($conn, $id_formulario_apoyo);

if (!$formulario) {
    exit('Formulario de apoyo no encontrado.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Formulario de Apoyo</title>
    <link rel="stylesheet" href="editar.css">
</head>
<body>
    <div class="container">
        <h1>Editar Formulario de Apoyo</h1>

        <?php if (isset($mensaje_formulario)) : ?>
            <div class="mensaje success"><?php echo $mensaje_formulario; ?></div>
        <?php elseif (isset($error_formulario)) : ?>
            <div class="mensaje error"><?php echo $error_formulario; ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input type="hidden" name="id_formulario_apoyo" value="<?php echo htmlspecialchars($formulario['id_formulario_apoyo']); ?>">
            <label for="nombre_apoyo">Nombre del Apoyo:</label>
            <input type="text" id="nombre_apoyo" name="nombre_apoyo" value="<?php echo htmlspecialchars($formulario['nombre_apoyo'] ?? ''); ?>" required>
            <br><br>
            <label for="primer_nombre">Primer Nombre:</label>
            <input type="text" id="primer_nombre" name="primer_nombre" value="<?php echo htmlspecialchars($formulario['primer_nombre'] ?? ''); ?>" required>
            <br><br>
            <label for="segundo_nombre">Segundo Nombre:</label>
            <input type="text" id="segundo_nombre" name="segundo_nombre" value="<?php echo htmlspecialchars($formulario['segundo_nombre'] ?? ''); ?>">
            <br><br>
            <label for="primer_apellido">Primer Apellido:</label>
            <input type="text" id="primer_apellido" name="primer_apellido" value="<?php echo htmlspecialchars($formulario['primer_apellido'] ?? ''); ?>" required>
            <br><br>
            <label for="segundo_apellido">Segundo Apellido:</label>
            <input type="text" id="segundo_apellido" name="segundo_apellido" value="<?php echo htmlspecialchars($formulario['segundo_apellido'] ?? ''); ?>">
            <br><br>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($formulario['correo'] ?? ''); ?>" required>
            <br><br>
            <input type="submit" value="Actualizar Formulario de Apoyo">
            <a href="../admin.php" class="button">Volver Atrás</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>

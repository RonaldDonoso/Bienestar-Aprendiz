<?php
session_start();

require_once "includes/db_connection.php";

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header('Location: index.php'); 
    exit();
}


function obtenerEventos($conn) {
    $sql = "SELECT * FROM eventos";
    $result = $conn->query($sql);
    $eventos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $eventos[] = $row;
        }
    }
    return $eventos;
}

function agregarEvento($conn, $nombre, $descripcion, $fecha_evento, $hora_evento, $lugar, $imagen_temp, $imagen_nombre) {
    // Escapar variables para prevenir inyección SQL
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $descripcion = mysqli_real_escape_string($conn, $descripcion);
    $fecha_evento = mysqli_real_escape_string($conn, $fecha_evento);
    $hora_evento = mysqli_real_escape_string($conn, $hora_evento);
    $lugar = mysqli_real_escape_string($conn, $lugar);
    $imagen_nombre = mysqli_real_escape_string($conn, $imagen_nombre);

    // Mover la imagen del directorio temporal al directorio final
    $target_dir = "img_eventos/"; // Directorio donde se guardarán las imágenes
    $target_file = $target_dir . basename($imagen_nombre);

    if (move_uploaded_file($imagen_temp, $target_file)) {
        // Query para insertar el evento en la base de datos
        $sql = "INSERT INTO eventos (nombre, descripcion, fecha_evento, hora_evento, lugar, imagen) 
                VALUES ('$nombre', '$descripcion', '$fecha_evento', '$hora_evento', '$lugar', '$imagen_nombre')";

        if ($conn->query($sql)) {
            return true;
        } else {
            return false; // Error en la consulta SQL
        }
    } else {
        return false; // Error al mover la imagen
    }
}

function obtenerFormulariosApoyo($conn) {
    $sql = "SELECT * FROM formulario_apoyo";
    $result = $conn->query($sql);
    $formularios = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $formularios[] = $row;
        }
    }
    return $formularios;
}

function obtenerCitas($conn) {
    $sql = "SELECT * FROM citas";
    $result = $conn->query($sql);
    $citas = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $citas[] = $row;
        }
    }
    return $citas;
}

$eventos = obtenerEventos($conn);

$formularios_apoyo = obtenerFormulariosApoyo($conn);

$citas = obtenerCitas($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_evento'])) {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fecha_evento = $_POST['fecha_evento'];
        $hora_evento = $_POST['hora_evento'];
        $lugar = $_POST['lugar'];
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];

        // Procesar la imagen subida
        if (agregarEvento($conn, $nombre, $descripcion, $fecha_evento, $hora_evento, $lugar, $imagen_temp, $imagen_nombre)) {
            $mensaje_evento = "El evento se agregó correctamente.";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            $error_evento = "Hubo un problema al agregar el evento. Inténtalo de nuevo.";
        } 
    } 
}


///////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar_evento'])) {
        $id_evento = $_POST['id_evento'];
        
        $sql_eliminar_evento = "DELETE FROM eventos WHERE id_evento = $id_evento";
        if ($conn->query($sql_eliminar_evento) === TRUE) {
            $mensaje_evento = "El evento se eliminó correctamente.";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            $error_evento = "Hubo un problema al eliminar el evento. Inténtalo de nuevo.";
        }
    }

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar_formulario'])) {
        $id_formulario_apoyo = $_POST['id_formulario_apoyo'];
        
        $sql_eliminar_formulario = "DELETE FROM formulario_apoyo WHERE id_formulario_apoyo = $id_formulario_apoyo";
        if ($conn->query($sql_eliminar_formulario) === TRUE) {
            $mensaje_formulario = "El formulario se eliminó correctamente.";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit(); 
        } else {
            $error_formulario = "Hubo un problema al eliminar el formulario. Inténtalo de nuevo.";
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar_cita'])) {
        $id_cita = $_POST['id_cita'];
        
        $sql_eliminar_cita = "DELETE FROM citas WHERE id_cita = $id_cita";
        if ($conn->query($sql_eliminar_cita) === TRUE) {
            $mensaje_cita = "El cita se eliminó correctamente.";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit(); 
        } else {
            $error_cita = "Hubo un problema al eliminar el cita. Inténtalo de nuevo.";
        }
    }

}

//////////////////////////////////////

// Función para obtener el estado actual del formulario
function obtenerEstadoFormulario($conn) {
    $sql = "SELECT mostrar_apoyo_sostenible FROM configuracion_formulario WHERE id = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (bool) $row['mostrar_apoyo_sostenible']; // Convertir a booleano
    } else {
        // Si no hay registros, asumir que el formulario está oculto por defecto
        return false;
    }
}

// Actualizar la configuración del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_apoyo_sostenible'])) {
    $estado_actual = obtenerEstadoFormulario($conn);
    $nuevo_estado = !$estado_actual; // Cambiar el estado actual

    // Actualizar la base de datos
    $sql_update = "UPDATE configuracion_formulario SET mostrar_apoyo_sostenible = " . ($nuevo_estado ? "1" : "0") . " WHERE id = 1";
    if ($conn->query($sql_update) === TRUE) {
        // Éxito al actualizar, redirigir de vuelta a admin.php
        header("Location: admin.php");
        exit();
    } else {
        echo "Error al actualizar la configuración: " . $conn->error;
    }
}

// Obtener el estado actual del formulario
$mostrar_apoyo_sostenible = obtenerEstadoFormulario($conn);

$conn->close();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="admin/admin.css">
</head>
<body>
    <div class="container">
        <h1>Panel de Administración</h1>

        <a class="btn-volver" href="index.php">Volver al Index</a> <br> <br>

        <!-- Mostrar/Ocultar Formulario de Apoyo Sostenible -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <h2>Formulario Apoyo Sostenible</h2>
            <input type="submit" name="toggle_apoyo_sostenible" value="<?php echo ($mostrar_apoyo_sostenible) ? 'Ocultar Formulario de Apoyo' : 'Mostrar Formulario de Apoyo'; ?>" class="btn-toggle">
        </form>



        <?php if (isset($mensaje_evento)) : ?>
            <div class="mensaje success"><?php echo $mensaje_evento; ?></div>
        <?php elseif (isset($error_evento)) : ?>
            <div class="mensaje error"><?php echo $error_evento; ?></div>
        <?php endif; ?>

        <div class="card">
            <h2>Agregar Evento</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <br><br>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                <br><br>
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" id="fecha_evento" name="fecha_evento" required>
                <br><br>
                <label for="hora_evento">Hora del Evento:</label>
                <input type="time" id="hora_evento" name="hora_evento" required>
                <br><br>
                <label for="lugar">Lugar:</label>
                <input type="text" id="lugar" name="lugar" required>
                <br><br>
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                <br><br>
                <input type="submit" name="agregar_evento" value="Agregar Evento" class="btn-agregar">
            </form>

        </div>

        <div class="card">
            <h2>Lista de Eventos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha del Evento</th>
                        <th>Hora del Evento</th>
                        <th>Lugar</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eventos as $evento) : ?>
                        <tr>
                            <td><?php echo $evento['id_evento']; ?></td>
                            <td><?php echo $evento['nombre']; ?></td>
                            <td><?php echo $evento['descripcion']; ?></td>
                            <td><?php echo $evento['fecha_evento']; ?></td>
                            <td><?php echo isset($evento['hora_evento']) ? $evento['hora_evento'] : ''; ?></td>
                            <td><?php echo isset($evento['lugar']) ? $evento['lugar'] : ''; ?></td>
                            <td><?php echo $evento['imagen']; ?></td>
                            <td class="acciones">
                                <!-- Acciones -->
                                <a class="seleccionar-evento" href="eventos.php?id_evento=<?php echo $evento['id_evento']; ?>">Seleccionar</a>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                                    <input type="submit" name="eliminar_evento" value="Eliminar" class="eliminar-btn accion-btn">
                                    
                                </form>
                                <form action="editar/editar_evento.php" method="POST">
                                    <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                                    <input type="submit" name="editar_evento" value="Editar" class="editar-btn accion-btn">
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <br><hr><br>

    <div class="card">
        <h2>Lista de Formularios de Apoyo</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Primer Nombre</th>
                    <th>Segundo Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Tipo Documento</th>
                    <th>Numero Documento</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formularios_apoyo as $formulario) : ?>
                    <tr>
                        <td><?php echo $formulario['id_formulario_apoyo']; ?></td>
                        <td><?php echo $formulario['nombre_apoyo']; ?></td>
                        <td><?php echo $formulario['primer_nombre']; ?></td>
                        <td><?php echo $formulario['segundo_nombre']; ?></td>
                        <td><?php echo $formulario['primer_apellido']; ?></td>
                        <td><?php echo $formulario['segundo_apellido']; ?></td>
                        <td><?php echo $formulario['tipo_documento']; ?></td>
                        <td><?php echo $formulario['numero_documento']; ?></td>
                        <td><?php echo $formulario['correo']; ?></td>
                        <td><?php echo $formulario['telefono']; ?></td>
                        <td class="acciones">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <input type="hidden" name="id_formulario_apoyo" value="<?php echo $formulario['id_formulario_apoyo']; ?>">
                                <input type="submit" name="eliminar_formulario" value="Eliminar" class="eliminar-btn accion-btn">
                            </form>

                            <form action="editar/editar_formulario_apoyo.php" method="POST">
                                <input type="hidden" name="id_formulario_apoyo" value="<?php echo $formulario['id_formulario_apoyo']; ?>">
                                <input type="submit" name="editar_formulario" value="Editar" class="editar-btn accion-btn">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

        <br><hr><br>
        
    <div class="card">
        <h2>Lista de Citas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Primer Nombre</th>
                    <th>Segundo Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Tipo Documento</th>
                    <th>Num Documento</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Num Ficha</th>
                    <th>Asunto</th>
                    <th>Fecha Cita</th>
                    <th>Hora Cita</th>
                    <th>Estado Cita</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citas as $cita) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cita['id_cita']); ?></td>
                        <td><?php echo htmlspecialchars($cita['primer_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cita['segundo_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cita['primer_apellido']); ?></td>
                        <td><?php echo htmlspecialchars($cita['segundo_apellido']); ?></td>
                        <td><?php echo htmlspecialchars($cita['tipo_documento']); ?></td>
                        <td><?php echo htmlspecialchars($cita['numero_documento']); ?></td>
                        <td><?php echo htmlspecialchars($cita['correo']); ?></td>
                        <td><?php echo htmlspecialchars($cita['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($cita['num_ficha']); ?></td>
                        <td><?php echo htmlspecialchars($cita['asunto']); ?></td>
                        <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                        <td><?php echo htmlspecialchars($cita['estado_cita']); ?></td>
                        <td class="acciones">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                                <input type="submit" name="eliminar_cita" value="Eliminar" class="eliminar-btn accion-btn">
                            </form>

                            <form action="editar/editar_cita.php" method="POST">
                                <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($cita['id_cita']); ?>">
                                <input type="submit" name="editar_cita" value="Editar" class="editar-btn accion-btn">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>

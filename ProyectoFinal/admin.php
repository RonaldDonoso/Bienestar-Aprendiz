<?php
session_start();

// Incluir el archivo de conexión a la base de datos
require_once "includes/db_connection.php";

// Verificar si el usuario tiene permisos de administrador (rol 1)
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    // Si no es administrador, redireccionar a otra página o mostrar un mensaje de error
    header('Location: index.php'); // Cambiar a la página adecuada si no es administrador
    exit();
}


// Función para obtener todos los eventos
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

// Función para agregar un nuevo evento
function agregarEvento($conn, $nombre, $descripcion, $fecha_evento, $hora_evento, $lugar) {
    $sql = "INSERT INTO eventos (nombre, descripcion, fecha_evento, hora_evento, lugar) VALUES ('$nombre', '$descripcion', '$fecha_evento', '$hora_evento', '$lugar')";
    return $conn->query($sql);
}




// Función para obtener todos los formularios de apoyo
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

// Función para obtener todas las citas
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

// Obtener la lista de eventos
$eventos = obtenerEventos($conn);

// Obtener la lista de formularios de apoyo
$formularios_apoyo = obtenerFormulariosApoyo($conn);

// Obtener la lista de citas
$citas = obtenerCitas($conn);

// Mensajes de éxito o error
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_evento'])) {
        if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['fecha_evento'], $_POST['hora_evento'], $_POST['lugar'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $fecha_evento = $_POST['fecha_evento'];
            $hora_evento = $_POST['hora_evento'];
            $lugar = $_POST['lugar'];

            if (!empty($nombre) && !empty($descripcion) && !empty($fecha_evento) && !empty($hora_evento) && !empty($lugar)) {
                if (agregarEvento($conn, $nombre, $descripcion, $fecha_evento, $hora_evento, $lugar)) {
                    $mensaje_evento = "El evento se agregó correctamente.";
                } else {
                    $error_evento = "Hubo un problema al agregar el evento. Inténtalo de nuevo.";
                }
            } else {
                $error_evento = "Todos los campos son obligatorios.";
            }
        } else {
            $error_evento = "No se enviaron todos los datos necesarios.";
        }}
    } 

///////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar la eliminación de eventos
    if (isset($_POST['eliminar_evento'])) {
        $id_evento = $_POST['id_evento'];
        
        // Aquí deberías agregar validaciones adicionales según tu lógica de negocio
        $sql_eliminar_evento = "DELETE FROM eventos WHERE id_evento = $id_evento";
        if ($conn->query($sql_eliminar_evento) === TRUE) {
            $mensaje_evento = "El evento se eliminó correctamente.";
            // Redirigir después de eliminar (PRG pattern)
            header("Location: {$_SERVER['PHP_SELF']}");
            exit(); // Asegura que el script termine después de la redirección
        } else {
            $error_evento = "Hubo un problema al eliminar el evento. Inténtalo de nuevo.";
        }
    }

    // Manejar la eliminación de formularios de apoyo y citas de manera similar...
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar la eliminación de eventos
    if (isset($_POST['eliminar_formulario'])) {
        $id_formulario_apoyo = $_POST['id_formulario_apoyo'];
        
        // Aquí deberías agregar validaciones adicionales según tu lógica de negocio
        $sql_eliminar_formulario = "DELETE FROM formulario_apoyo WHERE id_formulario_apoyo = $id_formulario_apoyo";
        if ($conn->query($sql_eliminar_formulario) === TRUE) {
            $mensaje_formulario = "El formulario se eliminó correctamente.";
            // Redirigir después de eliminar (PRG pattern)
            header("Location: {$_SERVER['PHP_SELF']}");
            exit(); // Asegura que el script termine después de la redirección
        } else {
            $error_formulario = "Hubo un problema al eliminar el formulario. Inténtalo de nuevo.";
        }
    }

    // Manejar la eliminación de formularios de apoyo y citas de manera similar...
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar la eliminación de eventos
    if (isset($_POST['eliminar_cita'])) {
        $id_cita = $_POST['id_cita'];
        
        // Aquí deberías agregar validaciones adicionales según tu lógica de negocio
        $sql_eliminar_cita = "DELETE FROM citas WHERE id_cita = $id_cita";
        if ($conn->query($sql_eliminar_cita) === TRUE) {
            $mensaje_cita = "El cita se eliminó correctamente.";
            // Redirigir después de eliminar (PRG pattern)
            header("Location: {$_SERVER['PHP_SELF']}");
            exit(); // Asegura que el script termine después de la redirección
        } else {
            $error_cita = "Hubo un problema al eliminar el cita. Inténtalo de nuevo.";
        }
    }

}

    
    

// Cerrar la conexión a la base de datos
$conn->close();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
    <div class="container">
        <h1>Panel de Administración</h1>

        <a class="btn-volver" href="index.php">Volver al Index</a>

        <?php if (isset($mensaje_evento)) : ?>
            <div class="mensaje success"><?php echo $mensaje_evento; ?></div>
        <?php elseif (isset($error_evento)) : ?>
            <div class="mensaje error"><?php echo $error_evento; ?></div>
        <?php endif; ?>

        <?php if (isset($mensaje_formulario)) : ?>
            <div class="mensaje success"><?php echo $mensaje_formulario; ?></div>
        <?php elseif (isset($error_formulario)) : ?>
            <div class="mensaje error"><?php echo $error_formulario; ?></div>
        <?php endif; ?>

        <?php if (isset($mensaje_cita)) : ?>
            <div class="mensaje success"><?php echo $mensaje_cita; ?></div>
        <?php elseif (isset($error_cita)) : ?>
            <div class="mensaje error"><?php echo $error_cita; ?></div>
        <?php endif; ?>

        <!-- Formulario para agregar eventos -->
        <h2>Agregar Evento</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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
            <input type="submit" name="agregar_evento" value="Agregar Evento" class="btn-agregar">
            
        </form>

        <br><hr><br>

        <!-- Lista de Eventos -->
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
                        <td class="acciones">     
                            <!-- Enlace para seleccionar evento -->
                            <a class="seleccionar-evento" href="eventos.php?id_evento=<?php echo $evento['id_evento']; ?>">Seleccionar</a>
                        
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                                <input type="submit" name="eliminar_evento" value="Eliminar">
                            </form>                            
                            <form action="editar/editar_evento.php" method="POST">
                                <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                                <input type="submit" name="editar_evento" value="Editar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br><hr><br>

        <!-- Lista de Formularios de Apoyo -->
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
                                <input type="submit" name="eliminar_formulario" value="Eliminar">
                            </form>

                            <form action="editar/editar_formulario_apoyo.php" method="POST">
                                <input type="hidden" name="id_formulario_apoyo" value="<?php echo $formulario['id_formulario_apoyo']; ?>">
                                <input type="submit" name="editar_formulario" value="Editar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br><hr><br>

        <!-- Lista de Citas -->
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
                    <th>numero_documento</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Numero Ficha</th>
                    <th>Asunto</th>
                    <th>Fecha de Cita</th>
                    <th>Hora de Cita</th>
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
                                <input type="submit" name="eliminar_cita" value="Eliminar">
                            </form>

                            <form action="editar/editar_cita.php" method="POST">
                                <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($cita['id_cita']); ?>">
                                <input type="submit" name="editar_cita" value="Editar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</body>
</html>

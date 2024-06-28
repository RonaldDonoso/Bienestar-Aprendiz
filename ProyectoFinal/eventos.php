<?php
// Incluir el archivo de conexión a la base de datos
include 'includes/db_connection.php';

// Función para obtener el evento por su ID
function obtenerEventoPorId($conn, $id_evento) {
    $sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error al obtener el evento: " . mysqli_error($conn));
    }

    return mysqli_fetch_assoc($result); // Devuelve el evento como un array asociativo
}

// Función para obtener el ID del evento mostrado actualmente desde mostrar_evento
function obtenerIdEventoMostrado($conn) {
    $sql = "SELECT id_evento FROM mostrar_evento";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error al obtener el ID del evento mostrado: " . mysqli_error($conn));
    }

    // Verificar si hay filas devueltas
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['id_evento'];
    } else {
        return null; // Retornar null si no hay ningún evento mostrado
    }
}

// Función para obtener el evento actualmente mostrado
function obtenerEventoMostrado($conn) {
    $id_evento_mostrado = obtenerIdEventoMostrado($conn);

    if ($id_evento_mostrado !== null) {
        return obtenerEventoPorId($conn, $id_evento_mostrado);
    } else {
        return null; // Retornar null si no hay ningún evento mostrado
    }
}

// Verificar y obtener el evento mostrado actualmente
$evento = obtenerEventoMostrado($conn);

// Verificar si se ha proporcionado un ID de evento válido en la URL para actualizar mostrar_evento
if (isset($_GET['id_evento'])) {
    $id_evento = $_GET['id_evento'];

    // Actualizar el ID del evento mostrado en la tabla mostrar_evento
    $sql_update = "UPDATE mostrar_evento SET id_evento = $id_evento";
    $result_update = mysqli_query($conn, $sql_update);

    if (!$result_update) {
        die("Error al actualizar el ID del evento mostrado: " . mysqli_error($conn));
    }

    // Obtener y mostrar el evento correspondiente al ID proporcionado
    $evento = obtenerEventoPorId($conn, $id_evento);

    if ($evento === null) {
        echo "El evento con ID $id_evento no existe.";
        exit();
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Evento</title>
    <link rel="stylesheet" href="assets/eventos.css">
    <link rel="stylesheet" href="assets/index.css"> 
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="eventos.php">Eventos</a></li>
                <li><a href="apoyo_sostenible.php">Apoyo Sostenible</a></li>
                <li><a href="servicios.php">Servicios</a></li>
                <li><a href="quienes_somos.php">Quiénes Somos</a></li>
                <?php
                session_start();

                // Verificar si hay una sesión activa y el rol del usuario
                if(isset($_SESSION['id_usuario'])) {
                    // Aquí podrías consultar el rol del usuario desde la base de datos
                    $rol_usuario = $_SESSION['id_rol'];
                    
                    // Dependiendo del rol, puedes mostrar diferentes opciones en el menú
                    if($rol_usuario == 1) {
                        // Si es administrador
                        echo '<li><a href="admin.php">Panel de Administración</a></li>';
                    } else {
                        // Si es un usuario normal (rol 2, por ejemplo)
                        echo '<li><a href="perfil.php">Mi Perfil</a></li>';
                    }

                    echo '<li><a href="logout.php">Cerrar Sesión</a></li>';
                } else {
                    // Si no está logueado, mostrar opción de iniciar sesión
                    echo '<li><a href="login.php">Iniciar Sesión</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <br><br>
    <div class="container">
        <h1>Evento De La Semana</h1>
        <div>
            <?php if ($evento !== null): ?>
                <img src="imagenes/evento1.jpg" alt="" class="evento-img">
                <p><strong>Nombre:</strong> <?php echo $evento['nombre']; ?></p>
                <p><strong>Descripción:</strong> <?php echo $evento['descripcion']; ?></p>
                <p><strong>Fecha del Evento:</strong> <?php echo $evento['fecha_evento']; ?></p>
                <p><strong>Hora del Evento:</strong> <?php echo $evento['hora_evento']; ?></p>
                <p><strong>Lugar:</strong> <?php echo $evento['lugar']; ?></p>
            <?php else: ?>
                <p>No hay ningún evento actualmente mostrado.</p>
            <?php endif; ?>
        </div>
        <br>
    </div>
</body>
</html>

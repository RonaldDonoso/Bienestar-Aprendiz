<?php
include 'includes/db_connection.php';

function obtenerEventoPorId($conn, $id_evento) {
    $sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error al obtener el evento: " . mysqli_error($conn));
    }

    return mysqli_fetch_assoc($result); 
}

function obtenerIdEventoMostrado($conn) {
    $sql = "SELECT id_evento FROM mostrar_evento";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error al obtener el ID del evento mostrado: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['id_evento'];
    } else {
        return null; 
    }
}

function obtenerEventoMostrado($conn) {
    $id_evento_mostrado = obtenerIdEventoMostrado($conn);

    if ($id_evento_mostrado !== null) {
        return obtenerEventoPorId($conn, $id_evento_mostrado);
    } else {
        return null; 
    }
}

$evento = obtenerEventoMostrado($conn);

if (isset($_GET['id_evento'])) {
    $id_evento = $_GET['id_evento'];

    $sql_update = "UPDATE mostrar_evento SET id_evento = $id_evento";
    $result_update = mysqli_query($conn, $sql_update);

    if (!$result_update) {
        die("Error al actualizar el ID del evento mostrado: " . mysqli_error($conn));
    }

    $evento = obtenerEventoPorId($conn, $id_evento);

    if ($evento === null) {
        echo "El evento con ID $id_evento no existe.";
        exit();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Evento</title>
    <link rel="stylesheet" href="eventos.css">
    <link rel="stylesheet" href="index.css"> 
</head>
<body>
<header>
        <nav>
            <ul>
                <li><img class="logo-header" src="imagenes\logo-b.png" alt="a"></li>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="eventos.php">Eventos</a></li>
                <li><a href="apoyo_sostenible.php">Apoyo Sostenible</a></li>
                <li><a href="servicios.php">Servicios</a></li>
                <li><a href="quienes_somos.php">Quiénes Somos</a></li>
                <?php
                session_start();

                if(isset($_SESSION['id_usuario'])) {
                    $rol_usuario = $_SESSION['id_rol'];
                    
                    if($rol_usuario == 1) { echo '<li><a href="admin.php">Panel de Administración</a></li>';} 

                    echo '<li><a href="logout.php">Cerrar Sesión</a></li>';
                } else {
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

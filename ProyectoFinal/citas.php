<?php
session_start();

require_once "includes/db_connection.php";

$primer_nombre = '';
$segundo_nombre = '';
$primer_apellido = '';
$segundo_apellido = '';
$tipo_documento = '';
$numero_documento = '';
$correo = '';
$telefono = '';
$num_ficha = '';
$asunto = '';
$fecha = '';
$hora = '';
$estado_cita = '';

function agregarCita($conn, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono, $num_ficha, $asunto, $fecha, $hora, $estado_cita) {
    $stmt = $conn->prepare("INSERT INTO citas (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, tipo_documento, numero_documento, correo, telefono, num_ficha, asunto, fecha, hora, estado_cita) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono, $num_ficha, $asunto, $fecha, $hora, $estado_cita);
    
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
        return false;
    }
}

$mensaje_evento = '';
$error_evento = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_cita'])) {
    $primer_nombre = htmlspecialchars($_POST['primer_nombre']);
    $segundo_nombre = htmlspecialchars($_POST['segundo_nombre']);
    $primer_apellido = htmlspecialchars($_POST['primer_apellido']);
    $segundo_apellido = htmlspecialchars($_POST['segundo_apellido']);
    $tipo_documento = htmlspecialchars($_POST['tipo_documento']);
    $numero_documento = htmlspecialchars($_POST['numero_documento']);
    $correo = htmlspecialchars($_POST['correo']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $num_ficha = htmlspecialchars($_POST['num_ficha']);
    $asunto = htmlspecialchars($_POST['asunto']);
    $fecha = htmlspecialchars($_POST['fecha']);
    $hora = htmlspecialchars($_POST['hora']);
    $estado_cita = "Pendiente"; 
    
    if (!empty($primer_nombre) && !empty($primer_apellido) && !empty($tipo_documento) && !empty($numero_documento) && !empty($correo) && !empty($telefono) && !empty($num_ficha) && !empty($asunto) && !empty($fecha) && !empty($hora)) {
        
        if (agregarCita($conn, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono, $num_ficha, $asunto, $fecha, $hora, $estado_cita)) {
            $primer_nombre = '';
            $segundo_nombre = '';
            $primer_apellido = '';
            $segundo_apellido = '';
            $tipo_documento = '';
            $numero_documento = '';
            $correo = '';
            $telefono = '';
            $num_ficha = '';
            $asunto = '';
            $fecha = '';
            $hora = '';

            $_SESSION['mensaje_evento'] = "La cita se agregó correctamente.";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $error_evento = "Hubo un problema al agregar la cita. Inténtalo de nuevo.";
        }
    } else {
        $error_evento = "Todos los campos son obligatorios.";
    }
}

if (isset($_SESSION['mensaje_evento'])) {
    $mensaje_evento = $_SESSION['mensaje_evento'];
    unset($_SESSION['mensaje_evento']);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
    <link rel="stylesheet" href="apoyo_sostenible.css">
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

    <div class="container">
        <h2>Agendar Cita</h2>

        <?php
        if (!empty($mensaje_evento)) {
            echo "<p class='mensaje'>$mensaje_evento</p>";
        }
        if (!empty($error_evento)) {
            echo "<p class='error'>$error_evento</p>";
        }
        ?>

        <h3>Formulario Para Agendar Tu Cita</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="primer_nombre">Primer Nombre:</label>
            <input type="text" id="primer_nombre" name="primer_nombre" value="<?php echo htmlspecialchars($primer_nombre); ?>" required>
            <br><br>
            <label for="segundo_nombre">Segundo Nombre:</label>
            <input type="text" id="segundo_nombre" name="segundo_nombre" value="<?php echo htmlspecialchars($segundo_nombre); ?>">
            <br><br>
            <label for="primer_apellido">Primer Apellido:</label>
            <input type="text" id="primer_apellido" name="primer_apellido" value="<?php echo htmlspecialchars($primer_apellido); ?>" required>
            <br><br>
            <label for="segundo_apellido">Segundo Apellido:</label>
            <input type="text" id="segundo_apellido" name="segundo_apellido" value="<?php echo htmlspecialchars($segundo_apellido); ?>">
            <br><br>
            <label for="tipo_documento">Tipo de Documento:</label>
            <select id="tipo_documento" name="tipo_documento" required>
                <option value="cedula">Cédula de Ciudadanía</option>
                <option value="tarjeta_identidad">Tarjeta de Identidad</option>
            </select>
            <br><br>
            <label for="numero_documento">Número de Documento:</label>
            <input type="text" id="numero_documento" name="numero_documento" value="<?php echo htmlspecialchars($numero_documento); ?>" required>
            <br><br>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
            <br><br>
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
            <br><br>
            <label for="num_ficha">Número de Ficha:</label>
            <input type="text" id="num_ficha" name="num_ficha" value="<?php echo htmlspecialchars($num_ficha); ?>" required>
            <br><br>
            <label for="asunto">Asunto:</label>
            <input type="text" id="asunto" name="asunto" value="<?php echo htmlspecialchars($asunto); ?>" required>
            <br><br>
            <label for="fecha">Fecha de la Cita:</label>
            <input type="date" id="fecha" name="fecha" required>
            <br><br>
            <label for="hora">Hora de la Cita:</label>
            <input type="time" id="hora" name="hora" required>
            <br><br>    
            <input type="submit" name="agregar_cita" value="Agregar Cita" class="btn-agregar">
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> | Equipo Joggo Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
<script src="apoyo.js"></script>

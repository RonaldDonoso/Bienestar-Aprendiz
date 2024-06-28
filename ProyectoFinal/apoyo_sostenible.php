<?php
session_start();

// Incluir el archivo de conexión a la base de datos
require_once "includes/db_connection.php";

// Inicializar variables para evitar errores de "Undefined variable"
$nombre_apoyo = '';
$primer_nombre = '';
$segundo_nombre = '';
$primer_apellido = '';
$segundo_apellido = '';
$tipo_documento = '';
$numero_documento = '';
$correo = '';
$telefono = '';

// Función para agregar un nuevo formulario de apoyo
function agregarFormulario($conn, $nombre_apoyo, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono) {
    // Utilizar consultas preparadas para evitar inyección SQL
    $stmt = $conn->prepare("INSERT INTO formulario_apoyo (nombre_apoyo, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, tipo_documento, numero_documento, correo, telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nombre_apoyo, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Mensajes de éxito o error
$mensaje_evento = '';
$error_evento = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_formulario'])) {
    $nombre_apoyo = $_POST['nombre_apoyo'];
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Validar que todos los campos requeridos estén llenos
    if (!empty($nombre_apoyo) && !empty($primer_nombre) && !empty($segundo_nombre) && !empty($primer_apellido) && !empty($segundo_apellido) && !empty($tipo_documento) && !empty($numero_documento) && !empty($correo) && !empty($telefono)) {
        if (agregarFormulario($conn, $nombre_apoyo, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono)) {
            // Limpiar los campos del formulario después de la inserción exitosa (si es necesario)
            $nombre_apoyo = '';
            $primer_nombre = '';
            $segundo_nombre = '';
            $primer_apellido = '';
            $segundo_apellido = '';
            $tipo_documento = '';
            $numero_documento = '';
            $correo = '';
            $telefono = '';

            // Mensaje de éxito
            $_SESSION['mensaje_evento'] = "El formulario se agregó correctamente.";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $error_evento = "Hubo un problema al agregar el formulario. Inténtalo de nuevo.";
        }
    } else {
        $error_evento = "Todos los campos son obligatorios.";
    }
}

// Verificar si hay un mensaje de éxito en la sesión y limpiarlo después de mostrarlo
if (isset($_SESSION['mensaje_evento'])) {
    $mensaje_evento = $_SESSION['mensaje_evento'];
    unset($_SESSION['mensaje_evento']);
}

// Cerrar la conexión a la base de datos al finalizar todas las operaciones
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="apoyo_sostenible.css">
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
                // Verificar si hay una sesión activa y el rol del usuario
                if(isset($_SESSION['id_usuario'])) {
                    $rol_usuario = $_SESSION['id_rol'];
                    
                    if($rol_usuario == 1) {
                        echo '<li><a href="admin.php">Panel de Administración</a></li>';
                    } else {
                        echo '<li><a href="perfil.php">Mi Perfil</a></li>';
                    }

                    echo '<li><a href="logout.php">Cerrar Sesión</a></li>';
                } else {
                    echo '<li><a href="login.php">Iniciar Sesión</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Apoyo Sostenible</h2>

        <!-- Slider con fotos de los apoyos actuales -->
        <div class="slider-container">
            <div class="slider">
                <div class="slide"><img src="imagenes/evento1.jpg" alt="Apoyo 1"></div>
                <div class="slide"><img src="imagenes/evento2.png" alt="Apoyo 2"></div>
                <div class="slide"><img src="imagenes/evento3.jpg" alt="Apoyo 3"></div>
                <!-- Agregar más imágenes según sea necesario -->
            </div>
        </div>

        <!-- Requisitos para postularse -->
        <h3>Requisitos para Postularse</h3>
        <ul>
            <li>Descripción de los requisitos 1.</li>
            <li>Descripción de los requisitos 2.</li>
            <li>Descripción de los requisitos 3.</li>
            <!-- Agregar más requisitos según sea necesario -->
        </ul>

        <!-- Formulario para postularse -->
        <h3>Formulario de Postulación</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nombre_apoyo">Nombre del Apoyo:</label>
            <select id="nombre_apoyo" name="nombre_apoyo" required>
                <option value="alimentacion">Alimentación</option>
                <option value="economico">Apoyo Económico</option>
                <option value="transporte">Transporte</option>
            </select>
            <br><br>
            <label for="primer_nombre">Primer Nombre:</label>
            <input type="text" id="primer_nombre" name="primer_nombre" value="<?php echo htmlspecialchars($primer_nombre); ?>" required>
            <br><br>
            <label for="segundo_nombre">Segundo Nombre:</label>
            <input type="text" id="segundo_nombre" name="segundo_nombre" value="<?php echo htmlspecialchars($segundo_nombre); ?>" required>
            <br><br>
            <label for="primer_apellido">Primer Apellido:</label>
            <input type="text" id="primer_apellido" name="primer_apellido" value="<?php echo htmlspecialchars($primer_apellido); ?>" required>
            <br><br>
            <label for="segundo_apellido">Segundo Apellido:</label>
            <input type="text" id="segundo_apellido" name="segundo_apellido" value="<?php echo htmlspecialchars($segundo_apellido); ?>" required>
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
            <input type="submit" name="agregar_formulario" value="Agregar Formulario" class="btn-agregar">
        </form>

        <!-- Mensajes de éxito o error -->
        <?php
        if (!empty($mensaje_evento)) {
            echo "<p class='mensaje'>$mensaje_evento</p>";
        }
        if (!empty($error_evento)) {
            echo "<p class='error'>$error_evento</p>";
        }
        ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> | El Donosoxx Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

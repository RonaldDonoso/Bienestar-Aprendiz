<?php
session_start();

require_once "includes/db_connection.php";


$nombre_apoyo = '';
$primer_nombre = '';
$segundo_nombre = '';
$primer_apellido = '';
$segundo_apellido = '';
$tipo_documento = '';
$numero_documento = '';
$correo = '';
$telefono = '';

function agregarFormulario($conn, $nombre_apoyo, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono) {
    $stmt = $conn->prepare("INSERT INTO formulario_apoyo (nombre_apoyo, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, tipo_documento, numero_documento, correo, telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nombre_apoyo, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

$mostrar_formulario = (isset($_SESSION['mostrar_apoyo_sostenible']) && $_SESSION['mostrar_apoyo_sostenible']);


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

    if (!empty($nombre_apoyo) && !empty($primer_nombre) && !empty($segundo_nombre) && !empty($primer_apellido) && !empty($segundo_apellido) && !empty($tipo_documento) && !empty($numero_documento) && !empty($correo) && !empty($telefono)) {
        if (agregarFormulario($conn, $nombre_apoyo, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $tipo_documento, $numero_documento, $correo, $telefono)) {
            $nombre_apoyo = '';
            $primer_nombre = '';
            $segundo_nombre = '';
            $primer_apellido = '';
            $segundo_apellido = '';
            $tipo_documento = '';
            $numero_documento = '';
            $correo = '';
            $telefono = '';

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
    <title>Apoyo Sostenible</title>
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
        <h2>Apoyo Sostenible</h2>
        <div class="slider2">
              <div class="slide"><img src="imagenes/evento3.jpg" alt="Imagen 1"></div>
              <div class="slide"><img src="imagenes/evento1.jpg" alt="Imagen 2"></div>
              <div class="slide"><img src="imagenes/evento3.jpg" alt="Imagen 3"></div>
              <div class="slide"><img src="imagenes/evento2.png" alt="Imagen 4"></div>
              <div class="slide"><img src="imagenes/evento3.jpg" alt="Imagen 3"></div>
              <div class="slide"><img src="imagenes/evento2.png" alt="Imagen 4"></div>
          </div>

        <h3>Requisitos para Postularse</h3>
        <ul>
            <li>Encontrarse en estado de induccion o en formuacion en el aplicativo Sofia Plus.</li>
            <li>No tener condicionamiento de matricula conforme a lo estipulado en el reglamento al Aprendiz.</li>
            <li>Diligenciar adecuadamente el formato de registro socioeconomico que facilite el Centro de formacion.</li>
            <li>No ser beneficiario de apoyos de sostenimiento regular o FIC</li>
        </ul>
    <?php if ($mostrar_formulario) : ?>

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

        <?php
        if (!empty($mensaje_evento)) {
            echo "<p class='mensaje'>$mensaje_evento</p>";
        }
        if (!empty($error_evento)) {
            echo "<p class='error'>$error_evento</p>";
        }
        ?>
    <?php endif; ?>

    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('d m Y'); ?> | Equipo Joggo Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
<script src="apoyo.js"></script>

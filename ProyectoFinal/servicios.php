<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="servicios.css">
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
        <h2>Servicios</h2>

        <!-- Servicio de Psicología -->
        <div class="service">
            <h3>Psicología</h3>
            <p>Descripción del servicio de psicología ofrecido por tu organización.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <!-- Servicio de Cultura -->
        <div class="service">
            <h3>Cultura</h3>
            <p>Descripción del servicio cultural ofrecido por tu organización.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <!-- Servicio de Prácticas de Prevención de la Enfermedad y Promoción de la Salud -->
        <div class="service">
            <h3>Prácticas de Prevención de la Enfermedad y Promoción de la Salud</h3>
            <p>Descripción del servicio de prevención y promoción de la salud ofrecido por tu organización.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <!-- Servicio de Desarrollo de Habilidades Blandas -->
        <div class="service">
            <h3>Desarrollo de Habilidades Blandas</h3>
            <p>Descripción del servicio de desarrollo de habilidades blandas ofrecido por tu organización.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <!-- Servicio de Deporte y Actividad Física -->
        <div class="service">
            <h3>Deporte y Actividad Física</h3>
            <p>Descripción del servicio de deporte y actividad física ofrecido por tu organización.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <!-- Servicio de Aprovechamiento del Tiempo Libre y Arte -->
        <div class="service">
            <h3>Aprovechamiento del Tiempo Libre y Arte</h3>
            <p>Descripción del servicio de aprovechamiento del tiempo libre y arte ofrecido por tu organización.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('d m Y'); ?> | El Donosoxx Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>

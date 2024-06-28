<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiénes Somos</title>
    <link rel="stylesheet" href="quienes_somos.css">
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

    <div class="container">
        <h2>Quiénes Somos</h2>
        
        <div class="about-us">
            <img src="imagenes/equipo_bienestar.jpg" alt="Imagen Representativa">
            <p>Somos una organización dedicada a...</p>
            <p>Nuestra misión es...</p>
            <p>Nuestra visión es...</p>
            <p>Nuestros valores son...</p>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('d m Y'); ?> | El Donosoxx Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>

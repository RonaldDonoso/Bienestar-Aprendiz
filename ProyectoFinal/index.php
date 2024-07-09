<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
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

    <section id="banner">
        <div class="banner-text">
        <h1>Bienvenido a Bienestar al Aprendiz CDITI</h1>
        <p>Bienestar al Aprendiz SENA enriquece la experiencia educativa ofreciendo servicios como asesorías psicológicas, programas culturales, prevención de enfermedades, actividades deportivas, desarrollo de habilidades blandas, arte y tiempo libre. Apoyamos el bienestar integral de los aprendices, promoviendo su crecimiento personal y profesional.</p>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <h2>¿Quiénes Somos?</h2>
            <p>Bienestar al Aprendiz SENA se compromete con el desarrollo integral de cada aprendiz, ofreciendo programas y servicios que fortalecen su bienestar físico, emocional y social. Nuestra misión es proporcionar un ambiente de apoyo que potencie el aprendizaje y el crecimiento personal, fomentando una comunidad educativa saludable y participativa.</p>
            <p>Nuestra visión es ser reconocidos como líderes en la promoción del bienestar estudiantil dentro del SENA, destacándonos por la excelencia en la entrega de servicios que contribuyan al éxito académico y al desarrollo integral de los aprendices.</p>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <h2>Nuestros Servicios</h2>
            <ul>
                <li>Psicología</li>
                <li>Cultura</li>
                <li>Prevención de Enfermedades</li>
                <li>Desarrollo de Habilidades Blandas</li>
                <li>Deporte y Actividad Física</li>
                <li>Arte y Aprovechamiento del Tiempo Libre</li>
            </ul>
        </div>
    </section>

    <section id="events">
        <div class="container">
            <h2>Próximos Eventos</h2>
            <p>Lista de próximos eventos o enlaces a la sección de eventos.</p>
            <a href="eventos.php" class="button">Ver Eventos</a>
        </div>
    </section>


    <footer>
        <div class="container">
            <p>&copy; <?php echo date('d m Y'); ?> | Equipo Joggo Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>

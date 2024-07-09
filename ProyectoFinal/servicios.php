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

    <div class="container">
        <h2>Servicios</h2>

        <div class="service">
            <h3>Psicología</h3>
            <p>Los servicios de Psicología de Bienestar al Aprendiz en SENA se refieren a los servicios y programas diseñados para apoyar el bienestar emocional y académico de los aprendices. Estos servicios pueden incluir asesoramiento psicológico individual o grupal, talleres para el manejo del estrés, desarrollo de habilidades sociales, y otras intervenciones psicológicas destinadas a mejorar la experiencia y el rendimiento académico de los estudiantes.</p>
        </div>

        <div class="service">
            <h3>Cultura</h3>
            <p>Bienestar al Aprendiz SENA se compromete no solo con el desarrollo académico, sino también con el bienestar integral de sus estudiantes, ofreciendo una variedad de servicios culturales que enriquecen su experiencia educativa. Estos servicios están diseñados para fomentar el crecimiento personal, la integración social y el desarrollo de habilidades que complementen su formación técnica.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <div class="service">
            <h3>Prácticas de Prevención de la Enfermedad y Promoción de la Salud</h3>
            <p>En Bienestar al Aprendiz SENA, se enfatiza en prácticas para promover la salud y prevenir enfermedades. Esto incluye programas dedicados a nutrición saludable, actividades físicas variadas para mejorar la condición física, apoyo emocional para manejar el estrés y fortalecer la resiliencia, así como educación en medidas preventivas y acceso facilitado a servicios médicos cuando se necesite atención. Estas iniciativas buscan crear un ambiente óptimo que favorezca el bienestar integral y el rendimiento académico de los estudiantes.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <div class="service">
            <h3>Desarrollo de Habilidades Blandas</h3>
            <p>En Bienestar al Aprendiz SENA, se promueve el desarrollo de habilidades blandas como parte fundamental del crecimiento personal y profesional. Esto incluye programas diseñados para fortalecer la comunicación efectiva, el trabajo en equipo colaborativo, la resolución de problemas, la creatividad y la capacidad de adaptación. Estas habilidades son clave para mejorar la empleabilidad, fomentar liderazgos positivos y potenciar el desarrollo integral de los aprendices, preparándolos para enfrentar con éxito los desafíos del entorno laboral y social.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <div class="service">
            <h3>Deporte y Actividad Física</h3>
            <p>En Bienestar al Aprendiz SENA, se fomenta la práctica regular de deporte y actividad física como pilares fundamentales para la salud integral de los aprendices. Estas actividades no solo promueven el bienestar físico, sino también contribuyen al manejo del estrés, la mejora de la concentración y el fortalecimiento de habilidades sociales. A través de programas deportivos y recreativos, se busca crear espacios que favorezcan la integración, el compañerismo y el desarrollo de hábitos de vida saludable, asegurando así un ambiente propicio para el aprendizaje y el crecimiento personal de los participantes.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>

        <div class="service">
            <h3>Aprovechamiento del Tiempo Libre y Arte</h3>
            <p>En Bienestar al Aprendiz SENA, se promueve el aprovechamiento del tiempo libre a través del arte como herramienta para el desarrollo personal y cultural. Los programas y actividades artísticas ofrecen espacios para la creatividad, la expresión y el aprendizaje continuo. Esto no solo enriquece la experiencia educativa, sino que también fomenta la autonomía, el sentido de pertenencia y la valoración de la diversidad cultural, contribuyendo así al bienestar integral de los aprendices.</p>
            <p>Más detalles y enlaces relevantes.</p>
        </div>
    
    </div>

    <section id="events">
            <h2>Agendar Cita</h2>
            <p>Aqui podras agendar tu cita.</p>
            <a href="citas.php" class="button">Formulario Citas </a>
    </section>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('d m Y'); ?> | Equipo Joggo Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quienes Somos</title>
    <link rel="stylesheet" href="quienes_somos.css">
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
                <li><a href="quienes_somos.php">Quienes Somos</a></li>
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
        <h2>Quiénes Somos</h2>
        
        <div class="about-us">
            <img src="imagenes/equipo_bienestar.jpg" alt="Imagen Representativa">
            <p>Somos una estrategia que contribuye a brindar servicios a los aprendices en formación de los programas técnicos y tecnológicos de las modalidades , presencial, virtual y a distancia con el fin de promover acciones que permitan fortalecer sus competencias y habilidades socioemocionales, deportivas, artísticas, de liderazgo, culturales , brindar información sobre la promoción de la salud y prevención de la enfermedad, ofrecer apoyos socioeconómicos para el mejoramiento de su calidad de vida y la satisfacción de culminar  su proceso formativo  con éxito</p>
            <h2>¿Qué hace el área de Bienestar al Aprendiz?</h2>
            <p>Nuestro objetivo general es contribuir al desarrollo humano integral de los aprendices, por medio de la definición de lineamientos que se implementen de manera articulada y gradual con el proceso de formación profesional integral, con el fin de fortalecer la cultura de bienestar entre los aprendices y la comunidad educativa.</p>
            <h2>Mision</h2>
            <p>Nuestra misión es promover las condiciones de bienestar durante el desarrollo de la FPI de los aprendices del SENA, mediante la formulación y seguimiento a la ejecución del PNIBA y la implementación y seguimiento al programa de atención al egresado</p>
            <h2>Vision</h2>
            <p>Nuestra visión es lograr que aprendices y egresados sean referentes de consulta permanente para la toma de decisiones estrategicas de la entidad, de tal forma que se garantice participación e inclusión diferencial.</p>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('d m Y'); ?> | Equipo Joggo Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventos</title>
  <link rel="stylesheet" href="eventos.css">
</head>
<body>
    <header>
        <img class="logo" src="../img/logo1.png" alt="Logo">
        <h1>Bienestar al Aprendiz</h1>
    </header>
    <nav>
        <a href="../index.html">Inicio</a>
        <a href="../servicios.html">Servicios</a>
        <a href="../apoyos/apoyos.html">Apoyos</a>
        <a href="evento.php">Eventos</a>
        <a href="../quienessomos.html">Quienes Somos</a>
    </nav>

    <main>
        <section id="eventos">
            <h1>Eventos</h1>
            
            <div class="slider-container">
                <div class="slider">
                    <img src="../img/evento1.jpg" alt="Image 1">
                    <img src="../img/evento2.png" alt="Image 2">
                    <img src="../img/evento3.jpg" alt="Image 3">
                </div>
                <button class="prev" onclick="prevSlide()">&#10094;</button>
                <button class="next" onclick="nextSlide()">&#10095;</button>
            </div>
          
            <div class="info-evento">
                <?php include 'mostrar.php'; ?>
            </div>
        </section>
    </main>

    <button onclick="location.href='agregar_evento.php'">Agregar Evento</button>
            <form action="evento.php" method="GET">
                <label for="id_evento">Mostrar evento por ID:</label>
                <input type="text" id="id_evento" name="id_evento">
                <input type="submit" value="Mostrar">
            </form>

    <footer>
        <div class="redes-sociales">
            <a href="#"><img src="../img/facebook2.png" alt="Facebook" width="40px" height="40px"></a>
            <a href="#"><img src="../img/twitter2.png" alt="Twitter" width="40px" height="40px"></a>
            <a href="https://www.instagram.com/bienestar_cditi/"><img src="../img/instagram2.png" alt="Instagram" width="40px" height="40px"></a>
        </div>
        <p> © 2024 Bienestar al Aprendiz</p>
    </footer>
</body>
</html>

<script src="eventos.js"></script>

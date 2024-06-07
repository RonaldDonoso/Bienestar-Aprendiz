<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Evento</title>
    <link rel="stylesheet" href="a_eventos.css">
</head>
<body>
    <header>
        <h1>Agregar Evento</h1>
    </header>
    
    <main>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "123456";
            $dbname = "bd_bienestar";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and bind the INSERT statement
            $stmt = $conn->prepare("INSERT INTO crear_evento (nombre, descripcion, aforo, fecha_evento, hora_evento, fecha_i_inscripcion, fecha_f_inscripcion, lugar, id_clasificacion_evento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $nombre, $descripcion, $aforo, $fecha_evento, $hora_evento, $fecha_i_inscripcion, $fecha_f_inscripcion, $lugar, $id_clasificacion_evento);

            // Set parameters and execute
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $aforo = $_POST["aforo"];
            $fecha_evento = $_POST["fecha_evento"];
            $hora_evento = $_POST["hora_evento"];
            $fecha_i_inscripcion = $_POST["fecha_i_inscripcion"];
            $fecha_f_inscripcion = $_POST["fecha_f_inscripcion"];
            $lugar = $_POST["lugar"];
            $id_clasificacion_evento = $_POST["id_clasificacion_evento"];

            $stmt->execute();

            echo "Evento agregado exitosamente.";

            $stmt->close();
            $conn->close();
        }
        ?>
        
        <form method="post">
            <label for="nombre">Nombre del Evento:</label><br>
            <input type="text" id="nombre" name="nombre"><br>
            
            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion"></textarea><br>
            
            <label for="aforo">Aforo:</label><br>
            <input type="text" id="aforo" name="aforo"><br>
            
            <label for="fecha_evento">Fecha del Evento:</label><br>
            <input type="date" id="fecha_evento" name="fecha_evento"><br>
            
            <label for="hora_evento">Hora del Evento:</label><br>
            <input type="time" id="hora_evento" name="hora_evento"><br>
            
            <label for="fecha_i_inscripcion">Fecha de inicio de inscripción:</label><br>
            <input type="date" id="fecha_i_inscripcion" name="fecha_i_inscripcion"><br>
            
            <label for="fecha_f_inscripcion">Fecha de fin de inscripción:</label><br>
            <input type="date" id="fecha_f_inscripcion" name="fecha_f_inscripcion"><br>
            
            <label for="lugar">Lugar:</label><br>
            <input type="text" id="lugar" name="lugar"><br>
            
            <label for="id_clasificacion_evento">ID de clasificación del evento:</label><br>
            <input type="text" id="id_clasificacion_evento" name="id_clasificacion_evento"><br>
            
            <input type="submit" value="Agregar Evento">
        </form>
        
        <button onclick="location.href='evento.php'">Volver Atras</button>
    </main>
</body>
</html>

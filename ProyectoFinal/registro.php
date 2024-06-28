<?php
session_start();

// Simular conexión a la base de datos
include('includes/db_connection.php');

// Variables para los mensajes de error y éxito
$error = "";
$success = "";

// Procesar el formulario de registro
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $telefono = $_POST['telefono'];
    
    // Verificar si el correo ya está registrado
    $query = "SELECT * FROM usuario WHERE correo = '$correo'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $error = "El correo ya está registrado.";
    } else {
        // Hashear la contraseña antes de almacenarla en la base de datos
        $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);
        
        // Insertar nuevo usuario en la base de datos
        $insert_query = "INSERT INTO usuario (id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, correo, contraseña, id_rol, tipo_documento, numero_documento, telefono)
                VALUES (NULL, '$primer_nombre', '$segundo_nombre', '$primer_apellido', '$segundo_apellido', '$correo', '$hashed_password', '2', '$tipo_documento', '$numero_documento', '$telefono')";

        if(mysqli_query($conn, $insert_query)) {
            $success = "¡Registro exitoso! Puedes iniciar sesión <a href='login.php'>aquí</a>.";
        } else {
            $error = "Error al registrar el usuario: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="assets/registro.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="primer_nombre">Primer Nombre:</label>
            <input type="text" id="primer_nombre" name="primer_nombre" required>
            <br><br>
            <label for="segundo_nombre">Segundo Nombre:</label>
            <input type="text" id="segundo_nombre" name="segundo_nombre">
            <br><br>
            <label for="primer_apellido">Primer Apellido:</label>
            <input type="text" id="primer_apellido" name="primer_apellido" required>
            <br><br>
            <label for="segundo_apellido">Segundo Apellido:</label>
            <input type="text" id="segundo_apellido" name="segundo_apellido">
            <br><br>
            <label for="tipo_documento">Tipo de Documento:</label>
            <select id="tipo_documento" name="tipo_documento" required>
                <option value="Cédula">Cédula</option>
                <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
            </select>
            <br><br>
            <label for="numero_documento">Número de Documento:</label>
            <input type="text" id="numero_documento" name="numero_documento" required>
            <br><br>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>
            <br><br>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            <br><br>
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>
            <br><br>
            <button type="submit">Registrarse</button>
        </form>
        <?php if(!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <?php if(!empty($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
    </div>
</body>
</html>

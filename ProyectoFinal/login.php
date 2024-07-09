<?php
session_start();

include('includes/db_connection.php');

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $username = mysqli_real_escape_string($conn, $username);
    
    $query = "SELECT * FROM usuario WHERE correo = '$username'";
    $result = mysqli_query($conn, $query);
    
    if($result) {
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row['contraseña'])) {
                $_SESSION['id_usuario'] = $row['id_usuario'];
                $_SESSION['id_rol'] = $row['id_rol'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    } else {
        $error = "Error en la consulta: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/login.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Usuario (Correo):</label>
                <input type="email" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php if(isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
    </div>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "bd_bienestar";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}
?>

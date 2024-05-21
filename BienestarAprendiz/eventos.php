<?php
// Va a incluir las funciones necesarias del archivo "funciones.php"
include("funciones.php");

// Va a requerir el archivo de configuración "config.php" que contiene los datos de conexión a la base de datos
require('config.php');

// Establece una conexión con la base de datos utilizando los valores de "config.php"
$conexion = mysqli_connect($host, $user, $password, $database);



?>
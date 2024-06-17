<?php

// Va a requerir el archivo de configuración "config.php" que contiene los datos de conexión a la base de datos
require('../config.php');

// Establece una conexión con la base de datos utilizando los valores de "config.php"
$conn = mysqli_connect($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$primer_nombre = $_POST['primer_nombre'];
$segundo_nombre = $_POST['segundo_nombre'];
$primer_apellido = $_POST['primer_apellido'];
$segundo_apellido = $_POST['segundo_apellido'];
$id_tipo_documento = $_POST['id_tipo_documento'];
$num_documento = $_POST['num_documento'];
$correo = $_POST['correo'];
$id_clasificacion_evento = $_POST['id_clasificacion_evento'];

// Convertir el tipo de documento a valores numéricos
if ($id_tipo_documento === "Tarjeta") {
    $id_tipo_documento = 1;
} elseif ($id_tipo_documento === "Cedula") {
    $id_tipo_documento = 2;
}

// Convertir la clasificación de evento a valores numéricos
if ($id_clasificacion_evento === "Apoyo de Alimentación") {
    $id_clasificacion_evento = 1;
} elseif ($id_clasificacion_evento === "Apoyo de Transporte") {
    $id_clasificacion_evento = 2;
}

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO formulario_apoyo (nombre_apoyo, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, id_tipo_documento, num_documento, correo, id_clasificacion_evento) VALUES ('Postularse', '$primer_nombre', '$segundo_nombre', '$primer_apellido', '$segundo_apellido', '$id_tipo_documento', '$num_documento', '$correo', '$id_clasificacion_evento')";

if ($conn->query($sql) === TRUE) {
    echo "success"; // Envía 'success' si la inserción es exitosa
} else {
    echo "Error al insertar datos: " . $conn->error; // Devuelve un mensaje de error específico
}

// Cerrar la conexión
$conn->close();
?>

<?php
// Verificar si se han enviado datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Requerir el archivo de configuración "config.php" que contiene los datos de conexión a la base de datos
    require('config.php');

    // Establecer una conexión con la base de datos utilizando los valores de "config.php"
    $conexion = mysqli_connect($host, $user, $password, $database);

    // Verificar la conexión
    if (!$conexion) {
        die("La conexión falló: " . mysqli_connect_error());
    }

    // Procesar los datos del formulario
    $primerNombre = $_POST['primer_nombre'];
    $segundoNombre = $_POST['segundo_nombre'];
    $primerApellido = $_POST['primer_apellido'];
    $segundoApellido = $_POST['segundo_apellido'];
    $idTipoDocumento = $_POST['id_tipo_documento'];
    $numDocumento = $_POST['num_documento'];
    $correo = $_POST['correo'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO formulario_apoyo (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, id_tipo_documento, num_documento, correo) 
            VALUES ('$primerNombre', '$segundoNombre', '$primerApellido', '$segundoApellido', '$idTipoDocumento', '$numDocumento', '$correo')";

    // Ejecutar la consulta SQL
    if (mysqli_query($conexion, $sql)) {
        echo "¡Registro creado exitosamente!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    // Si no se han enviado datos por POST, redirigir a la página de inicio o mostrar un mensaje de error
    echo "Error: No se han enviado datos por POST";
}
?>

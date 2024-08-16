<?php
include "conexion.php";

// Datos del nuevo administrador
$nombre = "nelson";
$apellido = "maas";
$email = "nelson@gmail.com";
$telefono = "1234567890";
// Si la columna 'asig' no existe, omítela y ajusta la consulta
$contraseña = md5("hola123");

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO usuarios (nombre, apellido, email, telefono, contraseña) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verificar si la preparación fue exitosa
if ($stmt) {
    // Vincular los parámetros y ejecutar la consulta
    $stmt->bind_param("sssss", $nombre, $apellido, $email, $telefono, $contraseña);

    if ($stmt->execute()) {
        echo "Administrador registrado con éxito.";
        header("location:index.html");
    } else {
        echo "Error al registrar administrador: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>

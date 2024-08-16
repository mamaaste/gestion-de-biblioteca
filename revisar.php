<?php
include "conexion.php";
// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$DPi = $_POST['DPI'];
$telefono = $_POST['telefono'];

// Insertar datos en la tabla viajeros
$sql = "INSERT INTO viajeros (nombre, apellido, email, telefono) VALUES ('$nombre', '$apellido', '$email', '$telefono')";

if ($conn->query($sql) === TRUE) {
    echo "Viajero registrado con éxito.";
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    header("location:index.html");
}

$conn->close();
?>

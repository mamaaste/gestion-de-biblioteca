<?php
session_start();
include "conexion.php";

// Obtener el código del formulario y cifrarlo en MD5
$pass = $_POST['codigo'];
$cla = md5($pass);

// Preparar la consulta para evitar inyección de SQL
$sql = "SELECT * FROM codigo WHERE codigo = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparando la consulta: " . $conn->error);
}

// Vincular parámetros y ejecutar la consulta
$stmt->bind_param("s", $cla);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si el código existe en la base de datos
if ($resultado->num_rows === 1) {
    header("Location: registroE.php");
    exit(); // Asegurarse de que el script se detenga después de la redirección
} else {
    header("Location: codigo.php");
    exit(); // Asegurarse de que el script se detenga después de la redirección
}

$stmt->close();
$conn->close();
?>

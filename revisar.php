<?php
include "conexion.php";

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$DPI = $_POST['DPI'];
$telefono = $_POST['telefono'];

// Validar que el DPI tenga 13 dígitos
if (strlen($DPI) !== 13 || !ctype_digit($DPI)) {
    $mensaje = "Error: El número de DPI debe tener exactamente 13 dígitos.";
    $tipo = "danger";
} else {
    // Verificar si el email o DPI ya existen en la base de datos
    $sql = "SELECT * FROM empleados WHERE email = ? OR DPI = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $DPI);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mensaje = "Error: El email o DPI ya están registrados.";
        $tipo = "danger";
    } else {
        // Insertar los datos si no existen duplicados
        $sql = "INSERT INTO empleados (nombre, apellido, email, DPI, telefono) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $nombre, $apellido, $email, $DPI, $telefono);

        if ($stmt->execute()) {
            $mensaje = "Empleado registrado con éxito.";
            $tipo = "success";
        } else {
            $mensaje = "Error: " . $stmt->error;
            $tipo = "danger";
        }
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-<?php echo $tipo; ?> text-center" role="alert">
            <?php echo $mensaje; ?>
        </div>
        <div class="text-center">
            <a href="registroE.html" class="btn btn-primary">Regresar al inicio</a>
        </div>
    </div>
</body>
</html>

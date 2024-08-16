<?php
session_start();
include "conexion.php";

// Obtener datos del formulario
$email = $_POST['email'];
$DPI = $_POST['DPI'];

// Validar que el DPI tenga 13 dígitos
if (strlen($DPI) !== 13 || !ctype_digit($DPI)) {
    $mensaje = "Error: El número de DPI debe tener exactamente 13 dígitos.";
    $tipo = "danger";
} else {
    // Verificar si el email y DPI existen en la base de datos
    $sql = "SELECT * FROM empleados WHERE email = ? AND DPI = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $DPI);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Inicio de sesión exitoso
        $mensaje = "Inicio de sesión exitoso.";
        $tipo = "success";
        // Puedes iniciar una sesión aquí si deseas
        // session_start();
        // $_SESSION['email'] = $email;
        // header("Location: dashboard.php"); // Redirige a la página principal después de iniciar sesión
    } else {
        // Error en el inicio de sesión
        $mensaje = "Error: El email o DPI son incorrectos.";
        $tipo = "danger";
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
    <title>Resultado del Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="alert alert-<?php echo $tipo; ?> text-center" role="alert">
                <?php echo $mensaje; ?>
            </div>
            <div class="text-center mt-3">
                <a href="login.html" class="btn btn-primary">Regresar</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include "conexion.php";

// Obtener datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Cifrar la contraseña para la comparación
$hashed_password = md5($password);

// Verificar si el email y la contraseña coinciden en la base de datos
$sql = "SELECT * FROM usuarios WHERE email = ? AND contraseña = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hashed_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['id'] = $user['id'];
    $_SESSION['nombre'] = $user['nombre'];
    $_SESSION['rol'] = $user['rol'];

    // Redirigir según el rol
    if ($user['rol'] === 'administrador') {
        header("Location: registroE.php");
    } elseif ($user['rol'] === 'empleado') {
        header("Location: empleado.php");
    } elseif ($user['rol'] === 'cliente') {
        header("Location: cliente.php");
    }
    exit();
} else {
    $mensaje = "Email o contraseña incorrectos.";
}

$stmt->close();
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
            <div class="alert alert-danger text-center" role="alert">
                <?php echo isset($mensaje) ? $mensaje : ''; ?>
            </div>
            <div class="text-center mt-3">
                <a href="index.html" class="btn btn-primary">Regresar</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
include "conexion.php";

// Inicializar el mensaje como vacío
$mensaje = "";

// Verificar si se ha enviado el formulario y si la clave 'codigo' está definida
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo'])) {
    // Obtener datos del formulario
    $codigo = $_POST['codigo'];

    // Verificar si el código existe en la base de datos
    $sql = "SELECT * FROM codigo WHERE codigo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el código existe, redirige a otro formulario
        header("Location: registroE.php");
        exit();
    } else {
        // Si el código no existe, mostrar mensaje de error
        $mensaje = "Código no válido.";
    }
    $stmt->close();
} else {
    $mensaje = "Código no proporcionado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Verificación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if ($mensaje): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        <div class="text-center mt-3">
            <a href="codigo.php" class="btn btn-primary">Regresar</a>
        </div>
    </div>
</body>
</html>

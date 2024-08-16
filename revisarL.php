<?php
include 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$DPI = $_POST['DPI']; // Aunque no lo uses en la tabla, puedes validar si lo necesitas
$telefono = $_POST['telefono'];
$contraseña = md5($_POST['contraseña']); // Asegúrate de cifrar la contraseña de forma segura
$rol = $_POST['rol']; // Campo para seleccionar el rol del usuario

// Validar que el DPI tenga 13 dígitos
if (strlen($DPI) !== 13 || !ctype_digit($DPI)) {
    echo "Error: El número de DPI debe tener exactamente 13 dígitos.";
    exit;
}

// Validar que el rol sea uno de los valores permitidos
$roles_permitidos = ['administrador', 'empleado', 'cliente'];
if (!in_array($rol, $roles_permitidos)) {
    echo "Error: Rol no válido.";
    exit;
}

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO usuarios (nombre, apellido, email, telefono, rol, contraseña) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verificar si la preparación fue exitosa
if ($stmt) {
    // Vincular los parámetros y ejecutar la consulta
    $stmt->bind_param("ssssss", $nombre, $apellido, $email, $telefono, $rol, $contraseña);

    if ($stmt->execute()) {
        echo "Usuario registrado con éxito.";
        header("Location: index.html"); // Redirige a la página principal después de registrar
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>

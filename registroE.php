<?php
session_start();
if (!isset($_SESSION['nombre']) || !isset($_SESSION['id'])) {
    header('location: index.php');
    exit();
}

include 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $DPI = $_POST['DPI'];
    $telefono = $_POST['telefono'];
    $contraseña = md5($_POST['contraseña']); // Asegúrate de cifrar la contraseña de forma segura
    $rol = $_POST['rol'];

    // Validar DPI
    if (strlen($DPI) !== 13 || !ctype_digit($DPI)) {
        echo "Error: El número de DPI debe tener exactamente 13 dígitos.";
        exit();
    }

    // Validar rol
    $roles_permitidos = ['administrador', 'empleado', 'cliente'];
    if (!in_array($rol, $roles_permitidos)) {
        echo "Error: Rol no válido.";
        exit();
    }

    // Preparar e insertar en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido, email, telefono, rol, contraseña) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssss", $nombre, $apellido, $email, $telefono, $rol, $contraseña);

        if ($stmt->execute()) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "Error al registrar usuario: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
}

// Consulta para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

// Verificar si la consulta tuvo éxito
if ($result === false) {
    echo "Error en la consulta: " . $conn->error;
}
?>

<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
    <!-- Incluye Bootstrap para darle mejor estilo -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<section>
<div class="bg-image">
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center">Registro</h2>
            <form action="registroE.php" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="DPI">Número de DPI:</label>
                    <input type="text" id="DPI" name="DPI" pattern="\d{13}" maxlength="13" required title="El DPI debe tener 13 dígitos">
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select id="rol" name="rol" class="form-control" required>
                        <option value="administrador">Administrador</option>
                        <option value="empleado">Empleado</option>
                        <option value="cliente">Cliente</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Registrar Usuario</button>
            </form>
        </div>
    </div>
</div>
</section>

<section>
<div class="container mt-5">
        <h2 class="text-center">Listado de Usuarios</h2>
        <?php if (isset($result) && $result->num_rows > 0): ?>
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($row['rol']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">No se encontraron usuarios.</p>
        <?php endif; ?>
    </div>
</section>


<!-- Incluye Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

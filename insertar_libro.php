<?php
include 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

// Obtener datos del formulario
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$año_publicacion = $_POST['año_publicacion'];
$genero = $_POST['genero'];

// Verificar si el libro ya existe
$sql = "SELECT * FROM libros WHERE titulo = ? AND autor = ? AND año_publicacion = ? AND genero = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssis", $titulo, $autor, $año_publicacion, $genero);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Libro ya existe, actualizar la cantidad
        $row = $result->fetch_assoc();
        $new_cantidad = $row['cantidad'] + 1;

        $update_sql = "UPDATE libros SET cantidad = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_cantidad, $row['id']);

        if ($update_stmt->execute()) {
            echo "Cantidad del libro actualizada.";
        } else {
            echo "Error al actualizar la cantidad: " . $update_stmt->error;
        }

        $update_stmt->close();
    } else {
        // Libro no existe, insertar nuevo libro
        $insert_sql = "INSERT INTO libros (titulo, autor, año_publicacion, genero) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssis", $titulo, $autor, $año_publicacion, $genero);

        if ($insert_stmt->execute()) {
            echo "Libro registrado con éxito.";
        } else {
            echo "Error al registrar libro: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    }
} else {
    echo "Error al verificar el libro: " . $stmt->error;
}

// Cerrar la declaración
$stmt->close();

// Cerrar la conexión
$conn->close();
?>

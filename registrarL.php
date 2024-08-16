<?php
session_start();
if (!isset($_SESSION['nombre']) || !isset($_SESSION['id'])) {
    header('location: index.php');
    exit();
}
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Libros</title>
    <link rel="stylesheet" href="style.css">
    <!-- Incluye Bootstrap para darle mejor estilo -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<section>
    <div class="container mt-5">
        <h2 class="text-center">Registro de Libros</h2>
        <form action="insertar_libro.php" method="post">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="año_publicacion">Año de Publicación:</label>
                <input type="number" id="año_publicacion" name="año_publicacion" class="form-control" required min="1000" max="2100">
            </div>
            
            <div class="form-group">
                <label for="genero">Género:</label>
                <input type="text" id="genero" name="genero" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Registrar Libro</button>
        </form>
    </div>
</section>

<!-- Incluye Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

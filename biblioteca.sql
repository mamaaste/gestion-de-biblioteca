CREATE database biblioteca;
use biblioteca;
CREATE TABLE usuarios (
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    apellido VARCHAR(40) NOT NULL,
    email VARCHAR(45) NOT NULL UNIQUE,
    fechaD DATETIME DEFAULT CURRENT_TIMESTAMP,
    telefono VARCHAR(15) NOT NULL,
    rol ENUM('administrador', 'empleado', 'cliente') NOT NULL,
    contraseña VARCHAR(255) NOT NULL
);

select * from usuarios;
CREATE TABLE libros (
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    año_publicacion INT(4) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);





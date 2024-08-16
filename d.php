<?php
include "conexion.php";
$pass = md5("holamundo");
$sql = $conn->query("INSERT INTO codigo(codigo) VALUES
 ('$pass')");

header('Location: index.html');

?>
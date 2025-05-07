<?php
$servername = "localhost:3306"; // O la dirección de tu servidor MySQL
$username = "root"; // Tu nombre de usuario de MySQL
$password = "gabriel210719"; // Tu contraseña de MySQL
$dbname = "taller_mecanico"; // El nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
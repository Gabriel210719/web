<?php
include 'conexion.php';

$tipo = $_POST['tipo'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];

$sql = "INSERT INTO vehiculos (tipo, marca, modelo) VALUES ('$tipo', '$marca', '$modelo')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$tipo = $_POST['tipo'];
$subtipo = $_POST['subtipo'];
$medida = $_POST['medida'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];


$numero_serie = substr(uniqid(), 0, 8);

$sql = "INSERT INTO inventario (nombre, categoria, tipo, subtipo, medida, descripcion, cantidad, numero_serie) VALUES ('$nombre', '$categoria', '$tipo', '$subtipo', '$medida', '$descripcion', $cantidad, '$numero_serie')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
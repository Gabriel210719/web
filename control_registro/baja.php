<?php
include '../catalogo/conexion.php'; // Ajusta la ruta a conexion.php

$id_orden = $_GET['id'];

$sql = "UPDATE ordenes_servicio SET baja = 1 WHERE id_orden = $id_orden";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error al dar de baja la orden: " . $conn->error;
}

$conn->close();
?>
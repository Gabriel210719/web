<?php
include 'conexion.php';

if (isset($_GET['id']) && isset($_GET['accion'])) {
    $id = $_GET['id'];
    $accion = $_GET['accion'];

    // Obtener la cantidad actual del artículo
    $sql_obtener_cantidad = "SELECT cantidad FROM inventario WHERE id_inventario = $id";
    $result = $conn->query($sql_obtener_cantidad);
    $row = $result->fetch_assoc();
    $cantidad_actual = $row['cantidad'];

    // Actualizar la cantidad según la acción
    if ($accion === 'aumentar') {
        $nueva_cantidad = $cantidad_actual + 1;
    } elseif ($accion === 'disminuir') {
        $nueva_cantidad = max(0, $cantidad_actual - 1); // Evitar cantidades negativas
    }

    // Actualizar la cantidad en la base de datos
    $sql_actualizar_cantidad = "UPDATE inventario SET cantidad = $nueva_cantidad WHERE id_inventario = $id";

    if ($conn->query($sql_actualizar_cantidad) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql_actualizar_cantidad . "<br>" . $conn->error;
    }
}

$conn->close();
?>
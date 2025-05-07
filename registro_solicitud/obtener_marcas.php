<?php
include '../catalogo/conexion.php';

$tipo = $_POST['tipo'];

$sql_marcas = "SELECT DISTINCT marca FROM vehiculos WHERE tipo = '$tipo' AND activo = 1";
$result_marcas = $conn->query($sql_marcas);

$options = '<option value="">Seleccionar</option>';
while ($row_marca = $result_marcas->fetch_assoc()) {
    $options .= "<option value='" . $row_marca['marca'] . "'>" . $row_marca['marca'] . "</option>";
}

echo $options;

$conn->close();
?>
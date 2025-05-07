<?php
include '../catalogo/conexion.php';

$tipo = $_POST['tipo'];
$marca = $_POST['marca'];

$sql_modelos = "SELECT modelo FROM vehiculos WHERE tipo = '$tipo' AND marca = '$marca' AND activo = 1";
$result_modelos = $conn->query($sql_modelos);

$options = '<option value="">Seleccionar</option>';
while ($row_modelo = $result_modelos->fetch_assoc()) {
    $options .= "<option value='" . $row_modelo['modelo'] . "'>" . $row_modelo['modelo'] . "</option>";
}

echo $options;

$conn->close();
?>
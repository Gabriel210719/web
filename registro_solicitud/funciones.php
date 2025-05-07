<?php
include 'conexion.php';

function generarFolio($conn) {
    // Obtener el último folio
    $sql = "SELECT MAX(folio) AS ultimo_folio FROM ordenes_servicio";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $ultimo_folio = $row['ultimo_folio'];
            // Extraer el número del último folio y sumarle 1
            $numero_folio = intval(substr($ultimo_folio, 3)) + 1;
            // Formatear el nuevo folio con ceros a la izquierda
            $nuevo_folio = 'OS-' . str_pad($numero_folio, 4, '0', STR_PAD_LEFT);
        } else {
            // Si no hay folios, comenzar con OS-0001
            $nuevo_folio = 'OS-0001';
        }
        return $nuevo_folio;
    } else {
        // Manejar error de consulta
        return "Error al generar folio: " . $conn->error;
    }
}
?>
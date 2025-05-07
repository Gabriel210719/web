<?php
require('fpdf.php');
include 'conexion.php';

// Obtener el ID de la orden de servicio desde la URL
$id_orden = $_GET['id'];

// Obtener los datos de la orden de servicio desde la base de datos
$sql_orden = "SELECT os.*, c.nombre_completo, c.telefono, v.tipo, v.marca, v.modelo FROM ordenes_servicio os JOIN clientes c ON os.id_cliente = c.id_cliente JOIN vehiculos v ON os.id_vehiculo = v.id_vehiculo WHERE os.id_orden = $id_orden";
$result_orden = $conn->query($sql_orden);
$orden = $result_orden->fetch_assoc();

// Obtener los datos de la cotización desde la base de datos
$sql_cotizacion = "SELECT * FROM cotizacion WHERE id_orden = $id_orden";
$result_cotizacion = $conn->query($sql_cotizacion);

// Crear el PDF
$pdf = new FPDF(); // Instancia de la clase FPDF
$pdf->AddPage();

// Título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Folio: ' . $orden['folio']), 0, 1, 'C');

// Datos del cliente (recuadro azul con texto blanco en negrita)
$pdf->SetFillColor(0, 0, 255); // Color de relleno azul
$pdf->SetTextColor(255, 255, 255); // Color de texto blanco
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Datos del Cliente'), 0, 1, 'L', true); // Recuadro con relleno

$pdf->SetTextColor(0,0,0); //Regresamos a color negro de letras
$pdf->SetFillColor(255,255,255); //Regresamos a color blanco de fondo
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Nombre: ' . $orden['nombre_completo']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Teléfono: ' . $orden['telefono']), 0, 1);

// Datos del vehículo (recuadro azul con texto blanco en negrita)
$pdf->SetFillColor(0, 0, 255); // Color de relleno azul
$pdf->SetTextColor(255, 255, 255); // Color de texto blanco
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Datos del Vehículo'), 0, 1, 'L', true); // Recuadro con relleno

$pdf->SetTextColor(0,0,0); //Regresamos a color negro de letras
$pdf->SetFillColor(255,255,255); //Regresamos a color blanco de fondo
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Vehículo: ' . $orden['tipo'] . ' ' . $orden['marca'] . ' ' . $orden['modelo']), 0, 1);

// Ajuste aquí
$placas = isset($orden['placas_vehiculo']) ? $orden['placas_vehiculo'] : '';
$pdf->Cell(0, 10, utf8_decode('Placas: ' . $placas), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Fecha de Ingreso: ' . $orden['fecha_ingreso']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Hora de Ingreso: ' . $orden['hora_ingreso']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Kilometraje: ' . $orden['kilometraje']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Nivel de Gasolina: ' . $orden['nivel_gasolina']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Nivel de Aceite: ' . $orden['nivel_aceite']), 0, 1);

// Motivo de visita (recuadro azul con texto blanco en negrita)
$pdf->SetFillColor(0, 0, 255); // Color de relleno azul
$pdf->SetTextColor(255, 255, 255); // Color de texto blanco
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Motivo de Visita'), 0, 1, 'L', true); // Recuadro con relleno

$pdf->SetTextColor(0,0,0); //Regresamos a color negro de letras
$pdf->SetFillColor(255,255,255); //Regresamos a color blanco de fondo
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Motivo: ' . $orden['motivo_visita']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Especificar: ' . $orden['especificar_mc']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Fecha Estimada de Salida: ' . $orden['fecha_salida']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Observaciones: ' . $orden['observaciones']), 0, 1);

// Cotización
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, utf8_decode('Refacción'), 1, 0, 'L'); // Ancho de 100 y alineación a la izquierda
$pdf->Cell(0, 10, utf8_decode('Costo'), 1, 1, 'R'); // Alineación a la derecha
$pdf->SetFont('Arial', '', 12);
$total = 0;
while ($cotizacion = $result_cotizacion->fetch_assoc()) {
    $pdf->Cell(100, 10, utf8_decode($cotizacion['refaccion']), 1, 0); // Ancho de 100
    $pdf->Cell(0, 10, $cotizacion['precio'], 1, 1, 'R'); // Alineación a la derecha
    $total += $cotizacion['precio'];
}
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Total: ' . $total), 0, 1, 'R'); // Alineación a la derecha

// Firmas
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Firma del Cliente'), 0, 0, 'L');
$pdf->Cell(0, 10, utf8_decode('Firma del Proveedor'), 0, 1, 'R');

// Salida del PDF
$pdf->Output('orden_servicio_' . $orden['folio'] . '.pdf', 'D');

$conn->close();
?>
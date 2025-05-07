<?php
include '../catalogo/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_orden = $_POST['id_orden'];

    // Recuperar los datos generales de la orden
    $folio = $_POST['folio'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $marca_vehiculo = $_POST['marca_vehiculo'];
    $modelo_vehiculo = $_POST['modelo_vehiculo'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_salida = $_POST['fecha_salida'];
    $nivel_gasolina = $_POST['nivel_gasolina'];
    $nivel_aceite = $_POST['nivel_aceite'];
    $kilometraje = $_POST['kilometraje'];
    $motivo_visita = $_POST['motivo_visita'];
    $especificar_mc = $_POST['especificar_mc'];
    $especificar_otro = $_POST['especificar_otro'];
    $observaciones = $_POST['observaciones'];

    // Iniciar una transacción para asegurar la integridad de los datos
    $conn->begin_transaction();

    try {
        // Actualizar la tabla clientes
        $sql_update_cliente = "UPDATE clientes SET nombre_completo = ?, telefono = ? WHERE id_cliente = (SELECT id_cliente FROM ordenes_servicio WHERE id_orden = ?)";
        $stmt_cliente = $conn->prepare($sql_update_cliente);
        $stmt_cliente->bind_param("ssi", $nombre_cliente, $telefono_cliente, $id_orden);
        if (!$stmt_cliente->execute()) {
            throw new Exception("Error al actualizar cliente: " . $stmt_cliente->error);
        }
        $stmt_cliente->close();

        // Actualizar la tabla vehiculos
        $sql_update_vehiculo = "UPDATE vehiculos SET tipo = ?, marca = ?, modelo = ? WHERE id_vehiculo = (SELECT id_vehiculo FROM ordenes_servicio WHERE id_orden = ?)";
        $stmt_vehiculo = $conn->prepare($sql_update_vehiculo);
        $stmt_vehiculo->bind_param("sssi", $tipo_vehiculo, $marca_vehiculo, $modelo_vehiculo, $id_orden);
        if (!$stmt_vehiculo->execute()) {
            throw new Exception("Error al actualizar vehículo: " . $stmt_vehiculo->error);
        }
        $stmt_vehiculo->close();

        // Actualizar la tabla ordenes_servicio
        $sql_update_orden = "UPDATE ordenes_servicio SET 
            folio = ?,
            fecha_ingreso = ?,
            fecha_salida = ?,
            nivel_gasolina = ?,
            nivel_aceite = ?,
            kilometraje = ?,
            motivo_visita = ?,
            especificar_mc = ?,
            especificar_otro = ?,
            observaciones = ?
        WHERE id_orden = ?";
        $stmt_orden = $conn->prepare($sql_update_orden);
        $stmt_orden->bind_param("ssssssssssi", $folio, $fecha_ingreso, $fecha_salida, $nivel_gasolina, $nivel_aceite, $kilometraje, $motivo_visita, $especificar_mc, $especificar_otro, $observaciones, $id_orden);
        if (!$stmt_orden->execute()) {
            throw new Exception("Error al actualizar orden de servicio: " . $stmt_orden->error);
        }
        $stmt_orden->close();

        // Procesar la actualización de componentes
        if (isset($_POST['condicion_componente'])) {
            foreach ($_POST['condicion_componente'] as $id_componente => $condicion) {
                $sql_update_componente = "UPDATE componentes SET condicion = ? WHERE id_componente = ?";
                $stmt_componente = $conn->prepare($sql_update_componente);
                $stmt_componente->bind_param("si", $condicion, $id_componente);
                if (!$stmt_componente->execute()) {
                    throw new Exception("Error al actualizar componente: " . $stmt_componente->error);
                }
                $stmt_componente->close();
            }
        }

        // Procesar la actualización y adición de cotizaciones
        if (isset($_POST['refaccion_cotizacion']) && isset($_POST['precio_cotizacion'])) {
            foreach ($_POST['refaccion_cotizacion'] as $id_cotizacion => $refaccion) {
                $precio = $_POST['precio_cotizacion'][$id_cotizacion];
                $sql_update_cotizacion = "UPDATE cotizacion SET refaccion = ?, precio = ? WHERE id_cotizacion = ?";
                $stmt_cotizacion = $conn->prepare($sql_update_cotizacion);
                $stmt_cotizacion->bind_param("sdi", $refaccion, $precio, $id_cotizacion);
                if (!$stmt_cotizacion->execute()) {
                    throw new Exception("Error al actualizar cotización: " . $stmt_cotizacion->error);
                }
                $stmt_cotizacion->close();
            }
        }

        // Procesar las nuevas cotizaciones añadidas
        if (isset($_POST['refaccion_cotizacion_nueva']) && isset($_POST['precio_cotizacion_nueva'])) {
            foreach ($_POST['refaccion_cotizacion_nueva'] as $key => $refaccion_nueva) {
                $precio_nueva = $_POST['precio_cotizacion_nueva'][$key];
                if (!empty($refaccion_nueva)) {
                    $sql_insert_cotizacion = "INSERT INTO cotizacion (id_orden, refaccion, precio) VALUES (?, ?, ?)";
                    $stmt_insert_cotizacion = $conn->prepare($sql_insert_cotizacion);
                    $stmt_insert_cotizacion->bind_param("isd", $id_orden, $refaccion_nueva, $precio_nueva);
                    if (!$stmt_insert_cotizacion->execute()) {
                        throw new Exception("Error al agregar nueva cotización: " . $stmt_insert_cotizacion->error);
                    }
                    $stmt_insert_cotizacion->close();
                }
            }
        }

        // Si todo salió bien, confirmar la transacción
        $conn->commit();
        echo "<div class='container mt-5'><div class='alert alert-success' role='alert'>Orden de servicio actualizada con éxito. <a href='index.php' class='alert-link'>Volver al Control de Registros</a></div></div>";

    } catch (Exception $e) {
        // Si ocurre algún error, deshacer la transacción
        $conn->rollback();
        echo "<div class='container mt-5'><div class='alert alert-danger' role='alert'>Error al actualizar la orden de servicio: " . $e->getMessage() . "</div></div>";
    }

    $conn->close();

} else {
    // Si se intenta acceder directamente a este archivo sin enviar el formulario
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Procesar Actualización</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
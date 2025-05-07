<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $folio = $_POST['folio'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $marca_vehiculo = $_POST['marca_vehiculo'];
    $modelo_vehiculo = $_POST['modelo_vehiculo'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_salida = $_POST['fecha_salida']; // Recuperar fecha_salida
    $nivel_gasolina = $_POST['nivel_gasolina'];
    $nivel_aceite = $_POST['nivel_aceite'];
    $kilometraje = $_POST['kilometraje'];
    $motivo_visita = $_POST['motivo_visita'];
    $especificar_mc = $_POST['especificar_mc'];
    $especificar_otro = $_POST['especificar_otro'];
    $observaciones = $_POST['observaciones'];

    // Insertar datos en la tabla clientes
    $sql_cliente = "INSERT INTO clientes (nombre_completo, telefono) VALUES ('$nombre_cliente', '$telefono_cliente')";
    if ($conn->query($sql_cliente) === TRUE) {
        $id_cliente = $conn->insert_id; // Obtener el ID del cliente insertado
    } else {
        echo "Error al insertar cliente: " . $conn->error;
        $conn->close();
        exit();
    }

    // Obtener el ID del vehículo
    $sql_vehiculo = "SELECT id_vehiculo FROM vehiculos WHERE tipo = '$tipo_vehiculo' AND marca = '$marca_vehiculo' AND modelo = '$modelo_vehiculo'";
    $result_vehiculo = $conn->query($sql_vehiculo);
    if ($result_vehiculo->num_rows > 0) {
        $row_vehiculo = $result_vehiculo->fetch_assoc();
        $id_vehiculo = $row_vehiculo['id_vehiculo'];
    } else {
        echo "Error: Vehículo no encontrado";
        $conn->close();
        exit();
    }

    // Insertar datos en la tabla ordenes_servicio
    $sql_orden = "INSERT INTO ordenes_servicio (folio, id_cliente, id_vehiculo, fecha_ingreso, nivel_gasolina, nivel_aceite, kilometraje, motivo_visita, especificar_mc, especificar_otro, observaciones, fecha_salida) VALUES ('$folio', $id_cliente, $id_vehiculo, '$fecha_ingreso', '$nivel_gasolina', '$nivel_aceite', $kilometraje, '$motivo_visita', '$especificar_mc', '$especificar_otro', '$observaciones', '$fecha_salida')";

    if ($conn->query($sql_orden) === TRUE) {
        $id_orden = $conn->insert_id; // Obtener el ID de la orden insertada

        // Insertar componentes en la tabla componentes
        if (isset($_POST['componentes'])) {
            $componentes_array = $_POST['componentes'];
            $condiciones = array(
                'espejos' => $_POST['condicion_espejos'],
                'luces' => $_POST['condicion_luces'],
                'direccionales' => $_POST['condicion_direccionales'],
                'pintura' => $_POST['condicion_pintura'],
                'llave' => $_POST['condicion_llave'],
                'claxon' => $_POST['condicion_claxon'],
                'tablero' => $_POST['condicion_tablero']
            );

            foreach ($componentes_array as $componente) {
                $condicion = $condiciones[$componente];
                $sql_componente = "INSERT INTO componentes (id_orden, nombre, condicion) VALUES ($id_orden, '$componente', '$condicion')";
                $conn->query($sql_componente);
            }
        }

        // Insertar cotización en la tabla cotizacion
        if (isset($_POST['refacciones']) && isset($_POST['precios'])) {
            $refacciones = $_POST['refacciones'];
            $precios = $_POST['precios'];

            for ($i = 0; $i < count($refacciones); $i++) {
                $refaccion = $refacciones[$i];
                $precio = $precios[$i];
                $sql_cotizacion = "INSERT INTO cotizacion (id_orden, refaccion, precio) VALUES ($id_orden, '$refaccion', $precio)";
                $conn->query($sql_cotizacion);
            }
        }

        // Redirigir a exito.php y pasar el ID de la orden en la URL
        header("Location: exito.php?id_orden=" . $id_orden);
        exit();
    } else {
        echo "Error al guardar orden de servicio: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
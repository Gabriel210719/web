<?php
include '../catalogo/conexion.php';

if (isset($_GET['id'])) {
    $id_orden = $_GET['id'];

    // Obtener los datos de la orden de servicio
    $sql_orden = "SELECT * FROM ordenes_servicio WHERE id_orden = $id_orden";
    $result_orden = $conn->query($sql_orden);

    if ($result_orden->num_rows == 1) {
        $orden = $result_orden->fetch_assoc();

        // Obtener los datos del cliente asociado
        $sql_cliente = "SELECT * FROM clientes WHERE id_cliente = " . $orden['id_cliente'];
        $result_cliente = $conn->query($sql_cliente);
        $cliente = $result_cliente->fetch_assoc();

        // Obtener los datos del vehículo asociado
        $sql_vehiculo = "SELECT * FROM vehiculos WHERE id_vehiculo = " . $orden['id_vehiculo'];
        $result_vehiculo = $conn->query($sql_vehiculo);
        $vehiculo = $result_vehiculo->fetch_assoc();

        // Obtener los componentes asociados a la orden
        $sql_componentes = "SELECT * FROM componentes WHERE id_orden = $id_orden";
        $result_componentes = $conn->query($sql_componentes);
        $componentes = [];
        if ($result_componentes->num_rows > 0) {
            while ($row_componente = $result_componentes->fetch_assoc()) {
                $componentes[] = $row_componente;
            }
        }

        // Obtener las cotizaciones asociadas a la orden
        $sql_cotizaciones = "SELECT * FROM cotizacion WHERE id_orden = $id_orden";
        $result_cotizaciones = $conn->query($sql_cotizaciones);
        $cotizaciones = [];
        if ($result_cotizaciones->num_rows > 0) {
            while ($row_cotizacion = $result_cotizaciones->fetch_assoc()) {
                $cotizaciones[] = $row_cotizacion;
            }
        }
    } else {
        echo "Orden de servicio no encontrada.";
        exit();
    }
} else {
    echo "ID de orden no especificado.";
    exit();
}

// Obtener todos los vehículos para los selectores dinámicos
$sql_todos_vehiculos = "SELECT DISTINCT tipo FROM vehiculos ORDER BY tipo";
$tipos_result = $conn->query($sql_todos_vehiculos);
$tipos_vehiculos = [];
if ($tipos_result->num_rows > 0) {
    while ($row = $tipos_result->fetch_assoc()) {
        $tipos_vehiculos[] = $row['tipo'];
    }
}

$sql_marcas = "SELECT DISTINCT marca FROM vehiculos ORDER BY marca";
$marcas_result = $conn->query($sql_marcas);
$marcas_vehiculos = [];
if ($marcas_result->num_rows > 0) {
    while ($row = $marcas_result->fetch_assoc()) {
        $marcas_vehiculos[] = $row['marca'];
    }
}

$sql_modelos = "SELECT DISTINCT modelo FROM vehiculos ORDER BY modelo";
$modelos_result = $conn->query($sql_modelos);
$modelos_vehiculos = [];
if ($modelos_result->num_rows > 0) {
    while ($row = $modelos_result->fetch_assoc()) {
        $modelos_vehiculos[] = $row['modelo'];
    }
}

$conn->close();

// Array de motivos de visita predefinidos
$motivos_visita_opciones = ["Mantenimiento Preventivo", "Reparación General", "Servicio de Frenos", "Servicio de Aceite", "Alineación y Balanceo", "Revisión Eléctrica", "Otro"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Orden de Servicio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Editar Orden de Servicio</h1>
        <form method="post" action="procesar_actualizacion.php">
            <input type="hidden" name="id_orden" value="<?php echo $orden['id_orden']; ?>">

            <div class="form-group">
                <label for="folio">Folio:</label>
                <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $orden['folio']; ?>" required>
            </div>
            <div class="form-group">
                <label for="nombre_cliente">Nombre del Cliente:</label>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="<?php echo $cliente['nombre_completo']; ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono_cliente">Teléfono del Cliente:</label>
                <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente" value="<?php echo $cliente['telefono']; ?>" required>
            </div>

            <div class="form-group">
                <label for="tipo_vehiculo">Tipo de Vehículo:</label>
                <select class="form-control" id="tipo_vehiculo" name="tipo_vehiculo" required>
                    <option value="">Seleccionar Tipo</option>
                    <?php foreach ($tipos_vehiculos as $tipo) : ?>
                        <option value="<?php echo $tipo; ?>" <?php if ($vehiculo['tipo'] == $tipo) echo 'selected'; ?>><?php echo $tipo; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="marca_vehiculo">Marca del Vehículo:</label>
                <select class="form-control" id="marca_vehiculo" name="marca_vehiculo" required>
                    <option value="">Seleccionar Marca</option>
                    <?php foreach ($marcas_vehiculos as $marca) : ?>
                        <option value="<?php echo $marca; ?>" <?php if ($vehiculo['marca'] == $marca) echo 'selected'; ?>><?php echo $marca; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="modelo_vehiculo">Modelo del Vehículo:</label>
                <select class="form-control" id="modelo_vehiculo" name="modelo_vehiculo" required>
                    <option value="">Seleccionar Modelo</option>
                    <?php foreach ($modelos_vehiculos as $modelo) : ?>
                        <option value="<?php echo $modelo; ?>" <?php if ($vehiculo['modelo'] == $modelo) echo 'selected'; ?>><?php echo $modelo; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $orden['fecha_ingreso']; ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_salida">Fecha de Salida:</label>
                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" value="<?php echo $orden['fecha_salida']; ?>">
            </div>
            <div class="form-group">
                <label for="nivel_gasolina">Nivel de Gasolina:</label>
                <input type="text" class="form-control" id="nivel_gasolina" name="nivel_gasolina" value="<?php echo $orden['nivel_gasolina']; ?>">
            </div>
            <div class="form-group">
                <label for="nivel_aceite">Nivel de Aceite:</label>
                <input type="text" class="form-control" id="nivel_aceite" name="nivel_aceite" value="<?php echo $orden['nivel_aceite']; ?>">
            </div>
            <div class="form-group">
                <label for="kilometraje">Kilometraje:</label>
                <input type="number" class="form-control" id="kilometraje" name="kilometraje" value="<?php echo $orden['kilometraje']; ?>">
            </div>
            <div class="form-group">
                <label for="motivo_visita">Motivo de Visita:</label>
                <select class="form-control" id="motivo_visita" name="motivo_visita">
                    <option value="">Seleccionar Motivo</option>
                    <?php foreach ($motivos_visita_opciones as $motivo) : ?>
                        <option value="<?php echo $motivo; ?>" <?php if ($orden['motivo_visita'] == $motivo) echo 'selected'; ?>><?php echo $motivo; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="especificar_mc">Especificar (MC):</label>
                <input type="text" class="form-control" id="especificar_mc" name="especificar_mc" value="<?php echo $orden['especificar_mc']; ?>">
            </div>
            <div class="form-group">
                <label for="especificar_otro">Especificar Otro:</label>
                <input type="text" class="form-control" id="especificar_otro" name="especificar_otro" value="<?php echo $orden['especificar_otro']; ?>">
            </div>
            <div class="form-group">
                <label for="observaciones">Observaciones:</label>
                <textarea class="form-control" id="observaciones" name="observaciones"><?php echo $orden['observaciones']; ?></textarea>
            </div>

            <h3>Componentes</h3>
            <?php if (!empty($componentes)) : ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Condición</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($componentes as $componente) : ?>
                            <tr>
                                <td><?php echo $componente['nombre']; ?></td>
                                <td><input type="text" class="form-control" name="condicion_componente[<?php echo $componente['id_componente']; ?>]" value="<?php echo $componente['condicion']; ?>"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No se encontraron componentes para esta orden.</p>
            <?php endif; ?>

            <h3>Cotización</h3>
            <table class="table table-bordered" id="tabla-cotizacion">
                <thead>
                    <tr>
                        <th>Refacción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cotizaciones)) : ?>
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <tr class="fila-cotizacion">
                                <td><input type="text" class="form-control" name="refaccion_cotizacion[<?php echo $cotizacion['id_cotizacion']; ?>]" value="<?php echo $cotizacion['refaccion']; ?>"></td>
                                <td><input type="number" class="form-control precio-cotizacion" name="precio_cotizacion[<?php echo $cotizacion['id_cotizacion']; ?>]" value="<?php echo $cotizacion['precio']; ?>"></td>
                                <td><button type="button" class="btn btn-danger btn-sm eliminar-fila-cotizacion">Eliminar</button></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr id="nueva-fila-cotizacion" style="display: none;">
                            <td><input type="text" class="form-control" name="refaccion_cotizacion_nueva[]"></td>
                            <td><input type="number" class="form-control precio-cotizacion" name="precio_cotizacion_nueva[]" value="0"></td>
                            <td><button type="button" class="btn btn-danger btn-sm eliminar-fila-cotizacion">Eliminar</button></td>
                        </tr>
                    <?php else : ?>
                        <tr id="fila-inicial-cotizacion" class="fila-cotizacion">
                            <td><input type="text" class="form-control" name="refaccion_cotizacion_nueva[]"></td>
                            <td><input type="number" class="form-control precio-cotizacion" name="precio_cotizacion_nueva[]" value="0"></td>
                            <td><button type="button" class="btn btn-danger btn-sm eliminar-fila-cotizacion">Eliminar</button></td>
                        </tr>
                        <tr id="nueva-fila-cotizacion" style="display: none;">
                            <td><input type="text" class="form-control" name="refaccion_cotizacion_nueva[]"></td>
                            <td><input type="number" class="form-control precio-cotizacion" name="precio_cotizacion_nueva[]" value="0"></td>
                            <td><button type="button" class="btn btn-danger btn-sm eliminar-fila-cotizacion">Eliminar</button></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="font-weight-bold">Total:</td>
                        <td id="total-cotizacion">0.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3"><button type="button" class="btn btn-success btn-sm" id="agregar-cotizacion">Agregar Cotización</button></td>
                    </tr>
                </tfoot>
            </table>

            <button type="submit" class="btn btn-primary">Aplicar Cambios</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // ... (Código JavaScript para los selectores de vehículos) ...

            // Precargar la suma total de la cotización
            function calcularTotalCotizacion() {
                var total = 0;
                $('.precio-cotizacion').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#total-cotizacion').text(total.toFixed(2));
            }

            calcularTotalCotizacion();

            // Agregar nueva fila de cotización
            $('#agregar-cotizacion').click(function() {
                var nuevaFila = $('#nueva-fila-cotizacion').clone().removeAttr('style').addClass('fila-cotizacion');
                $('#tabla-cotizacion tbody').append(nuevaFila);
            });

            // Eliminar fila de cotización
            $(document).on('click', '.eliminar-fila-cotizacion', function() {
                var rowCount = $('#tabla-cotizacion tbody tr.fila-cotizacion').length;
                if (rowCount > 1 || !$('#fila-inicial-cotizacion').length) {
                    $(this).closest('tr.fila-cotizacion').remove();
                    calcularTotalCotizacion();
                } else {
                    alert('Debe haber al menos una cotización.');
                }
            });

            // Recalcular total al cambiar el precio EN TIEMPO REAL
            $(document).on('input', '.precio-cotizacion', calcularTotalCotizacion);
        });
    </script>
</body>
</html>
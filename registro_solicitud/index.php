<?php include 'funciones.php';
$id_orden = isset($_GET['id_orden']) ? $_GET['id_orden'] : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Orden de Servicio</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../menu.php">Menú Principal</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orden de Servicio</li>
            </ol>
        </nav>

    <div class="container">
        <h1>Orden de Servicio</h1>
        <form action="guardar_datos.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="folio">Folio:</label>
                    <input type="text" class="form-control" id="folio" name="folio" value="<?php echo generarFolio($conn); ?>" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nombre_cliente">Nombre Completo:</label>
                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="telefono_cliente">Teléfono:</label>
                    <input type="tel" class="form-control" id="telefono_cliente" name="telefono_cliente" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="placas_vehiculo">Placas:</label>
                    <input type="text" class="form-control" id="placas_vehiculo" name="placas_vehiculo">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="tipo_vehiculo">Tipo de Vehículo:</label>
                    <select class="form-control" id="tipo_vehiculo" name="tipo_vehiculo">
                        <option value="">Seleccionar</option>
                        <?php
                        include '../catalogo/conexion.php'; // Incluye la conexión a la base de datos del catálogo
                        $sql_tipos = "SELECT DISTINCT tipo FROM vehiculos WHERE activo = 1";
                        $result_tipos = $conn->query($sql_tipos);
                        while ($row_tipo = $result_tipos->fetch_assoc()) {
                            echo "<option value='" . $row_tipo['tipo'] . "'>" . $row_tipo['tipo'] . "</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="marca_vehiculo">Marca:</label>
                    <select class="form-control" id="marca_vehiculo" name="marca_vehiculo">
                        <option value="">Seleccionar</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="modelo_vehiculo">Modelo:</label>
                    <select class="form-control" id="modelo_vehiculo" name="modelo_vehiculo">
                        <option value="">Seleccionar</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fecha_ingreso">Fecha y Hora de Ingreso:</label>
                    <input type="datetime-local" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                </div>
               
            </div>
            <div class="form-group">
                <label>Componentes:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="espejos" name="componentes[]" value="espejos">
                    <label class="form-check-label" for="espejos">Espejos</label>
                    <input type="text" class="form-control" name="condicion_espejos" placeholder="Condición">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="luces" name="componentes[]" value="luces">
                    <label class="form-check-label" for="luces">Luces</label>
                    <input type="text" class="form-control" name="condicion_luces" placeholder="Condición">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="direccionales" name="componentes[]" value="direccionales">
                    <label class="form-check-label" for="direccionales">Direccionales</label>
                    <input type="text" class="form-control" name="condicion_direccionales" placeholder="Condición">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="pintura" name="componentes[]" value="pintura">
                    <label class="form-check-label" for="pintura">Pintura</label>
                    <input type="text" class="form-control" name="condicion_pintura" placeholder="Condición">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="llave" name="componentes[]" value="llave">
                    <label class="form-check-label" for="llave">Llave</label>
                    <input type="text" class="form-control" name="condicion_llave" placeholder="Condición">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="claxon" name="componentes[]" value="claxon">
                    <label class="form-check-label" for="claxon">Claxon</label>
                    <input type="text" class="form-control" name="condicion_claxon" placeholder="Condición">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="tablero" name="componentes[]" value="tablero">
                    <label class="form-check-label" for="tablero">Tablero</label>
                    <input type="text" class="form-control" name="condicion_tablero" placeholder="Condición">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nivel_gasolina">Nivel de Gasolina:</label>
                    <select class="form-control" id="nivel_gasolina" name="nivel_gasolina">
                        <option value="">Seleccionar</option>
                        <option value="lleno">Lleno</option>
                        <option value="medio">Medio</option>
                        <option value="bajo">Bajo</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="nivel_aceite">Nivel de Aceite:</label>
                    <select class="form-control" id="nivel_aceite" name="nivel_aceite">
                        <option value="">Seleccionar</option>
                        <option value="lleno">Lleno</option>
                        <option value="medio">Medio</option>
                        <option value="bajo">Bajo</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="kilometraje">Kilometraje:</label>
                    <input type="number" class="form-control" id="kilometraje" name="kilometraje" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="motivo_visita">Motivo de Visita:</label>
                    <select class="form-control" id="motivo_visita" name="motivo_visita">
                        <option value="">Seleccionar</option>
                        <option value="mantenimiento">Mantenimiento</option>
                        <option value="reparacion">Reparación</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="especificar_mc">Especifique Mantenimiento/Reparación:</label>
                    <input type="text" class="form-control" id="especificar_mc" name="especificar_mc">
                </div>
                <div class="form-group col-md-4">
                    <label for="especificar_otro">Especifique Otro:</label>
                    <input type="text" class="form-control" id="especificar_otro" name="especificar_otro">
                </div>
            </div>
            <div class="form-group">
                <label for="observaciones">Observaciones:</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
            </div>
            <div class="form-group col-md-4">
                    <label for="fecha_salida">Fecha y Hora de Salida:</label>
                    <input type="datetime-local" class="form-control" id="fecha_salida" name="fecha_salida">
                </div>

            <div class="form-group">
                <label>Cotización:</label>
                <div id="cotizacion-container">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control refaccion-input" name="refacciones[]" placeholder="Refacción">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control precio-input" name="precios[]" placeholder="Precio">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" id="agregar-refaccion">Agregar Refacción</button>
            </div>

            <div class="form-group">
                <label>Total:</label>
                <input type="text" class="form-control" id="total-cotizacion" value="0" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-success" id="descargar-pdf">Descargar PDF</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#tipo_vehiculo').change(function() {
                var tipo = $(this).val();
                $.ajax({
                    url: 'obtener_marcas.php', // Archivo para obtener las marcas
                    type: 'POST',
                    data: { tipo: tipo },
                    success: function(data) {
                        $('#marca_vehiculo').html(data);
                        $('#modelo_vehiculo').html('<option value="">Seleccionar</option>'); // Limpia los modelos
                    }
                });
            });

            $('#marca_vehiculo').change(function() {
                var tipo = $('#tipo_vehiculo').val();
                var marca = $(this).val();
                $.ajax({
                    url: 'obtener_modelos.php', // Archivo para obtener los modelos
                    type: 'POST',
                    data: { tipo: tipo, marca: marca },
                    success: function(data) {
                        $('#modelo_vehiculo').html(data);
                    }
                });
            });
        });
    </script>

    <script>
        document.getElementById('agregar-refaccion').addEventListener('click', function() {
            var container = document.getElementById('cotizacion-container');
            var row = document.createElement('div');
            row.className = 'form-row';
            row.innerHTML = `
                <div class="form-group col-md-6">
                    <input type="text" class="form-control refaccion-input" name="refacciones[]" placeholder="Refacción">
                </div>
                <div class="form-group col-md-6">
                    <input type="number" class="form-control precio-input" name="precios[]" placeholder="Precio">
                </div>
            `;
            container.appendChild(row);
            agregarEventosPrecio(); // Agrega eventos de escucha a los nuevos campos de precio
        });

        function calcularTotal() {
            var precios = document.querySelectorAll('.precio-input');
            var total = 0;
            precios.forEach(function(precio) {
                total += parseFloat(precio.value) || 0;
            });
            document.getElementById('total-cotizacion').value = total;
        }

        function agregarEventosPrecio() {
            var precios = document.querySelectorAll('.precio-input');
            precios.forEach(function(precio) {
                precio.addEventListener('input', calcularTotal);
            });
        }

        agregarEventosPrecio(); // Agrega eventos de escucha a los campos de precio iniciales

        
    </script>
    <script>
        $('#descargar-pdf').click(function() {
            var id_orden = <?php echo $id_orden; ?>; // Obtener el ID de la orden de servicio
            window.location.href = 'generar_pdf.php?id=' + id_orden;
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Control de Registros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#searchInput').on('input', function(){
                var searchTerm = $(this).val();
                window.location.href = 'index.php?search=' + searchTerm;
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../menu.php">Menú Principal</a></li>
                <li class="breadcrumb-item active" aria-current="page">Control de Registros</li>
            </ol>
        </nav>

        <h1 class="my-4">Control de Registros</h1>

        <div class="form-group">
            <label for="searchInput">Buscar por Nombre o Teléfono:</label>
            <input type="text" class="form-control" id="searchInput" placeholder="Ingrese nombre o teléfono" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Orden</th>
                    <th>Folio</th>
                    <th>Fecha Ingreso</th>
                    <th>Motivo Visita</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../catalogo/conexion.php';

                $searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

                $sql = "SELECT os.id_orden, os.folio, os.fecha_ingreso, os.motivo_visita
                        FROM ordenes_servicio os
                        INNER JOIN clientes c ON os.id_cliente = c.id_cliente
                        WHERE os.baja = 0";

                if (!empty($searchTerm)) {
                    $sql .= " AND (LOWER(c.nombre_completo) LIKE LOWER('%$searchTerm%') OR LOWER(c.telefono) LIKE LOWER('%$searchTerm%'))";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_orden'] . "</td>";
                        echo "<td>" . $row['folio'] . "</td>";
                        echo "<td>" . $row['fecha_ingreso'] . "</td>";
                        echo "<td>" . $row['motivo_visita'] . "</td>";
                        echo "<td>";
                        echo "<a href='actualizar_registro.php?id=" . $row['id_orden'] . "' class='btn btn-warning btn-sm mr-2'>Actualizar</a>";
                        echo "<a href='../registro_solicitud/generar_pdf.php?id=" . $row['id_orden'] . "' class='btn btn-sm btn-success' target='_blank'>Descargar</a>";
                        echo "<a href='baja.php?id=" . $row['id_orden'] . "' class='btn btn-danger btn-sm'>Dar de Baja</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay registros disponibles.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
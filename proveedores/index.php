<!DOCTYPE html>
<html>
<head>
    <title>Visualizar Proveedores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../menu.php">Menú</a></li>
                <li class="breadcrumb-item active" aria-current="page">Visualizar Proveedores</li>
            </ol>
        </nav>

        <h1>Visualizar Proveedores</h1>

        <form action="guardar_proveedor.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre del Proveedor:</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono del Proveedor:</label>
                <input type="text" class="form-control" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico (Opcional):</label>
                <input type="email" class="form-control" name="correo">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección (Ubicación):</label>
                <input type="text" class="form-control" name="direccion" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
        </form>

        <div class="form-group mt-3">
            <label for="buscador">Buscar Proveedor:</label>
            <input type="text" class="form-control" id="buscador" placeholder="Ingrese nombre o teléfono">
        </div>

        <h2>Lista de Proveedores</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-proveedores">
                <?php
                include 'conexion.php'; 
                $sql = "SELECT * FROM proveedores WHERE activo = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "<td>" . $row['telefono'] . "</td>";
                        echo "<td>" . $row['correo'] . "</td>";
                        echo "<td>" . $row['direccion'] . "</td>";
                        echo "<td>";
                        if (isset($row['id_proveedor'])) {
                            echo "<a href='editar_proveedor.php?id=" . $row['id_proveedor'] . "' class='btn btn-sm btn-warning'>Editar</a> ";
                            echo "<a href='baja_proveedor.php?id=" . $row['id_proveedor'] . "' class='btn btn-sm btn-danger'>Baja</a>";
                        } else {
                            echo "ID no disponible";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay proveedores registrados</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#buscador').on('keyup', function() {
                var valor = $(this).val().toLowerCase();
                $('#tabla-proveedores tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
                });
            });
        });
    </script>
</body>
</html>
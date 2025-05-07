<!DOCTYPE html>
<html>
<head>
    <title>Inventario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../menu.php">Menú</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inventario</li>
            </ol>
        </nav>

        <h1>Inventario</h1>

        <form action="guardar_inventario.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <input type="text" class="form-control" name="categoria" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" class="form-control" name="tipo" required>
            </div>
            <div class="form-group">
                <label for="subtipo">Subtipo:</label>
                <input type="text" class="form-control" name="subtipo">
            </div>
            <div class="form-group">
                <label for="medida">Medida:</label>
                <input type="text" class="form-control" name="medida">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" name="descripcion"></textarea>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" name="cantidad" value="0">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Artículo</button>
        </form>

        <div class="form-group mt-3">
            <label for="buscador">Buscar Artículo:</label>
            <input type="text" class="form-control" id="buscador" placeholder="Ingrese nombre o categoría">
        </div>

        <h2>Lista de Artículos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Tipo</th>
                    <th>Subtipo</th>
                    <th>Medida</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Número de Serie</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-inventario">
                <?php
                include 'conexion.php';
                $sql = "SELECT * FROM inventario WHERE activo = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "<td>" . $row['categoria'] . "</td>";
                        echo "<td>" . $row['tipo'] . "</td>";
                        echo "<td>" . $row['subtipo'] . "</td>";
                        echo "<td>" . $row['medida'] . "</td>";
                        echo "<td>" . $row['descripcion'] . "</td>";
                        echo "<td>" . $row['cantidad'] . "</td>";
                        echo "<td>" . $row['numero_serie'] . "</td>";
                        echo "<td>";
                        if (isset($row['id_inventario'])) {
                            echo "<a href='editar_inventario.php?id=" . $row['id_inventario'] . "' class='btn btn-sm btn-warning'>Editar</a> ";
                            echo "<a href='baja_inventario.php?id=" . $row['id_inventario'] . "' class='btn btn-sm btn-danger'>Baja</a> ";
                            echo "<a href='actualizar_stock.php?id=" . $row['id_inventario'] . "&accion=aumentar' class='btn btn-sm btn-success'>+</a> ";
                            echo "<a href='actualizar_stock.php?id=" . $row['id_inventario'] . "&accion=disminuir' class='btn btn-sm btn-danger'>-</a>";
                        } else {
                            echo "ID no disponible";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No hay artículos registrados</td></tr>";
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
                $('#tabla-inventario tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
                });
            });
        });
    </script>
</body>
</html>
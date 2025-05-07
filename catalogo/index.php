<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Vehículos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../menu.php">Menú</a></li>
                <li class="breadcrumb-item active" aria-current="page">Catálogo de Vehículos</li>
            </ol>
       </nav>

        <h1>Catálogo de Vehículos</h1>

        <form action="guardar_vehiculo.php" method="post">
            <div class="form-group">
                <label for="tipo">Tipo de Vehículo:</label>
                <input type="text" class="form-control" name="tipo" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" name="marca" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" name="modelo" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>

        <h2>Registros de Vehículos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conexion.php';
                $sql = "SELECT * FROM vehiculos WHERE activo = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['tipo'] . "</td>";
                        echo "<td>" . $row['marca'] . "</td>";
                        echo "<td>" . $row['modelo'] . "</td>";
                        echo "<td>";
                        if (isset($row['id_vehiculo'])) { // Verifica si la clave "id_vehiculo" existe
                            echo "<a href='editar_vehiculo.php?id=" . $row['id_vehiculo'] . "' class='btn btn-sm btn-warning'>Editar</a> ";
                            echo "<a href='baja_vehiculo.php?id=" . $row['id_vehiculo'] . "' class='btn btn-sm btn-danger'>Baja</a>";
                        } else {
                            echo "ID no disponible";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay registros</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
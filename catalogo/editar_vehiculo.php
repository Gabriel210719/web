<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM vehiculos WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if (isset($_POST['actualizar'])) {
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];

    $sql = "UPDATE vehiculos SET tipo = '$tipo', marca = '$marca', modelo = '$modelo' WHERE id_vehiculo = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Vehículo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Editar Vehículo</h1>

        <form method="post">
            <div class="form-group">
                <label for="tipo">Tipo de Vehículo:</label>
                <input type="text" class="form-control" name="tipo" value="<?php echo $row['tipo']; ?>" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" name="marca" value="<?php echo $row['marca']; ?>" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" name="modelo" value="<?php echo $row['modelo']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
        </form>
    </div>
</body>
</html>
<?php
include 'conexion.php'; 

$id_proveedor = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];

    $sql = "UPDATE proveedores SET nombre = '$nombre', telefono = '$telefono', correo = '$correo', direccion = '$direccion' WHERE id_proveedor = $id_proveedor";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar el proveedor: " . $conn->error;
    }
}

$sql = "SELECT nombre, telefono, correo, direccion FROM proveedores WHERE id_proveedor = $id_proveedor";
$result = $conn->query($sql);
$proveedor = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Proveedor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Editar Proveedor</h1>

        <form method="POST">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $proveedor['nombre']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" value="<?php echo $proveedor['telefono']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Correo:</label>
                <input type="email" name="correo" value="<?php echo $proveedor['correo']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>Dirección:</label>
                <input type="text" name="direccion" value="<?php echo $proveedor['direccion']; ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
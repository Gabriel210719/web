<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM inventario WHERE id_inventario = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $tipo = $_POST['tipo'];
    $subtipo = $_POST['subtipo'];
    $medida = $_POST['medida'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];

    $sql = "UPDATE inventario SET nombre = '$nombre', categoria = '$categoria', tipo = '$tipo', subtipo = '$subtipo', medida = '$medida', descripcion = '$descripcion', cantidad = $cantidad WHERE id_inventario = $id";

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
    <title>Editar Artículo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Editar Artículo</h1>

        <form method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $row['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <input type="text" class="form-control" name="categoria" value="<?php echo $row['categoria']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" class="form-control" name="tipo" value="<?php echo $row['tipo']; ?>" required>
            </div>
            <div class="form-group">
                <label for="subtipo">Subtipo:</label>
                <input type="text" class="form-control" name="subtipo" value="<?php echo $row['subtipo']; ?>">
            </div>
            <div class="form-group">
                <label for="medida">Medida:</label>
                <input type="text" class="form-control" name="medida" value="<?php echo $row['medida']; ?>">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" name="descripcion"><?php echo $row['descripcion']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" name="cantidad" value="<?php echo $row['cantidad']; ?>">
            </div>
            <div class="form-group">
                <label for="numero_serie">Número de Serie:</label>
                <input type="text" class="form-control" name="numero_serie" value="<?php echo $row['numero_serie']; ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Artículo</button>
        </form>
    </div>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    // Si no está autenticado, redirigir al login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menú Principal</title>
    <link rel="stylesheet" type="text/css" href="menu.css">
</head>
<body>
    <div class="menu-container">
        <h1> Bienvenidos al sistema de información TecnoTaller</h1>
        <div class="button-container">
            <a href="registro_solicitud/index.php" class="menu-button">Registro de Solicitud</a>
            <a href="control_registro/index.php" class="menu-button">Control de Registros</a>
            <a href="proveedores/index.php" class="menu-button">Directorio de
                Proveedores</a>
            <a href="inventario/index.php" class="menu-button">Inventario</a>
            <a href="catalogo/index.php" class="menu-button">Catálogo</a>
        </div>
        <div class="images-container">
            <img src="https://www.honda.mx/web/img/motorcycles/models/navi/navi/colors/rojo.png" alt="Imagen del Taller 1">
            <img src="https://www.honda.mx/web/img/motorcycles/models/trabajo/gl-150-cargo/colors/blanco.png" alt="Imagen del Taller 2">
            <img src="https://www.honda.mx/web/img/motorcycles/models/atvs/trx-520-fm/gallery/1.jpg" alt="Imagen del Taller 3">
        </div>
    </div>
</body>
</html>
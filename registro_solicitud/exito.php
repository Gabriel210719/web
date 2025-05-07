<!DOCTYPE html>
<html>
<head>
    <title>Orden Guardada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }

        h1 {
            color: #007bff; /* Azul */
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        a.button.download {
            background-color: #28a745; /* Verde */
            color: white;
        }

        a.button.return {
            background-color: #007bff; /* Azul */
            color: white;
        }

        a.button:hover {
            opacity: 0.8;
        }

        .breadcrumb {
            text-align: left;
            margin-bottom: 20px;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb span {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="breadcrumb">
        <a href="../menu.php">Menú</a> <span>></span>
        <span>Orden Guardada</span>
    </div>

    <h1>¡Orden guardada exitosamente!</h1>
    <p>¿Qué desea hacer?</p>
    <a href="generar_pdf.php?id=<?php echo $_GET['id_orden']; ?>" class="button download">Descargar PDF</a>
    <a href="index.php" class="button return">Regresar</a>
</body>
</html>
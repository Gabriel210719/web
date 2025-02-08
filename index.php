<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorpresa</title>
    <style>
        body {
            background-color: red;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .heart {
            position: absolute;
            width: 100px;
            height: 90px;
            background-color: pink;
            transform: rotate(-45deg);
        }
        .heart::before,
        .heart::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 90px;
            border-radius: 50%;
            background-color: pink;
        }
        .heart::before {
            top: -50px;
            left: 0;
        }
        .heart::after {
            left: 50px;
            top: 0;
        }
        .heart-left {
            top: 20%;
            left: 10%;
        }
        .heart-right {
            top: 20%;
            right: 10%;
        }
        .container {
            margin-top: 200px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: white;
            color: red;
            text-decoration: none;
            margin: 10px;
            border-radius: 5px;
            border: 1px solid white;
        }
        .btn:hover {
            background-color: pink;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¿Quieres leer mi carta?</h1>
        <a href="carta.php" class="btn">Sí</a>
        <a href="#" class="btn">No</a>
    </div>
    <div class="heart heart-left"></div>
    <div class="heart heart-right"></div>
</body>
</html>

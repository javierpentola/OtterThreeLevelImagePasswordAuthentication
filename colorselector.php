<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Selector</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select a Color</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="color" id="color" name="color" required>
            <br><br>
            <button type="submit">Select</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $color = $_POST["color"];

        // Guardar el color directamente en setup.php sin borrar el contenido existente
        $existingSetup = file_get_contents("setup.php");
        $colorLine = "\$colorcode = '" . $color . "';\n";

        file_put_contents("setup.php", $existingSetup . $colorLine);

        // Redirigir al usuario a imageselector.php
        header("Location: imageselector.php");
        exit; // Terminar el script para evitar que se siga ejecutando después de la redirección
    }
    ?>
</body>
</html>

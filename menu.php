<?php
// Incluir el archivo setup.php que contiene la contraseña encriptada, el color codificado y la imagen seleccionada
include 'setup.php';

// Función para desencriptar una contraseña
function decryptPassword($encryptedPassword) {
    $encryptionKey = "clave_secreta";
    $cipher = "aes-256-cbc";
    list($encrypted, $iv) = explode("::", base64_decode($encryptedPassword), 2);
    return openssl_decrypt($encrypted, $cipher, $encryptionKey, 0, $iv);
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $color = $_POST["color"];
    $image = $_POST["selectedImage"]; // Obtener el nombre de la imagen seleccionada

    $decryptedPassword = decryptPassword($encryptedPassword);
    $isColorVerified = ($color === $colorcode);
    $isImageVerified = ($image === $selectedImage);

    // Mensajes de depuración
    echo "Contraseña ingresada: " . htmlspecialchars($password) . "<br>";
    echo "Contraseña desencriptada: " . htmlspecialchars($decryptedPassword) . "<br>";
    echo "Color ingresado: " . htmlspecialchars($color) . "<br>";
    echo "Color guardado: " . htmlspecialchars($colorcode) . "<br>";
    echo "Color verificado: " . ($isColorVerified ? "true" : "false") . "<br>";
    echo "Imagen ingresada: " . htmlspecialchars($image) . "<br>";
    echo "Imagen esperada: " . htmlspecialchars($selectedImage) . "<br>";
    echo "Imagen verificada: " . ($isImageVerified ? "true" : "false") . "<br>";

    if ($password === $decryptedPassword && $isColorVerified && $isImageVerified) {
        header("Location: index.php");
        exit;
    } else {
        $errorMessage = "Información incorrecta. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-direction: column;
            width: 80%;
            max-width: 1024px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .field {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"], input[type="color"], input[type="file"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit-button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 15px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
        }
        .submit-button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .gallery img {
            cursor: pointer;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }
        .gallery img.selected {
            border-color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="field">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Introduce tu contraseña" required>
            </div>
            <div class="field">
                <label for="color">Selector de color</label>
                <input type="color" id="color" name="color" required>
            </div>
            <div class="field">
                <label for="image">Selector de imagen</label>
                <div class="gallery">
                    <?php
                    $imageDir = "C:/xampp/htdocs/website/images";
                    $images = glob($imageDir . "/*.jpg");

                    foreach ($images as $image) {
                        $imageName = basename($image);
                        echo "<img src='images/$imageName' data-name='$imageName' alt='$imageName'>";
                    }
                    ?>
                </div>
                <input type="hidden" id="selectedImage" name="selectedImage">
            </div>
            <?php if (isset($errorMessage)): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <button type="submit" class="submit-button">Enviar</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.gallery img');
            let selectedImage = null;

            images.forEach(img => {
                img.addEventListener('click', () => {
                    images.forEach(i => i.classList.remove('selected'));
                    img.classList.add('selected');
                    selectedImage = img.dataset.name;
                    document.getElementById('selectedImage').value = selectedImage;
                });
            });
        });
    </script>
</body>
</html>

<?php
// Incluir el archivo setup.php que contiene la contraseña encriptada
include 'setup.php';

// Función para desencriptar una contraseña
function decryptPassword($encryptedPassword) {
    // Clave de encriptación (¡cambia esto por la misma clave utilizada en index.php!)
    $encryptionKey = "clave_secreta";

    // Algoritmo de encriptación
    $cipher = "aes-256-cbc";

    // Obtener la contraseña y el IV del valor encriptado
    list($encrypted, $iv) = explode("::", base64_decode($encryptedPassword), 2);

    // Desencriptar la contraseña
    $decrypted = openssl_decrypt($encrypted, $cipher, $encryptionKey, 0, $iv);

    // Retornar la contraseña desencriptada
    return $decrypted;
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la contraseña proporcionada por el usuario
    $password = $_POST["password"];

    // Desencriptar la contraseña almacenada en setup.php
    $decryptedPassword = decryptPassword($encryptedPassword);

    // Verificar si la contraseña ingresada coincide con la contraseña almacenada
    if ($password === $decryptedPassword) {
        // Contraseña correcta, redirigir al usuario a index.php
        header("Location: index.php");
        exit; // Terminar el script para evitar que se siga ejecutando después de la redirección
    } else {
        // Contraseña incorrecta, mostrar mensaje de error
        $errorMessage = "Contraseña incorrecta. Inténtalo de nuevo.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <!-- Estilos CSS -->

<style>
    /* Estilos CSS */
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
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .form-group button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .form-group button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Menu</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="password">Enter Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // JavaScript para mostrar un mensaje de alerta si la contraseña es correcta
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"])): ?>
                var password = "<?php echo $_POST["password"]; ?>";
                var encryptedPassword = "<?php echo $encryptedPassword; ?>";
                if (password === encryptedPassword) {
                    alert("Contraseña correcta. Redirigiendo a la página de inicio.");
                    window.location.href = "index.php";
                } else {
                    alert("Contraseña incorrecta. Inténtalo de nuevo.");
                }
            <?php endif; ?>
        });
    </script>
</body>
</html>

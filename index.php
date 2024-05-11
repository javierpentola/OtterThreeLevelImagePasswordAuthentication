<?php
// Función para borrar el contenido de setup.php
function clearSetupFile() {
    file_put_contents("setup.php", "");
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Borrar el contenido de setup.php
    clearSetupFile();

    // Obtener la contraseña proporcionada por el usuario
    $password = $_POST["password"];

    // Encriptar la contraseña
    $encryptedPassword = encryptPassword($password);

    // Guardar la contraseña encriptada en el archivo setup.php
    file_put_contents("setup.php", "<?php \$encryptedPassword = '" . $encryptedPassword . "'; ?>");

    // Redirigir al usuario a menu.php
    header("Location: menu.php");
    exit; // Terminar el script para evitar que se siga ejecutando después de la redirección
}

// Función para encriptar una contraseña
function encryptPassword($password) {
    // Clave de encriptación (¡cambia esto por una clave segura!)
    $encryptionKey = "clave_secreta";

    // Algoritmo de encriptación
    $cipher = "aes-256-cbc";

    // Generar un vector de inicialización (IV) aleatorio
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    // Encriptar la contraseña
    $encrypted = openssl_encrypt($password, $cipher, $encryptionKey, 0, $iv);

    // Retornar la contraseña encriptada con el IV adjunto
    return base64_encode($encrypted . "::" . $iv);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Setup</title>
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
        <h2>Password Setup</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="password">Enter Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector("form");
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Detener el envío para mostrar el alert
        var self = this; // Guardar referencia al formulario para usar después del alert

        // Verificar si las contraseñas coinciden antes de mostrar el alert y enviar el formulario
        if (document.getElementById("password").value !== document.getElementById("confirm_password").value) {
            document.getElementById("confirm_password").setCustomValidity("Las contraseñas no coinciden");
            document.getElementById("confirm_password").reportValidity();
            return; // No continuar si las contraseñas no coinciden
        } else {
            document.getElementById("confirm_password").setCustomValidity("");
            alert("Contraseña incluida");
            self.submit(); // Enviar el formulario programáticamente
        }
    });

    var password = document.getElementById("password");
    var confirm_password = document.getElementById("confirm_password");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Las contraseñas no coinciden");
        } else {
            confirm_password.setCustomValidity("");
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
});
</script>





</body>
</html>

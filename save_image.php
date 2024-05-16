<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['selectedImage'])) {
        $selectedImage = $input['selectedImage'];

        // Guardar la imagen seleccionada en setup.php sin borrar el contenido existente
        $existingSetup = file_get_contents("setup.php");
        $imageLine = "\$selectedImage = '" . $selectedImage . "';\n";
        file_put_contents('setup.php', $existingSetup . $imageLine);

        // Responder con un JSON indicando éxito
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false));
    }
} else {
    // Método de solicitud no permitido
    http_response_code(405);
    echo json_encode(array('success' => false));
}
?>

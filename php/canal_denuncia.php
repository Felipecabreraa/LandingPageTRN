<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificación CAPTCHA
    $captcha = $_POST['g-recaptcha-response'];

    if (empty($captcha)) {
        die("Error: Verifica que no eres un robot.");
    }

    // Validar con Google
    $secret = 'TU_CLAVE_SECRETA'; // ← Sustituye con tu clave secreta
    $response = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha"
    );
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        die("Error: Falló la verificación del CAPTCHA. Intenta nuevamente.");
    }

    // Datos del formulario
    $nombre  = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : 'Anónimo';
    $email   = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : 'No proporcionado';
    $asunto  = isset($_POST['asunto']) ? htmlspecialchars(trim($_POST['asunto'])) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars(trim($_POST['mensaje'])) : '';

    if (empty($asunto) || empty($mensaje)) {
        die("Error: El asunto y el mensaje son obligatorios.");
    }

    // Configura el correo
    $destinatario = "tucorreo@tudominio.com";
    $asunto_correo = "Nueva denuncia: $asunto";

    $cuerpo = "Has recibido una nueva denuncia:\n\n";
    $cuerpo .= "Nombre: $nombre\n";
    $cuerpo .= "Email: $email\n";
    $cuerpo .= "Asunto: $asunto\n\n";
    $cuerpo .= "Mensaje:\n$mensaje\n";

    $headers = "From: canal-denuncias@tudominio.com\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($destinatario, $asunto_correo, $cuerpo, $headers)) {
        echo "Denuncia enviada correctamente. Gracias por tu reporte.";
    } else {
        echo "Error: No se pudo enviar la denuncia. Intenta más tarde.";
    }
} else {
    echo "Acceso no permitido.";
}
?>

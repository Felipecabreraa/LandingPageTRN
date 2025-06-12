<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica reCAPTCHA
    $captcha = $_POST['g-recaptcha-response'] ?? '';

    if (empty($captcha)) {
        die("Error: Verifica que no eres un robot.");
    }

    $secret = '6LcicF4rAAAAAJl1bQGQ0BUb-mEiSSmu3yRjJyll'; // ← Reemplaza con tu clave secreta
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
    $captcha_response = json_decode($verify, true);

    if (!$captcha_response["success"]) {
        die("Error: Falló la verificación del CAPTCHA. Intenta nuevamente.");
    }

    // Recibe datos
    $nombre = !empty($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : 'Anónimo';
    $email = !empty($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : 'No proporcionado';
    $asunto = htmlspecialchars(trim($_POST['asunto']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    if (empty($asunto) || empty($mensaje)) {
        die("Error: El asunto y el mensaje son obligatorios.");
    }

    // Configura correo
    $destinatario = "luis.lagos@trn.cl"; // <-- cámbialo
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

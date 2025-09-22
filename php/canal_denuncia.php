<?php
// Incluir configuración de reCAPTCHA
require_once '../config/recaptcha.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica reCAPTCHA
    $captcha = $_POST['g-recaptcha-response'] ?? '';

    if (empty($captcha)) {
        die("Error: Verifica que no eres un robot.");
    }

    // Usar la clave secreta de la configuración y verificar con cURL
    $secret = RECAPTCHA_SECRET_KEY;
    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $secret,
        'response' => $captcha,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null,
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $verify = curl_exec($ch);
    if ($verify === false) {
        curl_close($ch);
        die('Error: No se pudo verificar reCAPTCHA.');
    }
    curl_close($ch);
    $captcha_response = json_decode($verify, true);

    if (empty($captcha_response["success"])) {
        die("Error: Falló la verificación del CAPTCHA. Intenta nuevamente.");
    }

    // Validar hostname si está configurado
    if (!empty(RECAPTCHA_ALLOWED_DOMAINS) && is_array(RECAPTCHA_ALLOWED_DOMAINS)) {
        $host = $captcha_response['hostname'] ?? '';
        if ($host && !in_array($host, RECAPTCHA_ALLOWED_DOMAINS, true)) {
            die('Error: Dominio no permitido para reCAPTCHA.');
        }
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
    $destinatario = "denuncias@trn.cl"; // <-- cámbialo
    $asunto_correo = "Nueva denuncia: $asunto";

    $cuerpo = "Has recibido una nueva denuncia:\n\n";
    $cuerpo .= "Nombre: $nombre\n";
    $cuerpo .= "Email: $email\n";
    $cuerpo .= "Asunto: $asunto\n\n";
    $cuerpo .= "Mensaje:\n$mensaje\n";

    $headers = "From: denuncias@trn.cl\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($destinatario, $asunto_correo, $cuerpo, $headers)) {
        echo "Denuncia enviada correctamente. Gracias por tu reporte.";
    } else {
        echo "Error: No se pudo enviar la denuncia. Intenta más tarde.";
    }
} else {
    echo "Acceso no permitido.";
}
?>

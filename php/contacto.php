<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(['status' => 'error', 'message' => 'Acceso no permitido.']);
    exit;
}

// Validar reCAPTCHA
$recaptchaSecret = '6LcicF4rAAAAAJl1bQGQ0BUb-mEiSSmu3yRjJyll';
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptchaResponse)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor verifica el reCAPTCHA.']);
    exit;
}

$verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
$responseData = json_decode($verifyResponse);

if (!$responseData->success) {
    echo json_encode(['status' => 'error', 'message' => 'reCAPTCHA inválido. Intenta nuevamente.']);
    exit;
}

// Validar datos del formulario
$nombre = strip_tags(trim($_POST['nombre'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$asunto = strip_tags(trim($_POST['asunto'] ?? ''));
$mensaje = trim($_POST['mensaje'] ?? '');

if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor completa todos los campos.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Correo electrónico no válido.']);
    exit;
}

// Enviar email
$destino = "contacto@trn.cl";
$boundary = md5(uniqid(time()));

$headers = "From: $nombre <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

$contenido = "--$boundary\r\n";
$contenido .= "Content-Type: text/plain; charset=UTF-8\r\n";
$contenido .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$contenido .= "Nombre: $nombre\n";
$contenido .= "Correo: $email\n\n";
$contenido .= "Asunto: $asunto\n\n";
$contenido .= "Mensaje:\n$mensaje\n\n";
$contenido .= "--$boundary--";

if (mail($destino, $asunto, $contenido, $headers)) {
    echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al enviar el mensaje.']);
}
?>

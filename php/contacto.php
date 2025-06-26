<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(['status' => 'error', 'message' => 'Acceso no permitido.']);
    exit;
}

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

$destino = "luis.lagos@trn.cl";
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

// Si tienes adjuntos (opcional) - lo omito para simplificar aquí

$contenido .= "--$boundary--";

if (mail($destino, $asunto, $contenido, $headers)) {
    echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al enviar el mensaje.']);
}
?>

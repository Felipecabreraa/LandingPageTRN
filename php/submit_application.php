<?php
header('Content-Type: application/json');

$recaptchaSecret = '6LcicF4rAAAAAJl1bQGQ0BUb-mEiSSmu3yRjJyll';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

if (!isset($_POST['g-recaptcha-response'])) {
    echo json_encode(['success' => false, 'message' => 'Validación reCAPTCHA faltante.']);
    exit;
}

$recaptchaResponse = $_POST['g-recaptcha-response'];
$remoteIp = $_SERVER['REMOTE_ADDR'];

$verifyResponse = file_get_contents(
    "https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse&remoteip=$remoteIp"
);

$responseData = json_decode($verifyResponse);

if (!$responseData->success) {
    echo json_encode(['success' => false, 'message' => 'Falló la verificación reCAPTCHA.']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$messageText = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($phone)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email inválido.']);
    exit;
}

if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Debes adjuntar tu CV en formato PDF.']);
    exit;
}

$cv = $_FILES['cv'];
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($cv['tmp_name']);

if ($mimeType !== 'application/pdf') {
    echo json_encode(['success' => false, 'message' => 'Solo se permiten archivos PDF.']);
    exit;
}

if ($cv['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'El archivo es demasiado grande. Máximo 5MB.']);
    exit;
}

// Leer contenido del archivo CV
$fileContent = file_get_contents($cv['tmp_name']);
$fileContentEncoded = chunk_split(base64_encode($fileContent));
$fileName = basename($cv['name']);

$to = 'postulaciones@trn.cl';
$subject = "Nueva Postulación - $name";

// Boundary para multipart
$boundary = md5(time());

// Cabeceras
$headers = "From: \"$name\" <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

// Cuerpo del mensaje multipart
$message = "--$boundary\r\n";
$message .= "Content-Type: text/html; charset=UTF-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";

$message .= "<html><body>";
$message .= "<h2 style='color:#2E86C1;'>Nuevo Postulante</h2>";
$message .= "<p><strong>Nombre:</strong> " . htmlspecialchars($name) . "</p>";
$message .= "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
$message .= "<p><strong>Teléfono:</strong> " . htmlspecialchars($phone) . "</p>";

if (!empty($messageText)) {
    $message .= "<p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($messageText)) . "</p>";
}

$message .= "<p>Adjunto se encuentra el CV en formato PDF.</p>";
$message .= "</body></html>\r\n\r\n";

// Adjuntar el archivo PDF
$message .= "--$boundary\r\n";
$message .= "Content-Type: application/pdf; name=\"$fileName\"\r\n";
$message .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
$message .= "Content-Transfer-Encoding: base64\r\n\r\n";
$message .= $fileContentEncoded . "\r\n";
$message .= "--$boundary--";

// Enviar correo
if (mail($to, $subject, $message, $headers)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se pudo enviar el correo.']);
}

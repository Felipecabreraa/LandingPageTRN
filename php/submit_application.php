<?php
// Clave secreta de tu reCAPTCHA (obtenida de Google)
$recaptchaSecret = '6LcicF4rAAAAAJl1bQGQ0BUb-mEiSSmu3yRjJyll';

// Verifica que el método sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que exista el token de reCAPTCHA
    if (!isset($_POST['g-recaptcha-response'])) {
        die('Error: Validación reCAPTCHA faltante.');
    }

    // Validar reCAPTCHA con Google
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $remoteIp = $_SERVER['REMOTE_ADDR'];

    $verifyResponse = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptchaSecret . "&response=" . $recaptchaResponse . "&remoteip=" . $remoteIp
    );

    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        die('Error: Falló la verificación reCAPTCHA.');
    }

    // Validaciones normales
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (empty($name) || empty($email) || empty($phone)) {
        die('Error: Todos los campos son obligatorios.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Error: Email inválido.');
    }

    if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
        die('Error: Debes adjuntar tu CV en formato PDF.');
    }

    $cv = $_FILES['cv'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($cv['tmp_name']);

    if ($mimeType !== 'application/pdf') {
        die('Error: Solo se permiten archivos PDF.');
    }

    if ($cv['size'] > 5 * 1024 * 1024) {
        die('Error: El archivo es demasiado grande. Máximo 5MB.');
    }

    $uploadDir = __DIR__ . '/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = uniqid('cv_', true) . '.pdf';
    $destination = $uploadDir . '/' . $fileName;

    if (!move_uploaded_file($cv['tmp_name'], $destination)) {
        die('Error: No se pudo guardar el archivo.');
    }

    // Enviar correo (simple, sin adjunto)
    $to = 'rrhh@trn.com'; // Reemplaza con correo real
    $subject = 'Nueva Postulación - ' . $name;
    $message = "Nombre: $name\nCorreo: $email\nTeléfono: $phone\nCV: $fileName\n";
    $headers = "From: no-reply@trn.com\r\nReply-To: $email\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "¡Solicitud enviada correctamente!";
    } else {
        echo "Error: No se pudo enviar el correo.";
    }

} else {
    header('Location: ../trabaja-con.php');
    exit;
}
?>

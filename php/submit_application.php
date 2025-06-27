<?php
header('Content-Type: application/json');

$recaptchaSecret = '6LcicF4rAAAAAJl1bQGQ0BUb-mEiSSmu3yRjJyll';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $uploadDir = __DIR__ . '/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = uniqid('cv_', true) . '.pdf';
    $destination = $uploadDir . '/' . $fileName;

    if (!move_uploaded_file($cv['tmp_name'], $destination)) {
        echo json_encode(['success' => false, 'message' => 'No se pudo guardar el archivo.']);
        exit;
    }

    $to = 'postulaciones@trn.cl';
    $subject = 'Nueva Postulación - ' . $name;
    $message = "Nombre: $name\nCorreo: $email\nTeléfono: $phone\nCV: $fileName\n";
    $headers = "From: no-reply@trn.com\r\nReply-To: $email\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo enviar el correo.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $asunto = htmlspecialchars($_POST['asunto']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    // Validación básica
    if (!$email) {
        die("Correo no válido.");
    }

    $to = "luis.lagos@trn.cl"; // Cambia esto a tu correo
    $boundary = md5(time());
    $headers = "From: $nombre <$email>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";

    // Cuerpo del mensaje
    $body = "--{$boundary}\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= "Nombre: $nombre\nCorreo: $email\nAsunto: $asunto\nMensaje:\n$mensaje\n";

    // Archivo adjunto
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['archivo']['tmp_name'];
        $file_name = basename($_FILES['archivo']['name']);
        $file_type = mime_content_type($file_tmp);
        $file_data = chunk_split(base64_encode(file_get_contents($file_tmp)));

        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: {$file_type}; name=\"{$file_name}\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"{$file_name}\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $file_data . "\r\n";
    }

    $body .= "--{$boundary}--";

    // Envío del correo
    if (mail($to, $asunto, $body, $headers)) {
        echo "Correo enviado correctamente.";
    } else {
        echo "Error al enviar el correo.";
    }
} else {
    echo "Método no permitido.";
}
?>

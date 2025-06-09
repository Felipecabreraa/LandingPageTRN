<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = strip_tags(trim($_POST['nombre']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $asunto = strip_tags(trim($_POST['asunto']));
    $mensaje = trim($_POST['mensaje']);

    // Validación básica
    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        die("Por favor completa todos los campos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido.");
    }

    // Procesar el archivo adjunto si se ha subido uno
    $archivoAdjunto = null;
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $archivoNombre = basename($_FILES['archivo']['name']);
        $archivoRutaTmp = $_FILES['archivo']['tmp_name'];
        $archivoDestino = "uploads/" . $archivoNombre;

        // Crear carpeta 'uploads' si no existe
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        // Mover archivo al directorio 'uploads'
        if (move_uploaded_file($archivoRutaTmp, $archivoDestino)) {
            $archivoAdjunto = file_get_contents($archivoDestino);
            $archivoAdjunto = chunk_split(base64_encode($archivoAdjunto));
        } else {
            die("Error al cargar el archivo.");
        }
    }

    // Dirección a la que se enviará el correo
    $destino = "luis.lagos@trn.cl"; // Cambia esto por tu dirección de correo

    // Encabezados y contenido MIME
    $boundary = md5(uniqid(time())); // Generar un límite único para separar el contenido

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
    
    // Si hay un archivo adjunto, lo agregamos al contenido
    if ($archivoAdjunto) {
        $contenido .= "--$boundary\r\n";
        $contenido .= "Content-Type: application/octet-stream; name=\"$archivoNombre\"\r\n";
        $contenido .= "Content-Transfer-Encoding: base64\r\n";
        $contenido .= "Content-Disposition: attachment; filename=\"$archivoNombre\"\r\n\r\n";
        $contenido .= $archivoAdjunto . "\r\n\r\n";
    }

    $contenido .= "--$boundary--";

    // Enviar el correo
    if (mail($destino, $asunto, $contenido, $headers)) {
        echo "<script>alert('Mensaje enviado correctamente.');</script>";
    } else {
        echo "<script>alert('Error al enviar el mensaje.');</script>";
    }
} else {
    echo "Acceso no permitido.";
}
?>

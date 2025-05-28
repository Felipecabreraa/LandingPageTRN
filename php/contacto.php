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

    // Procesar el archivo adjunto
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
            $archivoInfo = "Archivo adjunto: " . $archivoNombre;
        } else {
            $archivoInfo = "Error al cargar el archivo.";
        }
    } else {
        $archivoInfo = "No se adjuntó ningún archivo.";
    }

    // Dirección a la que se enviará el correo
    $destino = "luis.lagos@trn.cl"; // Cambia esto por tu dirección de correo

    // Contenido del correo
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo: $email\n\n";
    $contenido .= "Asunto: $asunto\n\n";
    $contenido .= "Mensaje:\n$mensaje\n\n";
    $contenido .= $archivoInfo; // Mostrar información del archivo

    // Encabezados del correo
    $headers = "From: $nombre <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Enviar el correo
    if (mail($destino, $asunto, $contenido, $headers)) {
        echo "Mensaje enviado correctamente.";
    } else {
        echo "Error al enviar el mensaje.";
    }
} else {
    echo "Acceso no permitido.";
}
?>

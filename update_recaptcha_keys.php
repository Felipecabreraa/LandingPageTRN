<?php
// Script para actualizar las claves de reCAPTCHA en todos los archivos HTML
// Ejecutar este script después de obtener las nuevas claves de Google

// Incluir configuración
require_once 'config/recaptcha.php';

// Archivos HTML que contienen reCAPTCHA
$htmlFiles = [
    'index.html',
    'trabaja-con.html'
];

// Clave antigua a reemplazar
$oldSiteKey = '6LcicF4rAAAAAKP_rL_enSzaVzj0YfSPx-81hhbN';

// Nueva clave del sitio
$newSiteKey = RECAPTCHA_SITE_KEY;

echo "Actualizando claves de reCAPTCHA...\n";
echo "Clave antigua: $oldSiteKey\n";
echo "Clave nueva: $newSiteKey\n\n";

foreach ($htmlFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $updatedContent = str_replace($oldSiteKey, $newSiteKey, $content);
        
        if ($content !== $updatedContent) {
            file_put_contents($file, $updatedContent);
            echo "✅ Actualizado: $file\n";
        } else {
            echo "ℹ️  No se encontraron cambios en: $file\n";
        }
    } else {
        echo "❌ Archivo no encontrado: $file\n";
    }
}

echo "\n¡Actualización completada!\n";
echo "Recuerda también actualizar la clave secreta en config/recaptcha.php\n";
?>




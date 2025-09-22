<?php
// Verificar configuración de reCAPTCHA
echo "<h2>🔍 Verificación de Configuración reCAPTCHA</h2>";

// Verificar si el archivo de configuración existe
if (file_exists('config/recaptcha.php')) {
    echo "✅ Archivo config/recaptcha.php existe<br>";
    
    // Incluir configuración
    require_once 'config/recaptcha.php';
    
    // Verificar que las constantes están definidas
    if (defined('RECAPTCHA_SITE_KEY')) {
        echo "✅ RECAPTCHA_SITE_KEY definida: " . RECAPTCHA_SITE_KEY . "<br>";
    } else {
        echo "❌ RECAPTCHA_SITE_KEY no está definida<br>";
    }
    
    if (defined('RECAPTCHA_SECRET_KEY')) {
        echo "✅ RECAPTCHA_SECRET_KEY definida: " . RECAPTCHA_SECRET_KEY . "<br>";
    } else {
        echo "❌ RECAPTCHA_SECRET_KEY no está definida<br>";
    }
    
    if (defined('RECAPTCHA_ALLOWED_DOMAINS')) {
        echo "✅ RECAPTCHA_ALLOWED_DOMAINS definida<br>";
        echo "Dominios permitidos: " . implode(', ', RECAPTCHA_ALLOWED_DOMAINS) . "<br>";
    } else {
        echo "❌ RECAPTCHA_ALLOWED_DOMAINS no está definida<br>";
    }
    
} else {
    echo "❌ Archivo config/recaptcha.php no existe<br>";
}

echo "<br><h3>📋 Información del servidor:</h3>";
echo "Dominio actual: " . $_SERVER['HTTP_HOST'] . "<br>";
echo "URL actual: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "PHP Version: " . phpversion() . "<br>";

echo "<br><h3>🧪 Prueba de conexión a Google reCAPTCHA:</h3>";

// Probar conexión a Google reCAPTCHA
$testUrl = "https://www.google.com/recaptcha/api/siteverify";
$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'user_agent' => 'Mozilla/5.0 (compatible; TestBot/1.0)'
    ]
]);

$response = @file_get_contents($testUrl, false, $context);
if ($response !== false) {
    echo "✅ Conexión a Google reCAPTCHA exitosa<br>";
} else {
    echo "❌ Error de conexión a Google reCAPTCHA<br>";
    echo "Error: " . error_get_last()['message'] . "<br>";
}

echo "<br><h3>📁 Verificación de archivos PHP:</h3>";

$files = [
    'php/canal_denuncia.php',
    'php/contacto.php',
    'php/submit_application.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ $file existe<br>";
    } else {
        echo "❌ $file no existe<br>";
    }
}

echo "<br><h3>🔗 Enlaces de prueba:</h3>";
echo '<a href="test_recaptcha_simple.html" target="_blank">🧪 Probar reCAPTCHA</a><br>';
echo '<a href="index.html" target="_blank">🏠 Ir al sitio principal</a><br>';
?>



<?php
// Lee el archivo .env (claves y datos que NO se suben a GitHub)
function cargar_env(): void {
    $archivo = __DIR__ . '/../.env';
    if (!is_file($archivo)) return;
    foreach (file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
        $linea = trim($linea);
        if ($linea === '' || $linea[0] === '#' || strpos($linea, '=') === false) continue;
        [$k, $v] = explode('=', $linea, 2);
        $_ENV[trim($k)] = trim($v);
    }
}
cargar_env();

function env(string $clave, $defecto = null) {
    return $_ENV[$clave] ?? $defecto;
}

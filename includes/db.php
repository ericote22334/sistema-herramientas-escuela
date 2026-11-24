<?php
require_once __DIR__ . '/../config/config.php';

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . env('DB_HOST', 'localhost') . ';dbname=' . env('DB_NAME', 'herramientas_eest1') . ';charset=utf8mb4';
        try {
            $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', ''), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            exit('No se pudo conectar a la base de datos. Revisá el archivo .env');
        }
    }
    return $pdo;
}

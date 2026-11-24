<?php
// Uso (una sola vez, desde la terminal):  php database/seed.php
// Crea un director y un encargado de prueba + herramientas de ejemplo.
require_once __DIR__ . '/../includes/db.php';
$pdo = db();

$usuarios = [
  ['Director/a', 'director', 'Director123', 'director', null, null],
  ['Encargado de Pañol', 'encargado', 'Encargado123', 'encargado', 'mañana', '07:30 a 12:30'],
];
$q = $pdo->prepare('INSERT IGNORE INTO usuarios (nombre, usuario, password_hash, rol, turno, horario) VALUES (?,?,?,?,?,?)');
foreach ($usuarios as $u) {
    $q->execute([$u[0], $u[1], password_hash($u[2], PASSWORD_DEFAULT), $u[3], $u[4], $u[5]]);
}

if ((int)$pdo->query('SELECT COUNT(*) FROM herramientas')->fetchColumn() === 0) {
    $h = $pdo->prepare('INSERT INTO herramientas (nombre, categoria, stock_total, stock_disponible) VALUES (?,?,?,?)');
    foreach ([['Martillo', 'Manuales', 10, 10], ['Destornillador Phillips', 'Manuales', 15, 15], ['Taladro', 'Eléctricas', 4, 4], ['Calibre', 'Medición', 6, 6]] as $r) {
        $h->execute($r);
    }
}
echo "Listo. Usuarios: director / Director123  y  encargado / Encargado123 (cambiar las claves luego)\n";

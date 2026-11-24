<?php
// API JSON de herramientas (la usa AJAX desde assets/js/herramientas.js)
require_once __DIR__ . '/../../includes/auth.php';
header('Content-Type: application/json; charset=utf-8');

function responder(array $datos, int $codigo = 200): void {
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!usuario_actual()) responder(['error' => 'Sesión no iniciada.'], 401);

$accion = $_GET['accion'] ?? $_POST['accion'] ?? 'listar';
$pdo = db();

try {
    if ($accion === 'listar') {
        responder(['datos' => $pdo->query('SELECT id, nombre, categoria, stock_total, stock_disponible FROM herramientas ORDER BY nombre')->fetchAll()]);
    }

    // Todo lo que modifica datos: solo POST + token CSRF
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') responder(['error' => 'Método no permitido.'], 405);
    if (!validar_csrf($_POST['csrf'] ?? null)) responder(['error' => 'Token inválido, recargá la página.'], 403);

    if ($accion === 'guardar') {
        $id = (int)($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $total = filter_var($_POST['stock_total'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 9999]]);

        $errores = [];
        if (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 80) $errores[] = 'El nombre debe tener entre 2 y 80 caracteres.';
        if ($categoria === '' || mb_strlen($categoria) > 50) $errores[] = 'La categoría es obligatoria (máx. 50 caracteres).';
        if ($total === false) $errores[] = 'La cantidad debe ser un número entero entre 0 y 9999.';
        if ($errores) responder(['error' => implode(' ', $errores)], 422);

        if ($id === 0) {
            $q = $pdo->prepare('INSERT INTO herramientas (nombre, categoria, stock_total, stock_disponible) VALUES (?,?,?,?)');
            $q->execute([$nombre, $categoria, $total, $total]);
        } else {
            $q = $pdo->prepare('SELECT stock_total, stock_disponible FROM herramientas WHERE id = ?');
            $q->execute([$id]);
            $actual = $q->fetch();
            if (!$actual) responder(['error' => 'La herramienta no existe.'], 404);
            $prestadas = $actual['stock_total'] - $actual['stock_disponible'];
            if ($total < $prestadas) responder(['error' => "No podés bajar el total a $total: hay $prestadas unidades prestadas."], 422);
            $q = $pdo->prepare('UPDATE herramientas SET nombre=?, categoria=?, stock_total=?, stock_disponible=? WHERE id=?');
            $q->execute([$nombre, $categoria, $total, $total - $prestadas, $id]);
        }
        responder(['ok' => true]);
    }

    if ($accion === 'eliminar') {
        if (!es_director()) responder(['error' => 'Solo el director puede eliminar herramientas.'], 403);
        $id = (int)($_POST['id'] ?? 0);
        $q = $pdo->prepare('SELECT COUNT(*) FROM prestamos WHERE herramienta_id = ?');
        $q->execute([$id]);
        if ((int)$q->fetchColumn() > 0) responder(['error' => 'No se puede eliminar: la herramienta tiene historial de préstamos.'], 409);
        $pdo->prepare('DELETE FROM herramientas WHERE id = ?')->execute([$id]);
        responder(['ok' => true]);
    }

    responder(['error' => 'Acción desconocida.'], 400);
} catch (PDOException $e) {
    responder(['error' => 'Error en la base de datos. Intentá de nuevo.'], 500);
}

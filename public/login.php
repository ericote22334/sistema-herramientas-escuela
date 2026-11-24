<?php
require_once __DIR__ . '/../includes/auth.php';
if (usuario_actual()) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validar_csrf($_POST['csrf'] ?? null)) {
        $error = 'La sesión expiró, volvé a intentar.';
    } else {
        $usuario = trim($_POST['usuario'] ?? '');
        $clave = $_POST['clave'] ?? '';
        if ($usuario === '' || $clave === '') {
            $error = 'Completá usuario y contraseña.';
        } else {
            $q = db()->prepare('SELECT id, nombre, usuario, password_hash, rol FROM usuarios WHERE usuario = ? AND activo = 1');
            $q->execute([$usuario]);
            $fila = $q->fetch();
            if ($fila && password_verify($clave, $fila['password_hash'])) {
                session_regenerate_id(true);
                unset($fila['password_hash']);
                $_SESSION['usuario'] = $fila;
                header('Location: index.php'); exit;
            }
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ingresar · E.E.S.T. Nº 1</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/estilos.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="card login-caja shadow-sm">
    <div class="card-body p-4">
      <div class="text-center mb-3">
        <img src="assets/img/logo.svg" alt="Logo" height="70">
        <h1 class="h4 mt-2">Sistema de herramientas</h1>
        <p class="text-muted small mb-0">E.E.S.T. Nº 1 · Santa Teresita</p>
      </div>
      <?php if ($error): ?><div class="alert alert-danger py-2"><?= e($error) ?></div><?php endif; ?>
      <form method="post" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= e(token_csrf()) ?>">
        <div class="mb-3">
          <label class="form-label" for="usuario">Usuario</label>
          <input class="form-control" id="usuario" name="usuario" required maxlength="40" autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label" for="clave">Contraseña</label>
          <input class="form-control" type="password" id="clave" name="clave" required>
        </div>
        <button class="btn btn-escuela w-100">Ingresar</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>

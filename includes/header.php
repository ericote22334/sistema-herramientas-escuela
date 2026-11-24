<?php
// Variables esperadas: $titulo (string)
$u = usuario_actual();
$pagina = basename($_SERVER['SCRIPT_NAME']);
function nav_item(string $archivo, string $texto, string $pagina): string {
    $activo = $archivo === $pagina ? ' active' : '';
    return '<li class="nav-item"><a class="nav-link' . $activo . '" href="' . $archivo . '">' . $texto . '</a></li>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($titulo ?? 'Sistema de Herramientas') ?> · E.E.S.T. Nº 1</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/estilos.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-escuela">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <img src="assets/img/logo.svg" alt="Logo E.E.S.T. Nº 1" height="36">
      <span>Pañol E.E.S.T. Nº 1</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-label="Menú">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav me-auto">
        <?= nav_item('index.php', 'Inicio', $pagina) ?>
        <?= nav_item('herramientas.php', 'Herramientas', $pagina) ?>
        <?php /* Próximas versiones: retiros.php, devoluciones.php, historial.php, reportes.php, usuarios.php */ ?>
      </ul>
      <?php if ($u): ?>
      <div class="d-flex align-items-center gap-3 text-white">
        <span class="small"><?= e($u['nombre']) ?> <span class="badge bg-light text-dark"><?= e(ucfirst($u['rol'])) ?></span></span>
        <a class="btn btn-sm btn-outline-light" href="logout.php">Salir</a>
      </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main class="container py-4">

<?php
require_once __DIR__ . '/../includes/auth.php';
requerir_login();
$titulo = 'Inicio';

$r = db()->query('SELECT COUNT(*) AS tipos, COALESCE(SUM(stock_total),0) AS total, COALESCE(SUM(stock_disponible),0) AS disponible FROM herramientas')->fetch();
$prestadas = (int)$r['total'] - (int)$r['disponible'];

include __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-4">Hola, <?= e(usuario_actual()['nombre']) ?></h1>
<div class="row g-3">
  <div class="col-12 col-md-4"><div class="card tarjeta-dato"><div class="card-body">
    <div class="text-muted small">Tipos de herramientas</div><div class="display-6"><?= (int)$r['tipos'] ?></div></div></div></div>
  <div class="col-12 col-md-4"><div class="card tarjeta-dato verde"><div class="card-body">
    <div class="text-muted small">Unidades disponibles</div><div class="display-6"><?= (int)$r['disponible'] ?></div></div></div></div>
  <div class="col-12 col-md-4"><div class="card tarjeta-dato amarilla"><div class="card-body">
    <div class="text-muted small">Unidades prestadas ahora</div><div class="display-6"><?= $prestadas ?></div></div></div></div>
</div>
<div class="mt-4"><a class="btn btn-escuela" href="herramientas.php">Ver herramientas</a></div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/auth.php';
requerir_login();
$titulo = 'Herramientas';
$scripts = ['herramientas.js'];
include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h1 class="h3 mb-0">Herramientas y stock</h1>
  <button class="btn btn-escuela" id="btn-nueva">+ Nueva herramienta</button>
</div>

<input type="search" id="buscador" class="form-control mb-3" placeholder="Buscar por nombre o categoría...">
<div id="mensaje"></div>

<div class="table-responsive bg-white rounded shadow-sm">
  <table class="table table-hover align-middle mb-0">
    <thead class="table-light"><tr><th>Nombre</th><th>Categoría</th><th class="text-center">Total</th><th class="text-center">Disponible</th><th class="text-end">Acciones</th></tr></thead>
    <tbody id="tabla"><tr><td colspan="5" class="text-center text-muted py-4">Cargando...</td></tr></tbody>
  </table>
</div>

<div class="modal fade" id="modal" tabindex="-1">
  <div class="modal-dialog"><form class="modal-content" id="form" novalidate>
    <div class="modal-header"><h2 class="modal-title h5" id="modal-titulo">Herramienta</h2><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
      <div id="form-error" class="alert alert-danger d-none py-2"></div>
      <input type="hidden" name="id" id="f-id">
      <div class="mb-3"><label class="form-label" for="f-nombre">Nombre</label><input class="form-control" id="f-nombre" name="nombre" maxlength="80" required></div>
      <div class="mb-3"><label class="form-label" for="f-categoria">Categoría</label><input class="form-control" id="f-categoria" name="categoria" maxlength="50" placeholder="Manuales, Eléctricas, Medición..." required></div>
      <div class="mb-3"><label class="form-label" for="f-stock">Cantidad total</label><input class="form-control" type="number" id="f-stock" name="stock_total" min="0" max="9999" required></div>
    </div>
    <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-escuela">Guardar</button></div>
  </form></div>
</div>

<script>window.APP = { csrf: <?= json_encode(token_csrf()) ?>, esDirector: <?= es_director() ? 'true' : 'false' ?> };</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>

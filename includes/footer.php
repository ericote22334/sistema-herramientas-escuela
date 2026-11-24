</main>
<footer class="text-center small text-muted py-3">E.E.S.T. Nº 1 · Santa Teresita · Sistema de herramientas</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php foreach (($scripts ?? []) as $s): ?>
<script src="assets/js/<?= e($s) ?>"></script>
<?php endforeach; ?>
</body>
</html>

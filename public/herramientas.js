const tabla = document.getElementById('tabla');
const mensaje = document.getElementById('mensaje');
const formError = document.getElementById('form-error');
const modal = new bootstrap.Modal(document.getElementById('modal'));
let herramientas = [];

const esc = (t) => String(t).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

function avisar(texto, tipo = 'success') {
  mensaje.innerHTML = `<div class="alert alert-${tipo} py-2">${esc(texto)}</div>`;
  setTimeout(() => (mensaje.innerHTML = ''), 4000);
}

async function pedir(url, opciones) {
  try {
    const r = await fetch(url, opciones);
    const datos = await r.json();
    if (!r.ok) throw new Error(datos.error || 'Error inesperado.');
    return datos;
  } catch (e) {
    if (e instanceof TypeError) throw new Error('No hay conexión con el servidor.');
    throw e;
  }
}

function insignia(h) {
  if (h.stock_disponible === 0) return 'badge-stock-cero';
  if (h.stock_disponible <= Math.ceil(h.stock_total * 0.2)) return 'badge-stock-bajo';
  return 'badge-stock-ok';
}

function dibujar() {
  const filtro = document.getElementById('buscador').value.toLowerCase();
  const lista = herramientas.filter((h) => (h.nombre + ' ' + h.categoria).toLowerCase().includes(filtro));
  if (!lista.length) {
    tabla.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No hay herramientas para mostrar.</td></tr>';
    return;
  }
  tabla.innerHTML = lista.map((h) => `
    <tr>
      <td>${esc(h.nombre)}</td><td>${esc(h.categoria)}</td>
      <td class="text-center">${h.stock_total}</td>
      <td class="text-center"><span class="badge ${insignia(h)}">${h.stock_disponible}</span></td>
      <td class="text-end">
        <button class="btn btn-sm btn-outline-primary" data-editar="${h.id}">Editar</button>
        ${window.APP.esDirector ? `<button class="btn btn-sm btn-outline-danger" data-eliminar="${h.id}">Eliminar</button>` : ''}
      </td>
    </tr>`).join('');
}

async function cargar() {
  try {
    herramientas = (await pedir('api/herramientas.php?accion=listar')).datos;
    dibujar();
  } catch (e) {
    tabla.innerHTML = `<tr><td colspan="5" class="text-center text-danger py-4">${esc(e.message)}</td></tr>`;
  }
}

function abrirFormulario(h) {
  formError.classList.add('d-none');
  document.getElementById('modal-titulo').textContent = h ? 'Editar herramienta' : 'Nueva herramienta';
  document.getElementById('f-id').value = h ? h.id : 0;
  document.getElementById('f-nombre').value = h ? h.nombre : '';
  document.getElementById('f-categoria').value = h ? h.categoria : '';
  document.getElementById('f-stock').value = h ? h.stock_total : '';
  modal.show();
}

document.getElementById('btn-nueva').addEventListener('click', () => abrirFormulario(null));
document.getElementById('buscador').addEventListener('input', dibujar);

tabla.addEventListener('click', async (ev) => {
  const idEditar = ev.target.dataset.editar;
  const idEliminar = ev.target.dataset.eliminar;
  if (idEditar) abrirFormulario(herramientas.find((h) => h.id == idEditar));
  if (idEliminar && confirm('¿Eliminar esta herramienta? Esta acción no se puede deshacer.')) {
    const datos = new FormData();
    datos.append('accion', 'eliminar'); datos.append('id', idEliminar); datos.append('csrf', window.APP.csrf);
    try {
      await pedir('api/herramientas.php', { method: 'POST', body: datos });
      avisar('Herramienta eliminada.'); cargar();
    } catch (e) { avisar(e.message, 'danger'); }
  }
});

document.getElementById('form').addEventListener('submit', async (ev) => {
  ev.preventDefault();
  const datos = new FormData(ev.target);
  datos.append('accion', 'guardar'); datos.append('csrf', window.APP.csrf);
  try {
    await pedir('api/herramientas.php', { method: 'POST', body: datos });
    modal.hide(); avisar('Herramienta guardada.'); cargar();
  } catch (e) {
    formError.textContent = e.message; formError.classList.remove('d-none');
  }
});

cargar();

# Metodología de trabajo

## Elección: Kanban con iteraciones semanales (enfoque ágil)

Equipo de **2 personas** y **un solo mes de TP** (menos de una semana para lo que queda). Scrum completo (roles, daily, reuniones largas) sería burocracia. Se eligió **Kanban** con **entregas incrementales** por versión.

**¿Por qué no cascada?** En cascada se diseña todo, luego se programa y recién al final se prueba. Si algo fallaba en la integración con Telegram, nos enterábamos tarde. Con versiones chicas, cada una funcional, se detectan errores a tiempo y se pueden mostrar avances (el TP lo exige en cada entrega).

## Cómo trabajamos

- **Tablero Kanban** (GitHub Projects) con columnas: *Pendiente → En curso → En revisión → Hecho*.
- **Límite de trabajo en curso:** máximo 2 tareas por persona a la vez.
- **Una versión funcional por iteración** (V1 a V5), siempre ejecutable.
- **Commits frecuentes** de los dos, con mensajes claros, y `git pull` antes de empezar.
- **Revisión cruzada:** cada uno prueba y explica el módulo del otro, porque en la defensa los dos deben conocer todo.
- **Reunión corta** al empezar cada jornada (qué hice, qué sigue, qué me traba).

## Iteraciones

| Versión | Fecha | Objetivo |
|---|---|---|
| V1 | 23–24/11 | Base, login con dos roles, herramientas y stock |
| V2 | 25–26/11 | Usuarios, retiros y devoluciones |
| V3 | 27–28/11 | Historiales con filtros y notificaciones Telegram |
| V4 | 29/11 | Reportes y alertas de no devueltas |
| V5 | 30/11 | Pruebas, documentación, manual, Docker y retrospectiva |
| Colchón | 1/12 | Corrección de errores y ensayo de la defensa |

## Reparto de responsabilidades

- **Eric Roth:** login y usuarios, notificaciones por Telegram (Menú A), arquitectura y pantallas.
- **Joaquín Ferreira:** herramientas, retiros y devoluciones, reportes (Menú B), pruebas automatizadas.

Cada uno es responsable de su módulo, pero ambos revisan el código del otro.

## Gestión de riesgos

| Riesgo | Plan |
|---|---|
| Poco tiempo | Orden de prioridad: primero lo obligatorio, después los extras (Docker, nube) |
| Telegram falla | Manejo de errores y reintentos; el sistema funciona aunque no haya aviso |
| Conflictos en Git | Cada uno trabaja en archivos distintos y se hace `pull` antes de `push` |
| Uno se atrasa | El otro ayuda; se revisa el tablero cada jornada |

## Definición de "hecho"

Una tarea está hecha cuando funciona en la computadora del otro integrante, valida los datos de entrada, maneja errores y está subida a GitHub.

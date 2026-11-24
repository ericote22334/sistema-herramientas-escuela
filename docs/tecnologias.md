# Tecnologías elegidas y por qué

| Capa | Tecnología | Por qué |
|---|---|---|
| Lenguaje del servidor | **PHP 8** | Se ve en la materia, corre en cualquier hosting y viene en XAMPP. Alcanza para un sistema web con sesiones y base de datos sin configuración extra. |
| Base de datos | **MySQL** (acceso con **PDO**) | Relacional, gratuita y con transacciones. PDO con consultas preparadas evita la **inyección SQL**. |
| Estructura web | **HTML5 + Bootstrap 5** | Diseño **responsive** con poco código, lo que cumple el requisito de que se vea bien en celular (el encargado puede usar el teléfono). |
| Interactividad | **JavaScript + `fetch` (AJAX)** | Las tablas y los formularios se actualizan sin recargar la página y con mensajes de error claros. |
| Gráficos | **Chart.js** | Biblioteca liviana por CDN para los reportes del Menú B. |
| Notificaciones (Menú A) | **API de Telegram Bot** | Gratuita, sin verificación de empresa (WhatsApp es de pago) y llega al teléfono del director al instante. |
| Pruebas | **PHPUnit** | Estándar para pruebas automatizadas en PHP. |
| Control de versiones | **Git + GitHub** | Obligatorio; repositorio compartido con el docente. |
| Contenedores (extra) | **Docker** | Permite que cualquiera instale el sistema con un solo comando. |
| Entorno de desarrollo | **XAMPP + VS Code** | Gratuitos y conocidos por los dos integrantes. |

## Decisiones de seguridad

- Contraseñas con `password_hash()` / `password_verify()`.
- Consultas preparadas en todo acceso a la base de datos.
- Escape de salida (`htmlspecialchars`) contra **XSS**.
- Token **CSRF** en los formularios que modifican datos.
- Permisos controlados en el **servidor** (no solo ocultando botones).
- Claves (token del bot, datos de la base) en `.env`, que está en `.gitignore`.

## Alternativas descartadas

- **Node.js + framework:** más potente, pero ninguno de los dos lo domina tan bien y el plazo es de una semana.
- **MongoDB:** los datos son claramente relacionales y el stock necesita transacciones.
- **WhatsApp:** requiere cuenta empresarial y es de pago; el TP pide APIs gratuitas.
- **Email:** funciona, pero necesita configurar un servidor SMTP, y un aviso por Telegram se ve más rápido en el celular.
- **Arquitectura MVC con framework (Laravel):** descartado por la curva de aprendizaje. Se usa una estructura simple de carpetas (`config`, `includes`, `public`, `database`) que separa lógica, vistas y datos.

## Manejo de errores de la API externa

Si Telegram no responde, la operación del usuario (retiro o devolución) **no se bloquea**: se guarda igual, la notificación se registra como "fallida" con su motivo y se reintenta. La llamada usa un **timeout** corto para que la pantalla no quede colgada.

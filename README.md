# 📦 AlquilaFacil — Sistema de Gestión de Alquiler de Equipos

**Estudiante:** Santiago Jose Morales  
**Repositorio:** [github.com/Sarfs-crypto/alquilafacil](https://github.com/Sarfs-crypto/alquilafacil)  
**Aplicación en producción:** [https://alquilafacil.up.railway.app](https://alquilafacil.up.railway.app)

---

## 🧭 Índice

- [Descripción del proyecto](#-descripción-del-proyecto)
- [Actores del sistema](#-actores-del-sistema)
- [Tecnologías utilizadas](#-tecnologías-utilizadas)
- [Estructura de la base de datos](#-estructura-de-la-base-de-datos)
- [Funcionalidades principales](#-funcionalidades-principales)
- [Instalación y ejecución local](#-instalación-y-ejecución-local)
- [Credenciales de prueba](#-credenciales-de-prueba)
- [Tests automatizados](#-tests-automatizados)
- [Despliegue en producción](#-despliegue-en-producción)
- [Capturas de pantalla](#-capturas-de-pantalla)
- [Mejoras futuras](#-mejoras-futuras)

---

## 📖 Descripción del proyecto

**AlquilaFacil** es un sistema web desarrollado con Laravel que permite a empresas gestionar el alquiler de equipos y herramientas (computadores, cámaras, equipos de sonido, herramientas eléctricas, etc.).

El sistema cuenta con dos perfiles de usuario bien diferenciados:

- **Clientes:** pueden explorar el catálogo de equipos disponibles, consultar precios y estado, crear solicitudes de alquiler por fechas específicas, y consultar el historial de sus alquileres.
- **Administradores:** tienen control total sobre el inventario (CRUD de equipos y categorías), gestionan las solicitudes de alquiler (aprobación, devolución) y pueden cambiar el estado de los equipos a mantenimiento cuando sea necesario.

El proyecto fue desarrollado como parte de una actividad práctica para demostrar el dominio del framework Laravel, incluyendo despliegue en producción con dominio propio.

---

## 👥 Actores del sistema

| Actor       | Rol                                                                 |
|-------------|----------------------------------------------------------------------|
| **Cliente** | Busca equipos, crea solicitudes de alquiler, cancela solicitudes pendientes y consulta su historial. |
| **Admin**   | Gestiona el catálogo de equipos y categorías, aprueba o rechaza solicitudes, registra devoluciones y cambia estados de equipos. |

---

## 🛠️ Tecnologías utilizadas

- **Backend:** Laravel 11 (PHP 8.2+)
- **Base de datos:** MySQL / MariaDB
- **Frontend:** Blade templates + Bootstrap 5
- **Autenticación:** Sistema nativo de Laravel con roles (admin/client)
- **Despliegue:** Railway.app
- **Control de versiones:** Git + GitHub
- **Dominio:** Namecheap (personalizado)

---

## 🗄️ Estructura de la base de datos

El sistema está compuesto por **5 tablas principales**, con sus respectivas relaciones:

| Tabla          | Descripción                                                                 |
|----------------|-----------------------------------------------------------------------------|
| `users`        | Usuarios del sistema (clientes y administradores).                          |
| `categories`   | Categorías de equipos (ej. Computadores, Cámaras, Sonido, Herramientas).   |
| `equipment`    | Equipos disponibles para alquiler. Contiene estado, precio y categoría.    |
| `rentals`      | Solicitudes de alquiler realizadas por los clientes.                       |
| `rental_items` | Detalle de cada equipo incluido en una solicitud de alquiler.              |

### 🔗 Relaciones entre tablas
users (1) ────── (N) rentals
│
categories (1) ── (N) equipment
│
rentals (1) ───── (N) rental_items
equipment (1) ─── (N) rental_items


**Explicación de las relaciones:**

- Un **usuario** (cliente) puede tener **muchos alquileres**.
- Una **categoría** puede tener **muchos equipos**.
- Un **alquiler** puede tener **muchos items** (equipos alquilados).
- Un **equipo** puede aparecer en **muchos items** de alquiler (a lo largo del tiempo).

### 📋 Campos destacados por tabla

**Tabla `users`** (ampliada)
- `id`, `name`, `email`, `password`
- `role`: `admin` o `client`
- `documento`, `phone`

**Tabla `equipment`**
- `id`, `name`, `code` (único), `description`
- `daily_price` (precio por día)
- `status`: `available`, `rented`, `maintenance`
- `category_id` (clave foránea)

**Tabla `rentals`**
- `id`, `client_id` (clave foránea)
- `status`: `pending`, `active`, `returned`, `cancelled`
- `start_date`, `end_date`
- `total_price` (suma de todos los subtotales)

**Tabla `rental_items`**
- `id`, `rental_id`, `equipment_id`
- `daily_price` (precio del equipo en el momento del alquiler)
- `days` (número de días)
- `subtotal` (daily_price × days)

---

## ⚙️ Funcionalidades principales

### 🔹 Zona Cliente (autenticado)
- **Ver catálogo de equipos** con filtro por categoría.
- **Ver detalle de un equipo** con precio diario, estado e imagen.
- **Crear una solicitud de alquiler** seleccionando uno o varios equipos y un rango de fechas.
- **Ver mis alquileres** (activos e historial).
- **Cancelar un alquiler** que aún esté en estado `pending`.

### 🔹 Zona Administrador
- **CRUD completo de equipos** (crear, editar, eliminar).
- **CRUD completo de categorías**.
- **Ver todas las solicitudes** de alquiler con su estado actual.
- **Aprobar una solicitud** → los equipos pasan a estado `rented`.
- **Registrar devolución** → los equipos vuelven a estado `available`.
- **Cambiar un equipo a estado `maintenance`** cuando sea necesario.

### 🔹 Reto extra (Dashboard)
- Panel administrativo con tarjetas resumen que muestran:
  - Total de equipos.
  - Equipos disponibles (🟢 verde).
  - Equipos en alquiler (🟡 amarillo).
  - Equipos en mantenimiento (🔴 rojo).

---

## 💻 Instalación y ejecución local

Sigue estos pasos para tener el proyecto funcionando en tu máquina local:

### 1️⃣ Clonar el repositorio

git clone https://github.com/Sarfs-crypto/alquilafacil.git
cd alquilafacil

2️⃣ Instalar dependencias de PHP

composer install
3️⃣ Instalar dependencias de JavaScript (opcional, para assets)

npm install
npm run build
4️⃣ Configurar el archivo de entorno

cp .env.example .env
Luego abre el archivo .env y configura los datos de tu base de datos:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_bd
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
5️⃣ Generar la clave de la aplicación

php artisan key:generate
6️⃣ Ejecutar las migraciones y los seeders (datos de prueba)

php artisan migrate --seed
7️⃣ Iniciar el servidor de desarrollo

php artisan serve
La aplicación estará disponible en: http://localhost:8000

🔑 Credenciales de prueba
Rol	Email	Contraseña
Admin	admin@alquilafacil.com	password
Cliente	cliente@test.com	password
⚠️ Nota: Estas credenciales se crean automáticamente al ejecutar php artisan db:seed.

🧪 Tests automatizados
El proyecto incluye mínimo 4 tests funcionales para garantizar el correcto funcionamiento de las características clave.

Los tests se encuentran en la carpeta tests/Feature/:

EquipmentTest.php: pruebas sobre la gestión de equipos.

RentalTest.php: pruebas sobre el flujo de alquileres (creación, cancelación, aprobación, devolución).

Ejecutar los tests

php artisan test
Ejemplo de salida esperada:

OK (4 tests, 6 assertions)
☁️ Despliegue en producción
La aplicación está desplegada en Railway.app y utiliza un dominio personalizado adquirido en Namecheap.

Pasos resumidos del despliegue:
Crear cuenta en Railway y conectar con GitHub.

Seleccionar el repositorio alquilafacil para desplegar.

Agregar base de datos MySQL desde el panel de Railway.

Configurar las variables de entorno en Railway:

APP_ENV=production

APP_DEBUG=false

APP_KEY=... (generada localmente con php artisan key:generate --show)

Datos de conexión a la base de datos (host, database, username, password).

Ejecutar migraciones y seeders en el entorno de producción:

php artisan migrate --force
php artisan db:seed --force
Configurar el dominio personalizado en Railway y apuntar los registros DNS (CNAME + TXT) desde Namecheap.

🌐 URL de producción
https://alquilafacil.up.railway.app

📸 Capturas de pantalla

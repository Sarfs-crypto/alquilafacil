# AlquilaFacil

**Estudiante:Santiago Jose Morales  
**URL del Proyecto en Railway:** https://alquilafacil.up.railway.app  
**Usuario Admin:** admin@example.com  
**Contraseña:** password123  

## Descripción
Sistema de gestión de alquileres vacacionales donde los usuarios pueden publicar propiedades, los huéspedes pueden reservar y los administradores gestionan el estado de todo el sistema.

## Tablas implementadas y sus relaciones
- **Users**: Almacena propietarios, huéspedes y admins (campo `is_admin`).
- **Properties**: Pertenece a un `User` (dueño). Tiene muchas `Rentals`.
- **Rentals**: Pertenece a un `User` (inquilino) y a una `Property`. Tiene un `Payment`.
- **Payments**: Pertenece a un `Rental`.

## Instrucciones para correr localmente
1. Clonar el repositorio: `git clone https://github.com/tu-usuario/alquilafacil.git`
2. Ejecutar `composer install`
3. Copiar `.env.example` a `.env` y configurar la base de datos (usa SQLite para desarrollo).
4. Generar clave: `php artisan key:generate`
5. Ejecutar migraciones: `php artisan migrate`
6. (Opcional) Ejecutar seeders: `php artisan db:seed`
7. Iniciar servidor: `php artisan serve`

## Capturas de pantalla
![Home](screenshots/home.png)
![Admin](screenshots/admin.png)promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

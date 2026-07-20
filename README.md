# AlquilaFacil - Alquiler de Equipos

**Estudiante:** Santiago Jose Morales

**URL Railway:** https://alquilafacil.up.railway.app
**Admin:** admin@example.com / password123

## Descripción breve
Sistema de gestión de alquiler de equipos (computadores, cámaras, herramientas, etc.). Usuarios cliente solicitan alquileres y admin aprueba/devuelve.

## Tablas implementadas y relaciones
- **Users** (role: admin/client)
- **Categories** 
- **Equipment** belongsTo Category, status (available/rented/maintenance)
- **Rentals**
- **RentalItems** 

## Instrucciones para correr localmente
1. git clone https://github.com/Sarfs-crypto/alquilafacil.git
2. composer install && npm install && npm run build
3. cp .env.example .env && php artisan key:generate
4. php artisan migrate --seed
5. php artisan serve

## Capturas de pantalla
![Catálogo](screenshots/catalogo.png)
![Admin](screenshots/admin.png)

## Tests
Mínimo 4 tests en tests/Feature/
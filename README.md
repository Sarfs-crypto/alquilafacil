# AlquilaFacil

**Estudiante:** Santiago Jose Morales

**URL Railway:** https://alquilafacil.up.railway.app
**Admin:** admin@alquilafacil.com / password123

## Descripción breve
Sistema de alquiler vacacional completo.

## Tablas y relaciones
- Users (role)
- Properties → User
- Rentals → Property + User
- Payments → Rental

## Instrucciones locales
1. git clone ...
2. composer install && npm ci
3. cp .env.example .env && php artisan key:generate
4. php artisan migrate --seed
5. php artisan serve

## Capturas de pantalla
![Dashboard](screenshots/dashboard.png)
![Property](screenshots/property.png)

## Tests
4+ tests implementados.
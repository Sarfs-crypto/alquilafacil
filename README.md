# AlquilaFacil

**Estudiante:** Santiago Jose Morales

**URL Railway:** https://alquilafacil.up.railway.app (actualizar después de deploy)
**Admin:** admin@alquilafacil.com / password123

## Descripción breve
Sistema completo de alquiler vacacional con publicación de propiedades, reservas y panel admin.

## Tablas y relaciones
- **Users** (role: admin/owner/guest) 
- **Properties** belongsTo User, hasMany Rentals
- **Rentals** belongsTo Property + User
- **Payments** belongsTo Rental

## Instrucciones locales
1. git clone https://github.com/Sarfs-crypto/alquilafacil.git
2. composer install && npm install && npm run build
3. cp .env.example .env
4. php artisan key:generate
5. php artisan migrate --seed
6. php artisan serve

## Capturas
(Agrega imágenes)

## Testing
Mínimo 4 tests implementados en tests/Feature/
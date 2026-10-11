# ITI-621

Proyecto 1 - Tecnologias y Sistemas Web III

Base del proyecto en Laravel 13 sobre PHP 8.3.

## Requisitos

- PHP 8.3 o superior, con las extensiones `openssl`, `mbstring`, `pdo_sqlite`, `curl`, `zip` y `fileinfo`
- Composer 2
- SQLite (viene con PHP, no hace falta instalar servidor de base de datos)

## Puesta en marcha

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Antes de correr las migraciones hay que completar las variables del administrador
en el `.env`:

```env
ADMIN_NAME="Administrador"
ADMIN_LAST_NAME="Sistema"
ADMIN_EMAIL="correo@ejemplo.com"
ADMIN_PASSWORD="una-contrasena-fuerte"
ADMIN_DOCUMENT_NUMBER="118820456"
```

Con eso listo:

```bash
php artisan migrate:fresh --seed
```

El seed crea el usuario administrador raiz con esos datos. Si faltan
`ADMIN_EMAIL` o `ADMIN_PASSWORD`, el seed avisa y no crea nada, para no dejar
credenciales por defecto en la base de datos.

## Pruebas

```bash
php artisan test
```

## Estructura del modulo de usuario

La tabla `users` quedo adaptada en la migracion que Laravel ya trae,
`0001_01_01_000000_create_users_table`. No se agrego una migracion nueva.

| Campo | Tipo | Nota |
|---|---|---|
| `id` | id | |
| `name` | string | |
| `last_name` | string | |
| `document_number` | string | indice unico |
| `email` | string | indice unico |
| `phone` | string | opcional |
| `avatar_path` | string | opcional |
| `status` | enum | `activo`, `inactivo`, `suspendido` |
| `email_verified_at` | timestamp | opcional |
| `password` | string | cifrada con el cast `hashed` |
| `last_login_at` | timestamp | opcional |
| `remember_token` | string | |
| `created_at` / `updated_at` | timestamps | |
| `deleted_at` | timestamp | borrado logico |

Los indices unicos de `email` y `document_number` los crea la base de datos, no
solo el modelo.

## Archivos del modulo

| Archivo | Que hace |
|---|---|
| `app/Enums/UserStatus.php` | Enum nativo con los tres estados |
| `app/Models/User.php` | Modelo con `SoftDeletes`, `$fillable`, `$hidden` y casts |
| `database/migrations/0001_01_01_000000_create_users_table.php` | Tabla `users` |
| `database/factories/UserFactory.php` | Factory con estados `activo`, `inactivo` y `suspendido` |
| `database/seeders/AdminUserSeeder.php` | Crea el administrador raiz desde el `.env` |
| `config/admin.php` | Lee las variables `ADMIN_*` |
| `tests/Feature/Models/UserTest.php` | 9 pruebas del modelo |

## Seguridad

El repositorio es publico. El `.env` esta en `.gitignore` y nunca debe subirse.
Lo que si se versiona es `.env.example`, con las credenciales de ejemplo vacias.
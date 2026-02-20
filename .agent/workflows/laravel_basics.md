---
description: Create a new database migration
---
1. Create a migration file: `php artisan make:migration <migration_name>` (e.g., `php artisan make:migration create_users_table`)
2. Edit the migration file in `database/migrations/` to define the table schema.
3. Run the migration: `php artisan migrate`

---
description: Create a new Laravel controller
---
1. Run `php artisan make:controller <ControllerName>`
2. Define methods (index, store, update, etc.) in the new controller.

---
description: Clear application cache
---
1. Run `php artisan optimize:clear`

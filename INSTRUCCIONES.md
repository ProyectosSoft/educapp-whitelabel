# Guía de Instalación y Ejecución - EducApp

Al parecer es la primera vez que ejecutas este proyecto o te faltan las dependencias. Sigue estos pasos para configurarlo:

## 1. Configuración Inicial (Solo una vez)

Ejecuta los siguientes comandos en tu terminal en la raíz del proyecto:

```bash
# 1. Copiar el archivo de entorno
cp .env.example .env

# 2. Instalar dependencias de PHP (Backend)
composer install

# 3. Instalar dependencias de Node.js (Frontend)
npm install

# 4. Generar la clave de aplicación
php artisan key:generate

# 5. Configurar base de datos (Asegúrate de tener una BD creada o usar SQLite)
# Abre el archivo .env y configura DB_DATABASE, DB_USERNAME, etc.
# Luego ejecuta las migraciones:
php artisan migrate --seed
```

## 2. Ejecutar la Aplicación

Para trabajar en el proyecto necesitas dos terminales abiertas:

**Terminal 1 (Servidor Laravel):**
```bash
php artisan serve
```

**Terminal 2 (Compilador de Frontend Vite):**
```bash
npm run dev
```

---
**Nota:** El comando `composer run dev` falló porque no es un script estándar en este proyecto. Usa los comandos de arriba.

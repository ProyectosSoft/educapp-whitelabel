# Manual: Pasos para subir el proyecto EducApp-WhiteLabel a GitHub

Este documento detalla el paso a paso de lo que se hizo para inicializar y subir el proyecto a un repositorio de GitHub, incluyendo la resolución de un problema de seguridad por credenciales expuestas en archivos temporales.

### Paso 1: Inicializar Git en el proyecto local
Lo primero que hicimos fue decirle a la carpeta del proyecto que a partir de ahora sería controlada por Git.
```bash
git init
```
*Esto creó una carpeta oculta `.git` donde se guarda todo el historial y las configuraciones del repositorio.*

### Paso 2: Preparar los archivos (Stage)
Luego, le dijimos a Git que agregara todos los archivos y carpetas del proyecto para prepararlos para el primer guardado (commit).
```bash
git add .
```

### Paso 3: Crear el primer Commit (Guardado)
Tras preparar los archivos, creamos el primer commit, que es como tomarle una "foto" al estado actual del código, y le pusimos un mensaje descriptivo.
```bash
git commit -m "Primer commit: Inicialización del proyecto EducApp-WhiteLabel"
```

### Paso 4: Cambiar el nombre de la rama principal a "main"
Por convención actual, las ramas principales se llaman `main` (antes era `master`). Nos aseguramos de que la rama se llamara así.
```bash
git branch -M main
```

### Paso 5: Enlazar con el Repositorio de GitHub
Aquí conectamos el proyecto local con el repositorio vacío creado en GitHub, utilizando la URL proporcionada. Lo llamamos `origin`.
```bash
git remote add origin https://github.com/ProyectosSoft/educapp-whitelabel.git
```

### Paso 6: Primer intento de subida (que falló por seguridad)
Intentamos subir los archivos:
```bash
git push -u origin main
```
*🚨 **¿Qué pasó aquí?** GitHub rechazó la subida (push) porque sus sistemas de seguridad detectaron un archivo llamado `public/Migraciones.txt` que contenía información muy sensible (como contraseñas de bases de datos y claves de Amazon AWS).* 

### Paso 7: Ignorar el archivo con credenciales
Para solucionar el rechazo de GitHub, añadimos el archivo `public/Migraciones.txt` al archivo `.gitignore`. El `.gitignore` le dice a Git: *"Nunca subas al repositorio los archivos que estén en esta lista"*.
Añadimos esta línea al final del `.gitignore`:
```text
/public/Migraciones.txt
```

### Paso 8: Eliminar el archivo del rastreo de Git y corregir el commit
Le dijimos a Git que olvidara el archivo problemático (sin borrarlo de la computadora), agregamos el cambio del `.gitignore` y reescribimos el primer commit para que estuviera limpio y sin contraseñas.
```bash
git rm --cached public/Migraciones.txt
git add .gitignore
git commit --amend --no-edit
```

### Paso 9: Subir el código exitosamente
Finalmente, volvimos a intentar la subida a GitHub, ¡y esta vez funcionó perfecto!
```bash
git push -u origin main
```

¡Y eso fue todo! El código base del proyecto ahora está seguro y versionado en el repositorio en la nube.

# Análisis de Rediseño: Módulo Autor (Instructor)

## Objetivo
Transformar el área de "Autor/Instructor" (`/author`) conservando la identidad corporativa de **Academia Effi** (Azul `#335A92`, Amarillo `#ECBD2D`), pero diferenciándola visualmente del Panel Administrativo (`/admin`).

## Concepto: "Effi Creator Studio"
Mientras que el **Admin Panel** se centra en la *Gestión y Control* (Tablas, Listados, Densidad de datos), el **Author Panel** debe centrarse en la *Creación y Producto*.

### Diferencias Clave

| Característica | Admin Panel (ERP Style) | Author Panel (Studio Style) |
| :--- | :--- | :--- |
| **Enfoque** | Gestión de Datos, Usuarios, Configuración | Creación de Cursos, Monitoreo de Alumnos |
| **Visual Principal** | Tablas Zebra, Listados densos | Tarjetas Visuales (Grids), Portadas de Cursos |
| **Color Header** | Azul Sólido (`#335A92`) | Blanco Limpio con Acentos Azules |
| **Navegación** | Sidebar Fijo Completo | Sidebar Flotante o Minimalista |
| **Fondo** | Blanco / Gris muy claro tabla | Gris Pizarra Suave (`bg-slate-50`) para resaltar tarjetas |

## Propuesta de Diseño

### 1. Layout Principal (`layouts/instructor.blade.php`)
*   **Fondo General:** Cambiar a un tono base suave (`bg-slate-50`) que diferencie el entorno de "trabajo creativo".
*   **Contenedor:** Eliminar el borde punteado (`border-dashed`). Usar un contenedor fluido con márgenes amplios (`max-w-7xl mx-auto`).
*   **Header de Sección:** En lugar de un bloque de color sólido, usar títulos grandes y limpios sobre el fondo gris, con botones de acción flotantes (Shadow buttons).

### 2. Vista de Cursos (`cursos/index.blade.php`)
*   **Transformación:** De **Tabla** a **Grid de Tarjetas**.
*   **Tarjeta de Curso:**
    *   **Portada:** Imagen grande (aspect-video) para fácil identificación.
    *   **Estado:** Badges flotantes sobre la imagen (Borrador/Publicado).
    *   **Métricas:** Iconos rápidos en el pie de la tarjeta (Estudiantes, Valoración).
    *   **Acciones:** Botón "Gestionar/Editar" prominente en amarillo (`#ECBD2D`) o azul, indicando "ir a trabajar".

### 3. Navegación y Sidebar
*   **Logo:** Actualizar a `LOGO_ACADEMIA_Effi_ERP.png`.
*   **Items:** Texto gris oscuro, cambiando a Azul Corporativo + Fondo Azul Tenue al estar activo.
*   **Limpieza:** Eliminar referencias a "Flowbite" y demos no utilizados.

## Plan de Ejecución
1.  **Refactorizar Layout:** Limpiar `instructor.blade.php` y sus partials.
2.  **Rediseñar Index Mis Cursos:** Implementar el Grid de Tarjetas.
3.  **Ajustar Creación/Edición:** Aplicar el estilo de formulario limpio ("Lienzo Blanco") para las vistas de `create` y `edit`.

---
*Este diseño busca inspirar creatividad y orden, facilitando al instructor la ubicación rápida de sus cursos mediante referencias visuales.*

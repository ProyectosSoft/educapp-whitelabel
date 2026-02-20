# Análisis Integral del Proyecto EducApp-WhiteLabel

**Fecha de Análisis:** 17 de Febrero de 2026
**Versión de Laravel:** 10.x
**Estado del Proyecto:** En desarrollo activo (Fase de Implementación White Label y Refactorización de Exámenes)

## 1. Visión General del Proyecto
La aplicación es una plataforma **LMS (Learning Management System)** con capacidades de comercio electrónico y una reciente expansión hacia un modelo **White Label (Marca Blanca)** y **SaaS (Software as a Service)** para empresas.

El proyecto ha evolucionado de un LMS monolítico a una arquitectura multi-inquilino (multi-tenant) incipiente, donde se busca separar datos y gestión por "Empresas".

---

## 2. Stack Tecnológico

*   **Backend:** Laravel Framework `^10.10` / PHP `^8.1`
*   **Frontend:**
    *   **Blade Templates**: Motor principal.
    *   **Livewire**: Versión `^2.11` instalada (según `composer.json`), aunque hay evidencia de intención de uso de v3 (`Analisis.md` anterior mencionaba v3, pero el código actual refleja dependencias de v2).
    *   **Alpine.js** `^3.0.6`: Manejo de interactividad ligera y gráficas.
    *   **Tailwind CSS** `^3.1.0`: Framework de estilos.
*   **Base de Datos:** MySQL/MariaDB.
*   **Gestión de Dependencias:** Composer y NPM (Vite `^4.0`).
*   **Librerías Clave:**
    *   `laravel/jetstream`: Autenticación.
    *   `spatie/laravel-permission`: Roles y Permisos.
    *   `maatwebsite/excel`: Reportes y Carga Masiva.
    *   `barryvdh/laravel-dompdf`: Certificados.
    *   `mercadopago/dx-php`: Pasarela de pagos.

---

## 3. Arquitectura y Estructura de Módulos

El sistema se divide en varios módulos funcionales que varían en madurez y calidad de código.

### A. Módulo LMS (Core)
*   **Modelos:** `Curso`, `Leccion`, `Seccion`, `Categoria`.
*   **Estado:** Funcional pero con deuda técnica en "Naming Conventions". Se mezclan nombres en español (`Curso`, `Leccioncurso`) con lógica en inglés.
*   **Livewire:** Componentes como `CourseStatus` y `Student.MyEvaluations`.

### B. Módulo de Exámenes Avanzados (Nuevo - Ene/Feb 2026)
Este módulo ha recibido la mayor actividad reciente, con una rearquitectura completa.
*   **Modelos Nuevos:** `Exam`, `ExamQuestion`, `ExamAnswerOption`, `ExamUserAttempt`, `ExamDifficultyLevel`.
*   **Mejoras Recientes:**
    *   **Banco de Preguntas:** Implementación de tablas dedicadas (`exam_questions`) separadas de las evaluaciones, permitiendo reutilización.
    *   **Soft Deletes:** Implementado en preguntas y respuestas (`ExamAnswerOption`) para evitar pérdida de datos histórica.
    *   **Certificados:** Generación PDF a través de `CertificationController`.
*   **Deuda Técnica:** Coexistencia de tablas antiguas (`evaluaciones`, `preguntas_evaluaciones`) con las nuevas (`exams`, `exam_questions`), lo que sugiere una migración incompleta.

### C. Módulo White Label / Empresas (En Progreso)
Se está transformando la app para soportar múltiples empresas.
*   **Avances (Base de Datos):**
    *   Tabla `empresas` creada (Ene 2026).
    *   Relaciones agregadas en Feb 2026: `users.empresa_id`, `categorias.empresa_id`, `subcategorias.empresa_id`.
    *   Gestión de invitaciones (`EmpresaInvitation`).
*   **Faltantes Críticos:**
    *   **Middleware de Identificación:** No se encontró un Middleware activo en `Kernel.php` que maneje la separación de lógica por subdominio o prefijo de ruta (ej: `/empresa/{slug}`).
    *   **Personalización UI:** La tabla `empresas` carece de campos para branding (logo, colores primarios/secundarios, favicon), por lo que la interfaz visual no puede adaptarse dinámicamente aún.

### D. E-Commerce y Financiero
*   **Modelos:** `Order`, `Transaction`, `SaldoFavor`, `Cupon`.
*   **Estado:** Estable. Implementa carrito de compras y control de saldo a favor.

---

## 4. Análisis de Calidad de Código (Codebase Audit)

### Puntos Fuertes
1.  **Uso de Estándares Modernos en Nuevos Módulos:** El módulo de Exámenes (`Exam...`) sigue mejores convenciones de nombrado en inglés y estructura relacional que el módulo LMS legado.
2.  **Seguridad en Borrado:** Implementación correcta de `SoftDeletes` en datos críticos de exámenes.
3.  **Interactividad:** Buen uso de Alpine.js para gráficas dinámicas (Dashboard de Estadísticas Globales).

### Puntos Débiles (Deuda Técnica)
1.  **Fat Controllers:** Archivos como `CursoController` y `ReportsController` acumulan demasiada lógica de negocio.
    *   *Evidencia:* No existe el directorio `app/Services`, por lo que la recomendación de usar el patrón Service/Repository no se ha aplicado.
2.  **Naming Inconsistente (Spanglish):**
    *   Modelos en Español: `Empresa`, `Evaluaciones`, `Preguntas_evaluaciones`.
    *   Modelos en Inglés: `Exam`, `Question`, `BusinessController`.
    *   Esto confunde el desarrollo y el mantenimiento.
3.  **Duplicidad de Modelos:** Existen modelos solapados como `Evaluation` vs `Exam` y `Question` vs `ExamQuestion`. Se debe planear la deprecación de los antiguos.
4.  **Middleware White Label Faltante:** A pesar de tener los datos relacionales (`empresa_id`), la aplicación no aplica automáticamente el filtro de empresa globalmente (Scope Global o Middleware).

---

## 5. Hoja de Ruta Sugerida (Action Plan)

### Corto Plazo (Inmediato)
1.  **Implementar Middleware `TenantMiddleware`:**
    *   Detectar la empresa desde la URL (subdominio o segmento).
    *   Configurar el `ServiceContainer` de Laravel para inyectar la empresa actual globalmente.
    *   Aplicar `GlobalScopes` a los modelos (`User`, `Curso`, `Categoria`) para filtrar automáticamente por `empresa_id`.
2.  **Completar Migración de Datos White Label:**
    *   Agregar campos de branding a la tabla `empresas` (`logo_path`, `primary_color`, `secondary_color`).
    *   Crear helper o directiva Blade para CSS dinámico basado en la empresa actual.
3.  **Unificar Exámenes:**
    *   Migrar datos de `evaluaciones` a `exams` y eliminar las tablas antiguas para evitar confusión.

### Mediano Plazo
1.  **Refactorización a Servicios:**
    *   Crear `App\Services` y mover lógica compleja (ej: `ProcessOrder`, `GenerateCertificate`).
2.  **Estandarización de Idioma:**
    *   Acordar usar Inglés para todo nuevo código (Clases, Variables, Métodos).

---

*Documento generado automáticamente por Antigravity tras auditoría del sistema de archivos.*

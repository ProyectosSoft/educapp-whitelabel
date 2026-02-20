# EducApp 🎓

EducApp is a comprehensive E-Learning Platform (LMS) built with Laravel. It connects students and instructors through a robust course marketplace, featuring video lessons, progress tracking, and secure payments.

## 🚀 Key Features

### For Students
- **Course Marketplace**: Browse courses with advanced filtering (Categories, Levels, Prices).
- **Learning Experience**: Track progress (`CourseStatus`), view video lessons (`CourseStatusL`), and manage reviews.
- **Evaluations**: Take quizzes and final exams to test knowledge.
- **My Evaluations**: Dedicated hub to review detailed attempt history and scores.
- **Certificates**: Earn PDF certificates upon course completion.
- **Wishlist**: Save courses for later.
- **Shopping Cart**: Secure checkout process with coupon support.

### For Instructors
- **Instructor Portal**: Dedicated premium interface for managing courses and finances.
- **Course Management**: Create and manage curriculum, pricing (with **Quick Tariff Creation**), and content with a modern UI.
- **Evaluation Builder**: Create multiple-choice quizzes and final exams.
- **Financial Dashboard**: Track sales, balances, and request withdraws.
- **Student Interaction**: Respond to questions, reviews, and detailed attempt history.

### Para Empresas (Gestión Corporativa)
- **Estructura Organizacional**: Modelo jerárquico de **Empresas** y **Departamentos** para agrupar usuarios.
- **Flujos de Registro Personalizados**:
    - **Enlaces de Invitación Seguros**: Los administradores pueden generar links únicos con fecha de caducidad y límite de usos para invitar usuarios a la plataforma.
    - **Asignación Automática**: Los usuarios invitados quedan vinculados automáticamente a su **Empresa** y **Departamento** correspondiente, con el rol (Instructor/Estudiante) pre-asignado.
    - **Trazabilidad de Uso**: Registro detallado (Logs) de cada uso del enlace, incluyendo usuario creado, dirección IP y fecha/hora exacta.
    - **Gestión de Errores Amigable**: Pantallas de error personalizadas y visualmente consistentes para notificar cuando una invitación ha expirado o alcanzado su límite de uso.
- **Certificación Jerárquica**: Los certificados generados incluyen dinámicamente las firmas de autoridad (Jefe Inmediato o CEO) correspondientes a la estructura de la empresa del usuario.

### Gestión de Roles y Seguridad (RBAC)
- **Control de Acceso Granular**: Sistema robusto de permisos basado en `Spatie Permission`.
- **Interfaz Premium**: Panel de administración para gestión de roles rediseñado con Tailwind CSS.
- **Permisos Modulares**: Asignación de permisos agrupados lógicamente por módulos (Cursos, Usuarios, Exámenes, Dashboards) para facilitar la administración de perfiles complejos como "Instructor Auditor" o "Administrador de Contenidos".

### Technical Highlights
- **Backend**: Laravel 10, Spatie Permissions (Roles/Permissions).
- **Frontend**: Blade, Livewire 2, Alpine.js, Tailwind CSS 3.
- **Payments**: MercadoPago integration.
- **Reporting**: Comprehensive Excel exports (`maatwebsite/excel`) and PDF reports (`dompdf`) for Exam Statistics, featuring multi-sheet breakups (General, Questions, Students).
- **Audit System**: Comprehensive user activity logging with localized time tracking, plus **Course Session Tracking** to monitor student engagement (duration, progress, and IP address per session). Features granular **Section Progress** views for deeper insights.
- **Admin**: AdminLTE based dashboard with Premium UI Customizations for **Users**, Categories, Subcategories, and Course Review.

## 🛠 Installation & Setup

Follow these steps to set up the project locally.

### Prerequisites
- PHP ^8.1
- Composer
- Node.js & NPM
- MySQL or SQLite

### 1. Initial Configuration
Run these commands in the project root:

```bash
# 1. Environment Setup
cp .env.example .env

# 2. Backend Dependencies
composer install

# 3. Frontend Dependencies
npm install

# 4. Generate App Key
php artisan key:generate

# 5. Database Setup
# Configure DB_DATABASE, DB_USERNAME, etc. in .env first
php artisan migrate --seed
```

### 2. Running the Application
You need two terminal windows running simultaneously:

**Terminal 1 (Laravel Server):**
```bash
php artisan serve
```

**Terminal 2 (Vite - Assets):**
```bash
npm run dev
```

## 📚 Documentation
- [Analysis & Architecture](analisis.md)
- [Detailed Instructions](INSTRUCCIONES.md)

### 🧩 Módulo de Exámenes (Exams Module)
EducApp ahora cuenta con un nuevo y robusto motor de evaluaciones separado del sistema anterior. Este módulo permite configurar, gestionar y presentar exámenes complejos con las siguientes características:

1.  **Arquitectura de Datos**:
    -   **Evaluaciones (`ExamEvaluation`)**: La entidad principal que representa un examen dentro de un curso (ej. "Examen Final" o "Parcial"). Se configuran opciones como tiempo límite, puntaje de aprobación y restricciones.
    -   **Categorías (`ExamCategory`)**: Organización lógica de preguntas (ej. "Matemáticas", "Historia"). Permiten reutilizar pools de preguntas.
    -   **Preguntas y Respuestas (`ExamQuestion`, `ExamAnswerOption`)**: Soporte para preguntas de selección múltiple con opciones correctas e incorrectas (distractores).
    -   **Intentos (`ExamUserAttempt`)**: Registro detallado de cada vez que un estudiante toma un examen, incluyendo respuestas elegidas (`ExamAttemptAnswer`), puntaje obtenido y estado.

2.  **Constructor de Evaluaciones (`EvaluationBuilder`)**:
    -   Interfaz gráfica para instructores que permite "ensamblar" un examen seleccionando categorías del banco de preguntas.
    -   **Ponderación Personalizable**: Se puede asignar un peso porcentual a cada categoría (ej. 40% Matemáticas, 60% Historia).
    -   **Aleatoriedad Controlada**: Configuración de cuántas preguntas tomar **aleatoriamente** de cada categoría para cada intento.

3.  **Motor de Presentación (`ExamTaker`)**:
    -   Presenta el examen al estudiante en tiempo real.
    -   Selecciona preguntas al azar según la configuración del constructor.
    -   Mezcla las opciones de respuesta para evitar patrones predecibles.

4.  **Bancos de Preguntas Reutilizables**:
    -   Los instructores pueden crear y gestionar su propia biblioteca de preguntas categorizadas, independientes de un examen específico, para reutilizarlas en múltiples evaluaciones.
    -   **Importación Masiva**: Herramienta integrada para cargar cientos de preguntas desde archivos Excel, con detección automática de categorías y niveles de dificultad, y validación de errores en tiempo real.

5.  **Analítica Avanzada y Estadísticas**:
    -   Dashboard completo para instructores con **KPIs de rendimiento** (Promedios, Tiempos, Tasas de Aprobación).
    -   **Gráficos Interactivos** (Chart.js) para visualizar histogramas de notas y proporciones de éxito.
    -   **Exportación de Datos**: Generación de reportes descargables en formatos **Excel** (multi-hoja con métricas generales, análisis de preguntas y ranking de estudiantes) y **PDF**.
    -   **Insights Pedagógicos**: Identificación automática de las preguntas más difíciles (distractores) y ranking de mejores estudiantes con indicadores de posición.
    -   **Análisis Completo**: Algoritmos que calculan tasas de acierto basadas exclusivamente en intentos finalizados para garantizar la precisión de los datos.
    -   **Dashboard Global**: Vista agregada que consolida el rendimiento de todos los exámenes del instructor en una sola pantalla, permitiendo comparar métricas clave y filtrar por rangos de fecha.

6.  **Sistema de Calificación Ponderada y Revisión**:
    -   **Cálculo de Notas**: La calificación final no es una simple suma de puntos. El sistema utiliza una media ponderada donde cada categoría contribuye con un porcentaje específico (`weight_percent`) al total del examen.
        - Fórmula: `Nota Final = Σ ((Puntos Obtenidos Categoría / Puntos Máximos Categoría) * Peso Categoría)`
    -   **Revisión Manual**: Soporte para preguntas abiertas que requieren calificación por parte del instructor.
    -   **Monitoreo Detallado**: Desglose visual en el reporte de intentos que muestra el rendimiento por categoría y su aporte exacto a la nota final.

### 🧠 Lógica del Sistema de Evaluaciones Pasiva y Activa (Proctoring)
El sistema implementa estrictos algoritmos de seguridad ("Modo Seguro") para garantizar la integridad académica:

1. **Protección de Integridad (Proctoring Activo)**:
    - **Monitoreo de Eventos**: Uso de Alpine.js para detectar en tiempo real:
        - Cambio de pestaña (`visibilitychange`).
        - Pérdida de foco de la ventana (`blur`).
        - Intentos de abrir herramientas de desarrollador (`F12`, Click Derecho).
    - **Sanción Automática**: Cualquier violación de seguridad provoca la **terminación inmediata** del examen con una calificación de **0.0**.
    - **Auditoría Forense**: El sistema registra la causa exacta del cierre (ej. "Intento de Fraude: Cambio de Pestaña") visible para el instructor.

2. **Aleatoriedad**:
   - Preguntas y respuestas se mezclan (`shuffle()`, `inRandomOrder()`) para que ningún intento sea igual a otro.

3.  **Medidas de Seguridad (Pasivas)**:
    -   **Bloqueo del Portapapeles**: Deshabilitadas acciones de Copiar, Pegar, Cortar y Arrastrar.
    -   **Protección de Código Pasiva**: Bloqueo de teclas de DevTools y menú contextual.
    -   **Bucle de Depuración**: Inyección de bucle `debugger` para congelar intentos de inspección de código.
    -   **Marca de Agua Dinámica (Screen Shield)**: Superposición de la identidad del estudiante (Nombre, IP, Fecha) en toda la pantalla para desincentivar capturas de pantalla y fotos externas.

### 📜 Generación de Certificados
- **Códigos Únicos**: Cada certificado emitido incluye un código de validación único generado algorítmicamente.
- **Vista Previa Instantánea**: Generación PDF en tiempo real con diseño responsivo "1:1" para impresión A4 sin bordes.
- **Gestión de Fechas**: Normalización de zonas horarias para asegurar fechas de emisión correctas.

### ⏱️ Configuración de Tiempos
- **Tiempo de Espera**: Configurable en minutos entre intentos fallidos.
- **Tiempo Límite de Duración**: Opción para establecer un tiempo máximo para completar el examen.
- **Zona Horaria**: Estandarizada a `America/Bogota` para todos los registros.

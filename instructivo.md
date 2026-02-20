# Manual Técnico y de Usuario: Módulo de Exámenes y Calificaciones

Este documento proporciona una guía detallada sobre el funcionamiento, configuración y uso del módulo de evaluaciones de EducApp. Está dirigido tanto a instructores (autores) como a administradores y estudiantes.

---

## 1. Visión General del Sistema

El módulo de exámenes permite la creación de evaluaciones dinámicas, aleatorias y seguras. Se desacopla de la estructura lineal de lecciones para permitir:
*   **Preguntas Aleatorias**: Selección al azar de un banco de preguntas por categoría.
*   **Ponderación por Categoría**: Asignación de pesos porcentuales específicos a grupos de preguntas.
*   **Tipos de Pregunta**: Soporte para preguntas Cerradas (calificación automática) y Abiertas (requieren revisión manual).
*   **Seguridad (Proctoring)**: Detección de intentos de trampa (cambio de pestaña, developer tools).

---

## 2. Para Instructores y Administradores

### 2.1. Gestión del Banco de Preguntas
Ruta: `/author/exams/question-bank`

El banco de preguntas es el repositorio central. Las preguntas se organizan por **Categorías**.

*   **Categorías**: Cree categorías temáticas (ej. "Frontend Básico", "Seguridad").
*   **Creación de Preguntas**:
    *   **Tipo Cerrada**: Defina el enunciado y múltiples opciones. Marque una como "Correcta". El sistema barajará las opciones para cada estudiante (1 correcta + 3 incorrectas al azar).
    *   **Tipo Abierta**: Defina el enunciado. El estudiante escribirá texto libre. Requiere calificación posterior.
*   **Papelera (Soft Deletes)**:
    *   Si elimina una pregunta, esta va a una "papelera" lógica para no romper exámenes pasados.
    *   Puede **Restaurar** preguntas desde la pestaña de "Eliminados" si las borró por error.

### 2.2. Construcción de Exámenes
Ruta: `/author/exams/create` o `/author/exams/{id}/builder`

Un examen es un contenedor de reglas. No contiene preguntas fijas, sino *instrucciones* de cómo generarlas.

**Configuración General:**
*   **Intentos**: Máximo número de veces que el alumno puede presentar.
*   **Tiempo Límite**: Duración máxima (temporizador visible).
*   **Tiempo de Espera**: Minutos obligatorios de espera entre un intento fallido y el siguiente.
*   **Puntaje de Aprobación**: Porcentaje mínimo (ej. 80%).

**Constructor (Evaluation Builder):**
1.  Haga clic en el icono "Constructor" (bloques) en el listado de exámenes.
2.  **Agregar Categoría**: Seleccione una categoría del banco.
3.  **Configurar Peso y Cantidad**:
    *   **Preguntas a mostrar**: Cuántas preguntas de esa categoría saldrán en el examen.
    *   **Valor Porcentual**: Cuánto vale esa categoría del total (0-100%).
    *   *Nota*: Si selecciona 2 preguntas y la categoría vale 20%, cada pregunta valdrá automáticamente 10% (Puntaje Máximo Dinámico).

### 2.3. Proceso de Calificación (Grading)
Ruta: `/author/exams/grader`

Cuando un examen incluye preguntas **Abiertas**, el intento queda en estado **"En Revisión" (`pending_review`)** tras finalizar.

1.  El instructor verá un listado de "Pendientes de Revisión".
2.  Al entrar a calificar:
    *   **Validación de Topes**: El sistema calcula el puntaje máximo permitido por pregunta (basado en el peso de la categoría) y lo muestra como `(Max X.XX pts)`.
    *   **Seguridad**: Si intenta asignar una nota superior al máximo, el sistema bloqueará el guardado y mostrará una alerta roja.
    *   **Retroalimentación**: Puede dejar comentarios de texto para el alumno.
3.  Al confirmar, el estado cambia a `graded` (o `finished`) y se calcula la nota definitiva.

### 2.4. Monitoreo y Auditoría
Ruta: `/author/exams/{id}/monitoring`

*   **Detalle por Categorías**: Al ver el detalle de un intento, las preguntas se agrupan por la categoría a la que pertenecen.
*   **Desglose de Puntajes**:
    *   **Puntaje**: Muestra la nota obtenida dentro de esa categoría específica (ej. 8/10).
    *   **Peso**: Indica el peso porcentual configurado para esa categoría en el examen.
    *   **Aporte**: Muestra exactamente cuánto suma esa categoría a la nota final del examen (cálculo: `Desempeño * Peso / 100`).
*   **Auditoría de Intentos**: Verá por qué finalizó cada examen (Tiempo agotado, Finalización manual, Detección de trampa).
*   **Anulación**: Puede anular intentos sospechosos manualmente.

### 2.5. Dashboard de Estadísticas Globales (Nuevo)
Ruta: `/author/exams/global-statistics`

Panel estratégico para visualizar el rendimiento académico general de todas las evaluaciones.

*   **KPIs Principales**:
    *   **Tasa de Aprobación**: Porcentaje de estudiantes que aprobaron vs total de intentos finalizados.
    *   **Tiempo Promedio**: Duración media que toman los estudiantes en completar las evaluaciones.
    *   **Promedio Global**: Calificación media de todos los intentos en el periodo.
*   **Filtros de Tiempo**:
    *   El dashboard carga por defecto los datos de los **Últimos 7 días** para una visión inmediata y fresca.
    *   Puede cambiar a "30 días", "Este Mes" o "Todo el tiempo". Los gráficos se actualizarán automáticamente sin recargar la página gracias a la tecnología reactiva implementada.
*   **Estudiantes en Riesgo**: Lista inteligente que identifica alumnos con un promedio inferior al 60%, permitiendo intervención temprana.
*   **Evaluaciones Críticas**: Tabla que destaca los exámenes con la tasa de aprobación más baja, señalando posible dificultad excesiva.

---

## 3. Para Estudiantes

### 3.1. Presentación del Examen
*   **Modo Seguro**: Al iniciar, el navegador entra en modo vigilado.
    *   No se permite copiar/pegar.
    *   Si cambia de pestaña o minimiza el navegador, el examen se enviará automáticamente o se marcará la incidencia.
*   **Temporizador**: Cuenta regresiva visible. Al llegar a cero, se envían las respuestas actuales.

### 3.2. Consulta de Resultados
Ruta: `/exams/{id}/summary`

Al finalizar, el estudiante es redirigido al resumen:
*   **Aprobado**: Muestra botón verde para descargar certificado.
*   **Reprobado**: Muestra botón para reintentar (si el tiempo de espera ha pasado).
*   **En Revisión**: Muestra una tarjeta amarilla indicando que el profesor está calificando. No permite reintentar hasta tener la nota final.

### 3.3. Mis Evaluaciones
Ruta: `/my-evaluations`

Panel centralizado donde el alumno ve todo su historial.
*   **Estados Claros**: Etiquetas para "Aprobado", "En Progreso", "En Revisión" o "Anulado".
*   **Acceso Rápido**: Botón **"Ver Examen"** que permite volver a la vista detallada de resumen en cualquier momento.

---

## 4. Anexo Técnico: Flujo de Estados

El intento de un usuario (`ExamUserAttempt`) transita por los siguientes estados:

1.  `in_progress`: El estudiante está respondiendo o el tiempo corre.
2.  `pending_review`: (Solo si hay preguntas abiertas) El estudiante envió, pero falta calificación manual.
3.  `finished` / `graded`: El examen tiene nota definitiva. El sistema evalúa si `final_score >= passing_score` para marcar `is_approved`.
4.  `void`: Intento anulado por el instructor.
5.  `expired`: El tiempo límite venció (manejado por jobs o verificación al cargar).

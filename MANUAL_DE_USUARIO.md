# 📘 Manual de Usuario Detallado - EducApp

Bienvenido al manual oficial y detallado de **EducApp**. Este documento sirve como guía completa para navegar, configurar y administrar la plataforma educativa. Abarca todos los roles de usuario disponibles: Estudiante, Instructor y Administrador.

---

## 📑 Tabla de Contenidos

1.  [Introducción](#1-introducción)
2.  [Para Estudiantes](#2-para-estudiantes)
    *   [2.1 Primeros Pasos (Registro e Ingreso)](#21-primeros-pasos)
    *   [2.2 Navegación y Búsqueda de Cursos](#22-navegación-y-búsqueda-de-cursos)
    *   [2.3 Aula Virtual (Reproductor de Clases)](#23-aula-virtual)
    *   [2.4 Sistema de Evaluaciones y Seguridad](#24-sistema-de-evaluaciones-y-seguridad)
    *   [2.5 Certificación y Logros](#25-certificación-y-logros)
    *   [2.6 Gestión de Perfil](#26-gestión-de-perfil)
3.  [Para Instructores](#3-para-instructores)
    *   [3.1 Panel de Control (Dashboard)](#31-panel-de-control)
    *   [3.2 Creación y Edición de Cursos](#32-creación-y-edición-de-cursos)
    *   [3.3 Gestión Avanzada de Exámenes](#33-gestión-avanzada-de-exámenes)
        *   [Banco de Preguntas e Importación Masiva](#banco-de-preguntas-e-importación-masiva)
        *   [Constructor de Evaluaciones](#constructor-de-evaluaciones)
        *   [Calificación y Monitoreo](#calificación-y-monitoreo)
    *   [3.4 Finanzas y Estadísticas](#34-finanzas-y-estadísticas)
4.  [Para Administradores](#4-para-administradores)
    *   [4.1 Gestión de Usuarios y Roles](#41-gestión-de-usuarios-y-roles)
    *   [4.2 Configuración Corporativa (Empresas)](#42-configuración-corporativa-empresas)
    *   [4.3 Moderación de Cursos](#43-moderación-de-cursos)
    *   [4.4 Auditoría y Seguridad del Sistema](#44-auditoría-y-seguridad-del-sistema)

---

## 1. Introducción

**EducApp** es una plataforma LMS (Learning Management System) integral construida sobre tecnologías modernas para ofrecer una experiencia de aprendizaje fluida, segura y escalable. 

**Características Principales:**
*   **Multirole**: Interfaces específicas para alumnos, profesores y administradores.
*   **Proctoring Local**: Algoritmos anti-fraude integrados en los exámenes.
*   **Certificación Dinámica**: Generación de diplomas verificables con códigos QR.
*   **E-Commerce**: Venta de cursos con pasarela de pagos integrada.

---

## 2. Para Estudiantes

### 2.1 Primeros Pasos
*   **Registro de Cuenta**:
    1.  Diríjase a la página principal y haga clic en **"Registrarse"**.
    2.  Complete el formulario con su Nombre Completo, Correo Electrónico y una Contraseña segura.
    3.  Acepte los términos y condiciones.
    *   *Nota*: Si su cuenta es **Corporativa**, no use el registro público. Solicite el enlace de invitación a su supervisor para quedar vinculado automáticamente a su Empresa y Departamento.
*   **Inicio de Sesión**: Use su correo y contraseña en el botón **"Ingresar"**. Si olvidó su clave, use la opción "¿Olvidaste tu contraseña?" para recibir un enlace de recuperación.

### 2.2 Navegación y Búsqueda de Cursos
*   **Catálogo General**: En `/cursos`, encontrará toda la oferta académica.
*   **Filtros Avanzados**:
    *   **Categoría**: Filtre por temas (ej. Tecnología, Diseño, Negocios).
    *   **Nivel**: Elija entre Básico, Intermedio o Avanzado.
    *   **Precio**: Busque cursos de pago o gratuitos.
*   **Inscripción y Compra**:
    1.  Seleccione un curso para ver su ficha técnica (Instructor, Temario, Valoraciones).
    2.  Haga clic en **"Comprar Ahora"** o **"Agregar al Carrito"**.
    3.  En el carrito, revise su pedido. Si tiene un **Cupón de Descuento**, ingréselo en la casilla correspondiente.
    4.  Proceda al pago seguro a través de **MercadoPago** (Tarjetas Crédito/Débito, PSE, Efecty).
    5.  Una vez confirmado el pago, el acceso al curso es inmediato e ilimitado.

### 2.3 Aula Virtual
Al entrar a un curso matriculado, accederá al **Reproductor de Aprendizaje**:
*   **Menú de Lecciones (Izquierda)**: Lista desplegable de secciones y clases. Un icono de "check" verde indicará las clases ya vistas.
*   **Reproductor de Video (Centro)**:
    *   Controles estándar (Play, Pausa, Volumen, Pantalla Completa).
    *   **Restricción de Avance**: Por motivos pedagógicos, **no podrá marcar la clase como "Vista" ni avanzar a la siguiente** hasta haber visualizado al menos el **30%** del video actual. La barra de progreso y el botón "Siguiente" permanecerán bloqueados hasta cumplir este requisito.
*   **Recursos Descargables**: Ubicados debajo del video. Incluyen PDFs, hojas de cálculo o enlaces externos proporcionados por el instructor.
*   **Sección de Comentarios**: Espacio para plantear dudas al instructor o discutir con otros compañeros.

### 2.4 Sistema de Evaluaciones y Seguridad
Los cursos pueden contener cuestionarios intermedios y exámenes finales.
*   **Inicio del Examen**:
    *   Lea atentamente las instrucciones (Tiempo límite, Número de intentos permitidos).
    *   Haga clic en "Comenzar".
*   **Interfaz de Preguntas**:
    *   Responda las preguntas una por una o en lista (según configuración).
    *   **Temporizador**: Una cuenta regresiva en la parte superior indica el tiempo restante. Si llega a 00:00, el examen se envía automáticamente con lo que haya respondido.
*   **Modo Seguro (Anti-Trampa)**:
    *   El sistema monitorea su actividad durante el examen.
    *   **Prohibido**: Cambiar de pestaña, minimizar el navegador, abrir otras aplicaciones, usar atajos de teclado (Ctrl+C, Ctrl+V).
    *   **Consecuencia**: Si el sistema detecta estas acciones, **el examen se cerrará inmediatamente** y se calificará hasta ese punto (o se anulará), registrando la incidencia para el instructor.
*   **Resultados**:
    *   Verá su calificación inmediatamente (para preguntas cerradas).
    *   Si hay preguntas abiertas, verá el estado **"En Revisión"** hasta que el instructor califique manualmente.

### 2.5 Certificación y Logros
*   **Requisitos**: Haber completado el 100% de las lecciones y aprobado el Examen Final con la nota mínima requerida.
*   **Descarga**:
    1.  Vaya al resumen del curso o a la sección **"Mis Evaluaciones"**.
    2.  Si aprobó, verá un botón verde **"Descargar Certificado"**.
    3.  Se generará un PDF de alta resolución con:
        *   Su nombre completo.
        *   Nombre del curso e instructor.
        *   Firmas digitales (Instructor o Representante Legal).
        *   **Código QR y Hash**: Elementos de seguridad únicos para validar la autenticidad del documento.

### 2.6 Gestión de Perfil
*   **Mis Evaluaciones**: Panel centralizado (`/my-evaluations`) para ver su historial académico, intentos restantes y descargar certificados pasados.
*   **Cuenta**: En la configuración de usuario puede actualizar su foto de perfil, cambiar su contraseña y gestionar sus métodos de pago guardados.

---

## 3. Para Instructores

### 3.1 Panel de Control
Acceda al menú de usuario y seleccione **"Instructor"**.
*   **Dashboard**: Métricas clave como Ingresos Totales, Cantidad de Estudiantes y Valoración Promedio de sus cursos.

### 3.2 Creación y Edición de Cursos
Ruta: **Instructor > Cursos > Nuevo Curso**
El proceso consta de 4 etapas:
1.  **Información del Curso**:
    *   Título atractivo y Subtítulo.
    *   Descripción detallada (use el editor de texto enriquecido).
    *   Imagen de portada (Jpg/Png) y Video promocional (URL de YouTube/Vimeo).
    *   Categoría y Nivel.
2.  **Curriculum (Lecciones)**:
    *   Estructure el curso en **Secciones** (Módulos).
    *   Dentro de cada sección, añada **Lecciones**. Puede subir videos directamente (alojamiento seguro) o usar enlaces externos.
    *   Añada **Recursos** (archivos) a cada lección si es necesario.
3.  **Metas y Audiencia**: Defina "Qué aprenderá el estudiante" y "Requisitos previos". Esto ayuda a filtrar el curso correctamente.
4.  **Precios y Cupones**:
    *   Seleccione una tarifa de la lista o cree una nueva ("Creación Rápida").
    *   Genere **Cupones de Descuento** por porcentaje o valor fijo, con fecha de caducidad y límite de usos.

### 3.3 Gestión Avanzada de Exámenes

#### Banco de Preguntas e Importación Masiva
Ruta: **Exámenes > Banco de Preguntas**
*   **Concepto**: Las preguntas no pertenecen a un examen, sino a un "Banco" categorizado. Esto permite reutilizarlas en múltiples evaluaciones.
*   **Creación Manual**: Click en "Nueva Pregunta". Defina enunciado, tipo (Abierta/Cerrada), opciones y retroalimentación.
*   **Importación Masiva (Excel)**:
    1.  Haga clic en **"Importar"**.
    2.  Descargue la **Plantilla Excel**.
    3.  Llene la plantilla respetando las columnas: `pregunta`, `tipo`, `opcion_1`, `es_correcta_1`, `dificultad`, `categoria`.
    4.  Suba el archivo.
    5.  El sistema validará los datos, creará las categorías faltantes automáticamente y le notificará el resultado.

#### Constructor de Evaluaciones
Ruta: **Exámenes > Mis Exámenes > Constructor**
Diseñe exámenes dinámicos definidos por reglas, no por preguntas fijas.
1.  **Configuración General**: Nombre, Descripción, Tiempo límite (minutos), Intentos permitidos, Puntaje de aprobación.
2.  **Reglas de Contenido**:
    *   Seleccione una **Categoría** del banco (ej. "Historia").
    *   Defina el **Peso (%)**: Qué porcentaje de la nota final aporta esta categoría.
    *   Defina la **Cantidad**: Cuántas preguntas extraer al azar de esta categoría.
    *   *Ejemplo*: Un examen puede tener 10 preguntas de "Historia" (50% nota) y 5 de "Geografía" (50% nota). Cada estudiante recibirá preguntas distintas pero con la misma estructura.

#### Calificación y Monitoreo
*   **Calificación Manual (`/exams/grader`)**:
    *   Bandeja de entrada para preguntas abiertas.
    *   Vea la respuesta del estudiante y asigne un puntaje (el sistema valida que no exceda el máximo posible).
    *   Añada comentarios de retroalimentación.
*   **Monitoreo en Vivo (`/exams/monitoring`)**:
    *   Tabla con todos los intentos en curso o finalizados.
    *   Columna **"Causa de Cierre"**: Indica si el examen terminó normalmente o por "Fraude Detectado" (cambio de pestaña, etc.).
    *   Opción para **Anular Intento** si se confirma irregularidad.

### 3.4 Finanzas y Estadísticas
*   **Estadísticas Académicas**:
    *   Gráficos de "Embudo de Aprobación" (cuántos inician vs cuántos aprueban).
    *   Ranking de mejores estudiantes.
    *   Detección de "Preguntas Críticas" (las que más fallan los alumnos).
*   **Finanzas**:
    *   Detalle de comisiones por venta.
    *   Solicitud de retiro de fondos (pago manual por parte del administrador).

---

## 4. Para Administradores

### 4.1 Gestión de Usuarios y Roles
Ruta: **Admin > Usuarios / Roles**
*   **Usuarios**: Busque, edite o elimine usuarios. Puede asignar roles (Instructor, Administrador) manualmente.
*   **Roles y Permisos**:
    *   Gestione los niveles de acceso del sistema.
    *   Interfaz visual para activar/desactivar permisos (ej. "Ver dashboard", "Crear cursos", "Eliminar usuarios") agrupados por módulos.

### 4.2 Configuración Corporativa (Empresas)
Ruta: **Admin > Empresas / Departamentos**
Para clientes B2B:
1.  Cree la **Empresa** (Nombre, NIT, Logo, Representante Legal).
    *   El logo y firma del representante aparecerán en los certificados de sus empleados.
2.  Cree **Departamentos** (Áreas) dentro de la empresa.
3.  Asigne usuarios a estos departamentos desde la edición de usuario.

### 4.3 Moderación de Cursos
Ruta: **Admin > Cursos > Pendientes de Revisión**
*   Como administrador, debe aprobar los cursos antes de que salgan a la venta.
*   Revise la calidad del contenido, video y descripción.
*   **Acciones**:
    *   **Aprobar**: El curso se publica inmediatamente.
    *   **Observación**: Devuelve el curso al instructor con notas sobre qué corregir.
    *   **Rechazar**: Cancela la publicación.

### 4.4 Auditoría y Seguridad del Sistema
Ruta: **Admin > Auditoría**
Herramienta forense para el control interno.
*   **Log de Actividades**: Registro inmutable de acciones críticas (quién eliminó qué, quién editó qué) con fecha, hora y dirección IP.
*   **Auditoría de Cursos**:
    *   Monitoree las sesiones de estudio de los alumnos.
    *   Vea duración exacta de la sesión y porcentaje de avance logrado.
    *   Detecte cuentas compartidas verificando múltiples IPs simultáneas.

---
**EducApp V1.5.28** - Documentación Generada el 10/02/2026.

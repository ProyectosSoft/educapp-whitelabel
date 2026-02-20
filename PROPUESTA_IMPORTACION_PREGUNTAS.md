# Propuesta Técnica Corregida: Importación Dinámica desde Excel

## 1. Resumen Ejecutivo
Esta propuesta detalla la implementación de una funcionalidad de **Carga Dinámica** de preguntas mediante Excel. A diferencia de un archivo estático en el servidor, esta solución permite que **cada instructor seleccione y suba su propio archivo Excel** desde su computadora (`Input File`).

Las preguntas importadas se asignarán automáticamente al instructor autenticado, garantizando la privacidad y separación de datos entre usuarios.

---

## 2. Flujo de Usuario (UX) - Carga Individual

El proceso se realizará íntegramente en la vista `/author/exams/question-bank`:

1.  **Selección de Archivo**:
    *   Se habilitará un botón **"Importar Preguntas"**.
    *   Al pulsarlo, se abrirá un modal con un campo de selección de archivo:
        > `Seleccionar archivo Excel (.xlsx, .xls) de su equipo`
2.  **Validación Previa**:
    *   El sistema verificará que el archivo tenga la extensión correcta antes de procesarlo.
3.  **Procesamiento Privado**:
    *   Al hacer clic en "Subir e Importar", Laravel leerá el archivo temporalmente.
    *   **Crucial**: El sistema asignará todas las preguntas creadas al `user_id` del instructor que está logueado en ese momento.
    *   El archivo NO se guarda permanentemente en la carpeta pública ni en la raíz del servidor; se procesa en memoria o en la carpeta temporal del sistema (`sys_get_temp_dir`) y se desecha tras la importación.

---

## 3. Formato del Archivo Excel

Cada instructor debe preparar su Excel siguiendo esta plantilla (se ofrecerá un botón para descargar un ejemplo vacío):

| Columna | Header | Descripción |
| :--- | :--- | :--- |
| **A** | `categoria` | Nombre de la categoría (ej. "Historia 101"). Si no existe para este instructor, se crea. |
| **B** | `dificultad` | "Baja", "Media", "Alta". |
| **C** | `tipo` | `cerrada` (con opciones) o `abierta` (texto libre). |
| **D** | `enunciado` | La pregunta en sí. |
| **E** | `opcion_1` | Texto de la opción A. |
| **F** | `es_correcta_1` | `SI` si es la correcta. |
| ... | ... | (Hasta 4 opciones opcionales) |

---

## 4. Implementación Técnica

### A. Componente Livewire (`QuestionBank.php`)

Se modificará el componente para manejar la subida de archivos temporal (`TemporaryUploadedFile`).

```php
use Livewire\WithFileUploads;

class QuestionBank extends Component
{
    use WithFileUploads; // Trait necesario para inputs de archivo

    public $importFile; // Aquí se almacena temporalmente el Excel del instructor

    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls|max:10240', // Máx 10MB
        ]);

        // Importación pasando el ID del usuario actual para filtrar/crear datos
        Excel::import(new QuestionsImport(Auth::id()), $this->importFile);
        
        $this->emit('refreshBank');
        $this->reset(['importFile', 'showImportModal']);
        session()->flash('message', 'Sus preguntas han sido importadas exitosamente.');
    }
}
```

### B. Clase Importador (`QuestionsImport.php`)

Esta clase encapsulará la lógica de negocio para asegurar que los datos sean privados del instructor.

```php
class QuestionsImport implements ToModel, WithHeadingRow
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        // 1. Buscar o Crear Categoría SOLO para este usuario
        $category = ExamCategory::firstOrCreate([
            'user_id' => $this->userId, // <--- CLAVE: Se fuerza el ID del instructor
            'name' => $row['categoria']
        ]);

        // 2. Crear la pregunta vinculada a esa categoría
        $question = ExamQuestion::create([
            'category_id' => $category->id,
            'question_text' => $row['enunciado'],
            // ... resto de campos
        ]);

        // 3. Crear opciones (si aplica)
        // ...
    }
}
```

---

## 5. Ventajas de este Enfoque

1.  **Independencia**: El archivo `raiz.xlsx` (o cualquier nombre) no existe en el servidor. Cada instructor tiene su propia versión local.
2.  **Seguridad**: Un instructor no puede accidentalmente poblar el banco de preguntas de otro, ya que el `user_id` se inyecta forzosamente desde la sesión (`Auth::id()`).
3.  **Flexibilidad**: Los instructores pueden trabajar sus preguntas offline en Excel y subirlas cuando estén listos.

---
**Recurso**: Documento actualizado para reflejar la carga dinámica por usuario ("Client-Side Selection").

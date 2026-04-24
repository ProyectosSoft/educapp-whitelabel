<?php

$output = __DIR__ . '/../docs/documentacion_arquitectura_educapp.docx';

function xmlText(string $value): string
{
    return htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
}

function paragraph(string $text = '', string $style = 'Normal'): string
{
    $styleXml = $style !== 'Normal' ? '<w:pPr><w:pStyle w:val="' . xmlText($style) . '"/></w:pPr>' : '';
    return '<w:p>' . $styleXml . '<w:r><w:t xml:space="preserve">' . xmlText($text) . '</w:t></w:r></w:p>';
}

function bullet(string $text): string
{
    return '<w:p><w:pPr><w:numPr><w:ilvl w:val="0"/><w:numId w:val="1"/></w:numPr></w:pPr><w:r><w:t xml:space="preserve">' . xmlText($text) . '</w:t></w:r></w:p>';
}

function codeBlock(string $text): string
{
    $xml = '';
    foreach (explode("\n", trim($text)) as $line) {
        $xml .= '<w:p><w:pPr><w:pStyle w:val="Code"/></w:pPr><w:r><w:t xml:space="preserve">' . xmlText($line) . '</w:t></w:r></w:p>';
    }
    return $xml;
}

function table(array $headers, array $rows): string
{
    $xml = '<w:tbl><w:tblPr><w:tblStyle w:val="TableGrid"/><w:tblW w:w="0" w:type="auto"/></w:tblPr>';
    $allRows = array_merge([$headers], $rows);

    foreach ($allRows as $index => $row) {
        $xml .= '<w:tr>';
        foreach ($row as $cell) {
            $boldStart = $index === 0 ? '<w:b/>' : '';
            $xml .= '<w:tc><w:tcPr><w:tcW w:w="3000" w:type="dxa"/></w:tcPr><w:p><w:r><w:rPr>' . $boldStart . '</w:rPr><w:t xml:space="preserve">' . xmlText($cell) . '</w:t></w:r></w:p></w:tc>';
        }
        $xml .= '</w:tr>';
    }

    return $xml . '</w:tbl>';
}

$architectureDiagram = <<<'TEXT'
Usuario / Navegador
        |
        v
Rutas Laravel
        |
        +-- Web publica
        +-- Panel Admin
        +-- Panel Author / Instructor
        +-- Panel Alumno
        +-- Panel Afiliado
        +-- Pagos
        +-- API Sanctum
        |
        v
Controladores / Componentes Livewire
        |
        v
Modelos Eloquent
        |
        v
Base de Datos

Servicios externos:
- MercadoPago
- Correo
- PDF / Reportes
- Exportaciones Excel
TEXT;

$flowDiagram = <<<'TEXT'
1. El usuario solicita una pagina o ejecuta una accion.
2. Laravel recibe la solicitud mediante una ruta.
3. Los middleware verifican autenticacion, sesion y permisos.
4. El controlador o componente Livewire procesa la accion.
5. Los modelos Eloquent consultan o modifican la base de datos.
6. La vista Blade renderiza la respuesta HTML.
7. El navegador muestra la interfaz al usuario.
TEXT;

$body = '';
$body .= paragraph('Documentacion de Arquitectura de Software', 'Title');
$body .= paragraph('Proyecto: EducApp WhiteLabel');
$body .= paragraph('Fecha: Abril 2026');

$body .= paragraph('Arquitectura de Software', 'Heading1');
$body .= paragraph('El proyecto EducApp WhiteLabel esta desarrollado bajo una arquitectura web basada en Laravel 10, siguiendo el patron MVC: Modelo, Vista, Controlador. La aplicacion organiza sus responsabilidades en capas definidas: rutas, controladores, modelos, vistas Blade, componentes Livewire, middleware, politicas de autorizacion, migraciones y seeders.');

$body .= paragraph('Diagrama General', 'Heading1');
$body .= codeBlock($architectureDiagram);

$body .= paragraph('Descripcion General', 'Heading1');
$body .= paragraph('La aplicacion funciona como una plataforma educativa con multiples perfiles de usuario: administrador, instructor o autor, alumno y afiliado. Cada perfil accede a modulos especificos mediante rutas separadas y protegidas con autenticacion, roles, permisos y politicas de autorizacion.');
$body .= paragraph('El sistema usa Laravel Blade para la renderizacion de vistas del lado del servidor y Livewire para interfaces dinamicas sin necesidad de construir una SPA completa. La persistencia de datos se gestiona mediante Eloquent ORM, migraciones y seeders.');

$body .= paragraph('Capas Principales', 'Heading1');
$body .= table(
    ['Capa', 'Ubicacion', 'Responsabilidad'],
    [
        ['Rutas', 'routes/web.php, routes/admin.php, routes/author.php, routes/alumnos.php, routes/afiliados.php, routes/payment.php, routes/api.php', 'Define los puntos de entrada del sistema.'],
        ['Controladores', 'app/Http/Controllers', 'Procesan solicitudes, coordinan logica y retornan vistas o respuestas.'],
        ['Componentes Livewire', 'app/Http/Livewire', 'Manejan interfaces dinamicas como carrito, cursos, examenes y paneles.'],
        ['Modelos', 'app/Models', 'Representan las entidades del negocio y sus relaciones con la base de datos.'],
        ['Vistas', 'resources/views', 'Contienen la interfaz visual construida con Blade.'],
        ['Base de datos', 'database/migrations, database/seeders', 'Definen la estructura y datos iniciales del sistema.'],
        ['Autenticacion', 'Jetstream, Fortify, Sanctum', 'Gestionan login, registro, doble factor y tokens API.'],
        ['Autorizacion', 'Spatie Permission, Policies', 'Controlan roles, permisos y reglas de acceso.'],
        ['Frontend', 'Vite, TailwindCSS, AlpineJS, Livewire', 'Gestionan recursos visuales e interaccion del usuario.'],
    ]
);

$body .= paragraph('Modulos del Sistema', 'Heading1');
$body .= bullet('Modulo publico: pagina principal, busqueda, listado de cursos, detalle de curso y registro.');
$body .= bullet('Modulo administrador: usuarios, roles, permisos, cursos, categorias, empresas, departamentos, auditoria y reportes financieros.');
$body .= bullet('Modulo instructor/author: creacion de cursos, curriculo, lecciones, precios, estudiantes, cupones, referidos y examenes.');
$body .= bullet('Modulo alumno: dashboard, cursos inscritos, evaluaciones, certificados, carrito, wishlist y pagos.');
$body .= bullet('Modulo afiliados: cursos afiliados, dashboard y gestion financiera.');
$body .= bullet('Modulo financiero: ordenes, pagos, comprobantes, facturas, saldos a favor, devoluciones y transacciones.');
$body .= bullet('Modulo examenes: banco de preguntas, evaluaciones, intentos, calificacion, estadisticas y certificados.');
$body .= bullet('Modulo empresarial: empresas, departamentos, invitaciones, usuarios asociados y cursos por empresa.');

$body .= paragraph('Flujo General de la Aplicacion', 'Heading1');
$body .= codeBlock($flowDiagram);

$body .= paragraph('Tecnologias Principales', 'Heading1');
$body .= bullet('Backend: PHP 8.1 y Laravel 10.');
$body .= bullet('Frontend: Blade, Livewire 2, AlpineJS, TailwindCSS y Vite.');
$body .= bullet('Autenticacion: Laravel Jetstream, Fortify y Sanctum.');
$body .= bullet('Autorizacion: Spatie Laravel Permission y Policies de Laravel.');
$body .= bullet('Base de datos: migraciones, seeders y modelos Eloquent.');
$body .= bullet('Pagos: MercadoPago.');
$body .= bullet('Reportes: DomPDF y Laravel Excel.');
$body .= bullet('Carrito: hardevine/shoppingcart.');
$body .= bullet('Panel administrativo: AdminLTE.');

$body .= paragraph('Resumen Arquitectonico', 'Heading1');
$body .= paragraph('EducApp WhiteLabel utiliza una arquitectura monolitica modular basada en Laravel. Aunque el sistema se despliega como una sola aplicacion, internamente esta dividido por dominios funcionales y perfiles de usuario. Esta estructura permite separar responsabilidades, proteger modulos mediante roles y permisos, y mantener una organizacion clara entre logica de negocio, presentacion, persistencia y seguridad.');

$documentXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:body>' . $body . '<w:sectPr><w:pgSz w:w="12240" w:h="15840"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440"/></w:sectPr></w:body>
</w:document>';

$stylesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:style w:type="paragraph" w:default="1" w:styleId="Normal"><w:name w:val="Normal"/><w:rPr><w:sz w:val="22"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Title"><w:name w:val="Title"/><w:rPr><w:b/><w:sz w:val="36"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading1"><w:name w:val="heading 1"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:rPr><w:b/><w:sz w:val="28"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Code"><w:name w:val="Code"/><w:rPr><w:rFonts w:ascii="Courier New" w:hAnsi="Courier New"/><w:sz w:val="20"/></w:rPr></w:style>
  <w:style w:type="table" w:styleId="TableGrid"><w:name w:val="Table Grid"/><w:tblPr><w:tblBorders><w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:insideH w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:insideV w:val="single" w:sz="4" w:space="0" w:color="auto"/></w:tblBorders></w:tblPr></w:style>
</w:styles>';

$contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
  <Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>
</Types>';

$rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>';

$documentRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"></Relationships>';

$zip = new ZipArchive();
if ($zip->open($output, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "No se pudo crear el archivo: {$output}\n");
    exit(1);
}

$zip->addFromString('[Content_Types].xml', $contentTypes);
$zip->addFromString('_rels/.rels', $rels);
$zip->addFromString('word/document.xml', $documentXml);
$zip->addFromString('word/styles.xml', $stylesXml);
$zip->addFromString('word/_rels/document.xml.rels', $documentRels);
$zip->close();

echo $output . PHP_EOL;

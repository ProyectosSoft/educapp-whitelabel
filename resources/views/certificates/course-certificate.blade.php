<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Finalización</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: 297mm 210mm; /* A4 Landscape */
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
        }
        .certificate-container {
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path("img/certificate-bg-v2.jpg") }}');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            color: #3e3e3e;
        }

        /* 
           ABSOLUTE POSITIONING FOR PRECISE LAYOUT 
           Coordinates are estimates based on the provided image aspect ratio.
        */

        /* "Grupo Effi Se certifica que:" is already in the image? 
           Looking at the image, there is a line "Grupo Effi Se certifica que:" 
           Wait, if the user provided image has NO text, I should add it.
           If the user provided image HAS text placeholders (lines), I need to align my text to those lines.
           
           The user said: "usar tu imagen original como background y encima poner solo los textos"
           The uploaded image HAS:
           - "Grupo Effi" logo
           - "CERTIFICACIÓN DE FINALIZACIÓN ACADÉMICA"
           - "Grupo Effi Se certifica que:"
           - "Documento de identidad: _______________ Ciudad / País: _______________"
           - "Ha completado y aprobado..."
           - "JEFE INMEDIATO" / "CEO" lines
           - "Fecha de emisión: / /"
           - "Código de validación: EFFI-ERP-"
           
           So I only need to fill in the BLANKS.
        */

        /* Student Name - Centered big */
        .student-name {
            position: absolute;
            top: 44%; /* Moved down from 44% to clear "Se certifica que" */
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #1a1a1a;
            text-transform: uppercase;
        }

        /* ID Document - Left side */
        .identity-doc {
            position: absolute;
            top: 52.8%;
            left: 38.5%; 
            width: 250px;
            font-size: 16px;
            text-align: left;
        }

        /* City / Country - Right side */
        .city-country {
            position: absolute;
            top: 52.8%;
            left: 70%;
            width: 200px;
            font-size: 16px;
            text-align: left;
        }

        /* Course Name */
        .course-name-overlay {
            position: absolute;
            top: 64.5%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #1a1a1a;
        }

        /* Signatures */
        .sign-left {
            position: absolute;
            bottom: 12.5%; 
            left: 12%;
            width: 300px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .sign-right {
            position: absolute;
            bottom: 12.5%;
            right: 12%;
            width: 300px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        /* Date */
        .issue-date {
            position: absolute;
            bottom: 5.2%;
            left: 41.3%; 
            font-size: 14px;
            font-weight: bold;
        }

        /* Code */
        .validation-code {
            position: absolute;
            bottom: 5.2%;
            left: 77%;
            font-size: 14px;
            font-weight: bold;
            color: #3e3e3e;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Student Name -->
        <div class="student-name">
            {{ $user->name }}
        </div>

        <!-- ID Document (Using Email or Profile field if exists) -->
        <div class="identity-doc">
           {{ optional($user->perfil)->numerodeidentifacion ?? $user->email }}
        </div>

        <!-- City/Country -->
        <div class="city-country">
            Medellín, Colombia
            {{-- {{ optional($user->perfil)->ciudad ?? 'N/A' }} / {{ optional($user->perfil)->pais->name ?? 'N/A' }} --}}
            {{-- TODO: A futuro traer los datos de la base de datos --}}
        </div>

        <!-- Signatures -->
        @php
            $isCompanyUser = $user->departamento_id && $user->departamento && $user->departamento->empresa;
        @endphp

        <!-- Left: Jefe Inmediato (Only for Company Users) -->
        <div class="sign-left">
            @if($user->departamento && $user->departamento->jefe_firma)
                 <img src="{{ Storage::disk('do')->url($user->departamento->jefe_firma) }}" style="max-height: 50px; display: block; margin: 0 auto 5px auto;">
                 <div style="padding-top: 25px;">{{ $user->departamento->jefe_nombre }}</div>
            @else
                 <div style="height: 55px;"></div>
                 <div style="padding-top: 25px;">&nbsp;</div>
            @endif
        </div>

        <!-- Right: CEO (Company CEO OR Default Diego Ochoa) -->
        <div class="sign-right">
            @if($user->departamento && $user->departamento->empresa && $user->departamento->empresa->ceo_firma)
                <img src="{{ Storage::disk('do')->url($user->departamento->empresa->ceo_firma) }}" style="max-height: 50px; display: block; margin: 0 auto 5px auto;">
                <div style="padding-top: 25px;">{{ $user->departamento->empresa->ceo_nombre }}</div>
            @else
                 {{-- Default Signature --}}
                 <div style="height: 50px;"></div> 
                 <div style="padding-top: 25px;">Diego Ochoa</div>
            @endif
        </div>


        <!-- Date: format Y / M / D or similar -->
        <div class="issue-date">
             <span>{{ $date->format('d') }}</span>
             <span style="margin-left: 4px;">{{ $date->format('m') }}</span>
             <span style="margin-left: 4px;">{{ $date->format('Y') }}</span>
        </div>

        <!-- Code: After EFFI-ERP- -->
        <div class="validation-code">
            {{ $certificate->code ?? 'PENDIENTE' }}
        </div>
    </div>
</body>
</html>

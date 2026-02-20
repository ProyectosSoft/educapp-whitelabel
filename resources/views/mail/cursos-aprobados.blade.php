<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Curso Rechazado</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 25px; /* Añadido para bordes redondos */
            text-align: justify; /* Justificar el texto */
        }

        h1 {
            color: #00FFA2;
            font-family: 'Montserrat', sans-serif; /* Aplicar la fuente al encabezado h1 */
        }

        p {
            margin-bottom: 15px;
            font-family: 'Montserrat', sans-serif; /* Aplicar la fuente a los párrafos */
        }

        .course-image {
            max-width: 100%;
            height: auto;
            margin-top: 15px;
            border-radius: 25px; /* Añadido para bordes redondos */
        }

        .rejection-message {
            color: #FF6666; /* Color rojo suave para un toque de empatía */
        }
        .additional-info {
            color: #381F72;
            text-align: justify; /* Justificar el texto */
        }
        @media only screen and (max-width: 600px) {
            /* Hacer que la imagen del curso sea 100% de ancho en dispositivos pequeños */
            .course-image {
                width: 100%;
            }

            .rights-container {
                text-align: center;
                margin-top: 20px;
            }
        .rights-container p {
            font-size: 14px;
            color: #666;
        }

        }
    </style>
</head>
<body>
    <div class="container">
        <div style="border-radius:25px;background-color:#381F72;text-align: center; ">
            <h1>Curso Aprobado</h1>
        </div>
        <img src="{{"data:image/image;base64," . base64_encode(Storage::get($imagen));}}" alt="Imagen del curso" class="course-image">

        <p style="color:#381F72;"><strong>Hola {{ $nombreInstructor }},</strong></p>

        <p class="approval-message">Nos complace informarte que tu curso <strong>"{{ $nombrecurso }}"</strong> ha sido aprobado después de una evaluación positiva. ¡Felicidades por tu logro!</p>

        <p class="additional-info">Queremos agradecerte sinceramente por tu dedicación y esfuerzo en la creación de este curso. Estamos emocionados de ver cómo contribuirá al aprendizaje en nuestra plataforma.</p>

        <p class="additional-info">Recuerda que puedes revisar sugerencias y comentarios detallados directamente en la aplicación. ¡Estamos aquí para apoyarte en el proceso continuo de mejora!</p>

        <p class="additional-info">Gracias por tu contribución y por ser parte de nuestra comunidad educativa.</p>


        <p class="footer" style="color:#381F72"><strong> Atentamente, </strong><br>
        El equipo de {{ config('app.name') }}</p>

        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
            <img src="https://educapp.net/img/cursos/Logo_EducApp_6_V1_Mo.png" alt="Símbolo de la aplicación" style="max-width: 200px; margin: 0 10px;">
            <img src="https://educapp.net/img/cursos/LOGO_ANIMADO_MORADO.gif" alt="Símbolo de la aplicación" style="max-width: 50px; margin: 0 10px;">
        </div>
        <div style="text-align: center" style="font-family: 'Montserrat', sans-serif;">
            <p>Todos los derechos reservados © <strong> {{ date('Y') }}</strong></p>
        </div>
    </div>

</body>
</html>

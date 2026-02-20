<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Solicitar Reembolso</title>
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
            border-radius: 25px;
            /* Añadido para bordes redondos */
            text-align: justify;
            /* Justificar el texto */
        }

        h1 {
            color: #00FFA2;
            font-family: 'Montserrat', sans-serif;
            /* Aplicar la fuente al encabezado h1 */
        }

        p {
            margin-bottom: 15px;
            font-family: 'Montserrat', sans-serif;
            /* Aplicar la fuente a los párrafos */
        }

        .course-image {
            max-width: 100%;
            height: auto;
            margin-top: 15px;
            border-radius: 25px;
            /* Añadido para bordes redondos */
        }

        .rejection-message {
            color: #FF6666;
            /* Color rojo suave para un toque de empatía */
        }

        .additional-info {
            color: #381F72;
            text-align: justify;
            /* Justificar el texto */
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
    <div class="container" style="margin: auto; max-width: 600px; padding: 20px; font-family: Arial, sans-serif;">
        <div style="background-color: #381F72; text-align: center; padding: 20px; border-radius: 25px;">
            <h1 style="color: #ffffff;">Solicitud de Reembolso</h1>
        </div>

        <p style="color: #381F72;"><strong>Estimado/a {{ $nombreEstudiante }},</strong></p>

        <p>Queremos informarte que tu solicitud de reembolso ha sido enviada con éxito. En breve recibirás un correo
            electrónico con más detalles sobre el proceso.</p>

        <p>El reembolso se realizará en forma de crédito en tu cuenta de EduCapp. Una vez completado el proceso de
            validación, los fondos estarán disponibles para que los utilices según tus necesidades.</p>

        <p>Agradecemos tu comprensión y paciencia durante este proceso. Si tienes alguna pregunta o inquietud, no dudes
            en ponerte en contacto con nuestro equipo de soporte.</p>

        <p style="color: #381F72;"><strong>Atentamente,</strong><br>El equipo de {{ config('app.name') }}</p>
        <div style="text-align: center; margin-top: 20px;">
            <img src="https://educapp.net/img/cursos/Logo_EducApp_6_V1_Mo.png" alt="Símbolo de la aplicación"
                style="max-width: 200px; margin: 0 10px;">
            <img src="https://educapp.net/img/cursos/LOGO_ANIMADO_MORADO.gif" alt="Símbolo de la aplicación"
                style="max-width: 50px; margin: 0 10px;">
        </div>
        <div style="text-align: center; margin-top: 20px; font-family: 'Montserrat', sans-serif;">
            <p>Todos los derechos reservados © <strong>{{ date('Y') }}</strong></p>
        </div>
    </div>
</body>

</html>

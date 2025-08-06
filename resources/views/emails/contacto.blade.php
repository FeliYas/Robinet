<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #1B1919;
            color: #1B1919;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 32px auto;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(27, 25, 25, 0.10);
        }

        .header {
            background: #1B1919;
            padding: 32px 0 24px 0;
            text-align: center;
        }

        .header h1 {
            color: #AB8854;
            font-size: 26px;
            font-weight: 800;
            margin: 0;
            letter-spacing: 1px;
        }

        .content {
            padding: 32px 32px 16px 32px;
        }

        .message-intro {
            color: #1B1919;
            font-size: 17px;
            margin-bottom: 28px;
        }

        .contact-data {
            background: #F6F5F3;
            border-radius: 12px;
            padding: 24px 20px 18px 20px;
            margin-bottom: 28px;
        }

        .contact-data h2 {
            color: #AB8854;
            font-size: 18px;
            margin: 0 0 18px 0;
            border-bottom: 1px solid #E5E2DD;
            padding-bottom: 10px;
            font-weight: 700;
        }

        .data-row {
            display: flex;
            margin-bottom: 13px;
        }

        .data-label {
            width: 140px;
            color: #AB8854;
            font-weight: bold;
            font-size: 15px;
        }

        .data-value {
            color: #1B1919;
            font-size: 15px;
        }

        .message-container {
            background: #F6F5F3;
            border-radius: 12px;
            padding: 24px 20px 18px 20px;
            margin-bottom: 24px;
        }

        .message-container h2 {
            color: #AB8854;
            font-size: 18px;
            margin: 0 0 18px 0;
            border-bottom: 1px solid #E5E2DD;
            padding-bottom: 10px;
            font-weight: 700;
        }

        .message-text {
            color: #1B1919;
            font-size: 16px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .footer {
            background: #1B1919;
            color: #fff;
            text-align: center;
            font-size: 14px;
            padding: 18px 0 12px 0;
        }

        .footer p {
            margin: 6px 0;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                border-radius: 0;
            }

            .header,
            .content,
            .footer {
                padding-left: 10px;
                padding-right: 10px;
            }

            .data-row {
                flex-direction: column;
            }

            .data-label {
                width: 100%;
                margin-bottom: 3px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo Mensaje de Contacto</h1>
        </div>
        <div class="content">
            <p class="message-intro">Se recibió un nuevo mensaje desde el formulario de contacto del sitio web.</p>
            <div class="contact-data">
                <h2>Datos del mensaje</h2>
                <div class="data-row">
                    <div class="data-label">Área:</div>
                    <div class="data-value">{{ $datos['area_seleccionada'] ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Nombre:</div>
                    <div class="data-value">{{ $datos['nombre'] ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Teléfono:</div>
                    <div class="data-value">{{ $datos['telefono'] ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Provincia:</div>
                    <div class="data-value">{{ $datos['provincia'] ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Localidad:</div>
                    <div class="data-value">{{ $datos['localidad'] ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Email:</div>
                    <div class="data-value">{{ $datos['email'] ?? '-' }}</div>
                </div>
                @if (!empty($datos['empresa']))
                    <div class="data-row">
                        <div class="data-label">Empresa:</div>
                        <div class="data-value">{{ $datos['empresa'] }}</div>
                    </div>
                @endif
            </div>
            <div class="message-container">
                <h2>Mensaje</h2>
                <div class="message-text">{{ $datos['mensaje'] ?? '-' }}</div>
            </div>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Robinet. Todos los derechos reservados.</p>
            <p>Este es un correo automático, por favor no responda a este mensaje.</p>
        </div>
    </div>
</body>

</html>

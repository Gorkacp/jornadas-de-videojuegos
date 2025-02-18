<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro</title>
</head>
<body>
    <p>Hola {{ $user->name }},</p>
    <p>Gracias por registrarte. Por favor, confirma tu correo haciendo clic en el siguiente enlace:</p>
    <p><a href="{{ route('register.confirm', $user->confirmation_token) }}">Confirmar Correo</a></p>
</body>
</html>
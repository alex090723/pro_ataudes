@extends('adminlte::page')



<!DOCTYPE html>
<html>
<head>
    <title>Contraseña Temporal</title>
</head>
<body>
    <h1>Hola,</h1>
    <p>Se ha creado una cuenta para ti. Tu contraseña temporal es:</p>
    <h2>{{ $temporaryPassword }}</h2>
    <p>Por favor, cambia tu contraseña después de iniciar sesión.</p>
</body>
</html>



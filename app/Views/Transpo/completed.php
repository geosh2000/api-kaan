<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Completado</title>
    <link rel="icon" href="<?php echo $hotel == "ATELIER" ? "favicon-atelier.png" : "favicon-oleo.ico"; ?>">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f5f5f7;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        .btn-custom {
            background-color: #007aff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="message">
        <h2>Formulario Guardado Correctamente</h2>
        <p>El formulario se ha registrado correctamente, en un momento más recibirás un correo con más información.</p>
        <a href="#" class="btn btn-custom">Volver</a>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Búsqueda</title>
    <!-- Agregar enlaces a los archivos CSS de Material Design -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        /* Estilos para centrar la tabla */
        .centered-table {
            margin: 0 auto;
            width: 50%; /* Ancho ajustable según tus necesidades */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h1 class="center-align">Resultado de Búsqueda</h1>
                <div class="centered-table">
                    <table class="striped">
                        <tbody>
                            <?php foreach ($results as $row): ?>
                                <?php foreach ($row as $key => $value): ?>
                                    <tr>
                                        <td><?= $key ?></td>
                                        <td><?= $value ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Agregar enlaces a los archivos JS de Material Design -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

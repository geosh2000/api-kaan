<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de reservas</title>
    <!-- Agregar enlaces a los archivos CSS de Material Design -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Buscador de reservas</h1>
            <form action="<?= site_url('rsv/search') ?>" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="reservation_number" class="form-control" placeholder="Ingresa tu búsqueda" aria-label="Ingresa tu búsqueda" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Agregar enlaces a los archivos JS de Material Design -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir CSV de Llamadas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Subir CSV de Llamadas</div>
                    <div class="card-body">
                        <form action="<?= site_url('cio/llamadas/cargar') ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="archivo_csv">Seleccionar archivo CSV:</label>
                                <input type="file" class="form-control-file" id="archivo_csv" name="archivo_csv">
                            </div>
                            <button type="submit" class="btn btn-primary">Subir CSV</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

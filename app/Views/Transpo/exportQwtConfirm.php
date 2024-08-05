<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?php
    $columns = [
        "hotel",
        "tipo",
        "folio",
        "item",
        "date",
        "pax",
        "guest",
        "time",
        "flight",
        "airline",
        "pick_up",
    ];
?>

<?= $this->section('content') ?>
    <div class="container mt-4 mb-4">
        <h1 class="mb-4">Exportación de Servicios <small>(Exportar)</small></h1>
        <table class="table table-bordered table-sm table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Hotel</th>
                    <th>Tipo</th>
                    <th>Folio</th>
                    <th>Item</th>
                    <th>Date</th>
                    <th>Pax</th>
                    <th>Guest</th>
                    <th>Time</th>
                    <th>Flight</th>
                    <th>Airline</th>
                    <th>Pick Up</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transportaciones as $transpo): ?>
                    <?php 
                        $hasErrors = false; 
                        $bgalert = "";

                        if( $transpo['date'] != null ){
                            $fecha = new DateTime($transpo['date']); // Reemplaza $tuFecha con la fecha que deseas comparar
                            $hoy = new DateTime(); // Fecha y hora actuales
                            $manana = new DateTime('tomorrow'); // Mañana
    
                            if ($fecha <= $manana) {
                                $bgalert = "bg-warning";
                            }
                        }
                    ?>
                    <tr id="transpo-<?= $transpo['id'] ?>" class="<?= $bgalert ?>">
                        <?php foreach( $columns as $field ): ?>
                            <?php
                                $tdclass = $field == 'date' ? $bgalert : "";
                            ?>
                            <td class="<?= $tdclass ?>"><?= $transpo[$field] ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <div class="container d-flex justify-content-end">
            <button class="btn btn-secondary mr-2" id="goBack">Back <i class="ml-1 fas fa-angle-double-left"></i></button>
            <button class="btn btn-success" id="export">Export <i class="ml-1 fas fa-file-export"></i></button>
        </div>

    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function(){

        console.log(JSON.stringify(<?= json_encode($ids) ?>));

        function startLoader( v = true ){
            if( v ){
                $('#loader').css('display', 'flex');
            }else{
                $('#loader').css('display', 'none');
            }
        }

        $('#goBack').click(function(){
            startLoader();
            window.history.back();
        });

        $('#export').click(function(){  
            startLoader();
            event.preventDefault();
            var url = '<?= site_url('transpo/sendQwtServices/') ?>';
            // Crear un formulario
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = url;

            var hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'ids';
            hiddenField.value = JSON.stringify(<?= json_encode($ids) ?>);
            form.appendChild(hiddenField);

            // Agregar el formulario al cuerpo y enviarlo
            document.body.appendChild(form);
            form.submit();

            // Eliminar el formulario del DOM
            document.body.removeChild(form);
        });

    });
</script>

<?= $this->endSection() ?>


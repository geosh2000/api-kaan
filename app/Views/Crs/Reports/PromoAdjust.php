<?php helper('form'); ?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row flex-row justify-content-center">
        <?php foreach ($reservations as $reservation): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h4 class="m-0">Reserva <strong><?= $reservation->ReservationNumber ?></strong></h4>
                        <span class="text-sm"><?= $reservation->ReservationDate ?></span>
                    </div>
                    <div class="card-body">
                        <div class="reservation-info">
                            <p><strong>Agencia:</strong> <?= $reservation->Agency ?></p>
                            <p><strong>Fechas:</strong> <?= date('d/m/Y', strtotime($reservation->DateFrom)) ?> al <?= date('d/m/Y', strtotime($reservation->DateTo)) ?> (<?= $reservation->Nights ?> noches)</p>
                            <p><strong>Nombre del Cliente:</strong> <?= $reservation->Name ?> <?= $reservation->LastName ?></p>
                            <p><strong>Occ:</strong> <?= $reservation->Adults ?>.<?= $reservation->Children ?>.<?= $reservation->Infants ?></p>
                            <p><strong>Habitación:</strong> <?= $reservation->Habitacion ?> (<?= $reservation->Code ?>)</p>
                            <p style="color: red"><strong>Tarifa Neta:</strong> $<?= $reservation->NetRate ?></p>
                            <p style="color: green"><strong>Tarifa Neta Nueva:</strong> $<?= $reservation->NEWNetRate ?></p>
                        </div>
                        <div class="daily-rates">
                            <h5>Tarifas Diarias</h5>
                            <ul class="list-unstyled">
                                <?php foreach ($reservation->DailyRate as $date => $rate): ?>
                                    <li><?= $date ?>: $<?= $rate ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?php $this->section('filters') ?>
    
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <?= form_open('view/reports/uk', ['class' => 'form']) ?>
                <div class="form-group">
                    <label for="fecha-inicio">Fecha de Inicio</label>
                    <div class="input-group date" id="fecha-inicio-datepicker" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="fecha-inicio" name="fecha-inicio" data-target="#fecha-inicio-datepicker" placeholder="Selecciona una fecha de inicio" autocomplete="off">
                        <div class="input-group-append" data-target="#fecha-inicio-datepicker" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha-fin">Fecha de Fin</label>
                    <div class="input-group date" id="fecha-fin-datepicker" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="fecha-fin" name="fecha-fin" data-target="#fecha-fin-datepicker" placeholder="Selecciona una fecha de fin" autocomplete="off">
                        <div class="input-group-append" data-target="#fecha-fin-datepicker" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Aplicar</button>
            </div>
        <?= form_close() ?>
    </div>
</div>


<!-- Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap Datepicker locales (opcional) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>

<script>
    // Inicializar el plugin Bootstrap Datepicker
    $(document).ready(function () {
        $('#fecha-inicio-datepicker, #fecha-fin-datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            language: 'es' // Opcional, para cambiar el idioma a español
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Inicializar el plugin Bootstrap Datepicker para la fecha de inicio
        $('#fecha-inicio-datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: '2024-04-01', // La fecha de inicio no puede ser anterior a '2024-04-01'
            language: 'es' // Opcional, para cambiar el idioma a español
        });

        // Inicializar el plugin Bootstrap Datepicker para la fecha de fin
        $('#fecha-fin-datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            language: 'es', // Opcional, para cambiar el idioma a español
            startDate: '+0d', // La fecha de inicio de la fecha de fin no puede ser anterior a hoy
            disabled: true // Inicialmente, el campo de fecha de fin está deshabilitado
        });

        // Manejar el evento changeDate de la fecha de inicio
        $('#fecha-inicio-datepicker').on('changeDate', function (e) {
            // Obtener la fecha de inicio seleccionada
            var fechaInicio = new Date(e.date);

            // Actualizar la fecha mínima permitida para la fecha de fin
            $('#fecha-fin-datepicker').datepicker('setStartDate', fechaInicio);

            // Habilitar o deshabilitar el campo de fecha de fin según si la fecha de inicio tiene un valor
            if ($('#fecha-inicio-datepicker').val()) {
                $('#fecha-fin-datepicker').prop('disabled', false);
            } else {
                $('#fecha-fin-datepicker').prop('disabled', true);
            }

            // Limpiar el valor de la fecha de fin si es anterior a la fecha de inicio
            var fechaFin = new Date($('#fecha-fin-datepicker').val());
            if (fechaFin < fechaInicio) {
                $('#fecha-fin-datepicker').val('');
            }
        });

        // Manejar el evento changeDate de la fecha de fin
        $('#fecha-fin-datepicker').on('changeDate', function (e) {
            // Obtener la fecha de fin seleccionada
            var fechaFin = new Date(e.date);

            // Obtener la fecha de inicio seleccionada
            var fechaInicio = new Date($('#fecha-inicio-datepicker').val());

            // Si la fecha de fin es anterior a la fecha de inicio, limpiar el valor
            if (fechaFin < fechaInicio) {
                $('#fecha-fin-datepicker').val('');
            }
        });
    });
</script>



<?= $this->endSection() ?>

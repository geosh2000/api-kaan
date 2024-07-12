<?php
    // Check if 'lang' parameter is set and set default to 'eng' if not
    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'eng';
?>

<?php

if (isset($_GET['d'])) {
    // Decodificar el JSON de base64
    $encodedData = $_GET['d'];
    $jsonData = base64_decode($encodedData);
    
    // Decodificar el JSON en un array asociativo
    $data = json_decode($jsonData, true);
    
    // Verificar si la decodificación fue exitosa y que el JSON sea válido
    if ($data === null) {
        include 'invalid_form.php';
        exit;
    }
}else{
    include 'invalid_form.php';
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($lang === 'esp') ? 'Formulario de Transportación' : 'Transfer Form'; ?></title>
    <link rel="icon" href="<?php echo $data['Hotel'] == "ATELIER" ? "favicon-atelier.png" : "favicon-oleo.ico"; ?>">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.3.0/material.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f5f5f7;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 30px auto;
            max-width: 500px;
        }
        .form-title {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group label {
            font-weight: 500;
        }
        .btn-custom {
            background-color: #007aff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #005bb5;
        }
        .error {
            color: red;
            font-size: 0.875em;
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <div class="form-title">
            <h3><?php echo ($lang === 'esp') ? 'Información de Vuelo' : 'Flight Information'; ?></h3>
        </div>
        <form id="flight-form" action="<?= site_url('public/addTransfer'); ?>" method="post">
            <!-- Guest -->
            <div class="form-group">
                <label for="guest"><?php echo ($lang === 'esp') ? 'Nombre del Huésped:' : 'Guest Name:'; ?></label>
                <input type="text" class="form-control" id="guest" name="guest" value="<?php echo $data["Guest"]; ?>" readonly>
            </div>
            <!-- MAIL -->
            <div class="form-group" hidden>
                <label for="email"><?php echo ($lang === 'esp') ? 'Correo electrónico:' : 'E-mail:'; ?></label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $data["email"]; ?>" readonly>
            </div>
            <!-- Hotel -->
            <div class="form-group">
                <label for="hotel"><?php echo ($lang === 'esp') ? 'Hotel:' : 'Hotel:'; ?></label>
                <input type="text" class="form-control" id="hotel" name="hotel" value="<?php echo $data["Hotel"]; ?>" readonly>
            </div>
            <!-- Folio -->
            <div class="form-group" hidden>
                <label for="folio"><?php echo ($lang === 'esp') ? 'Folio Reserva:' : 'Booking Folio:'; ?></label>
                <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $data["Folio"]; ?>" readonly>
            </div>
            <!-- Folio -->
            <div class="form-group" hidden>
                <input type="text" class="form-control" id="pago" name="pago" value="<?php echo $data["pago"]; ?>" readonly>
            </div>
            <!-- Ticket -->
            <div class="form-group" hidden>
                <label for="tickets"><?php echo ($lang === 'esp') ? 'ID de Ticket:' : 'Ticket ID:'; ?></label>
                <input type="text" class="form-control" id="tickets" name="tickets" value="<?php echo $data["Ticket"]; ?>" readonly>
            </div>
            <!-- Trip Type -->
            <div class="form-group">
                <label for="trip-type"><?php echo ($lang === 'esp') ? 'Tipo de viaje:' : 'Trip type:'; ?></label>
                <select class="form-control" id="trip-type" name="trip-type" required>
                    <option value="round-trip"><?php echo ($lang === 'esp') ? 'Ida y vuelta' : 'Round Trip'; ?></option>
                    <option value="one-way-airport-hotel"><?php echo ($lang === 'esp') ? 'Sólo llegada (aeropuerto-hotel)' : 'One-Way (airport-hotel)'; ?></option>
                    <option value="one-way-hotel-airport"><?php echo ($lang === 'esp') ? 'Sólo ida (hotel-aeropuerto)' : 'One-Way (hotel-airport)'; ?></option>
                </select>
            </div>
            <!-- Phone number -->
            <div class="form-group">
                <label for="phone"><?php echo ($lang === 'esp') ? 'Número de teléfono:' : 'Phone number:'; ?></label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <!-- Pax number -->
            <div class="form-group">
                <label for="pax"><?php echo ($lang === 'esp') ? 'Número de personas:' : 'How many people:'; ?></label>
                <input type="number" class="form-control" id="pax" name="pax" required>
            </div>
            <!-- Arrival details -->
            <div id="arrival-section">
                <hr>
                <h4><?php echo ($lang === 'esp') ? 'Detalles de llegada:' : 'Arrival details:'; ?></h4>
                <div class="form-group">
                    <label for="arrival-date"><?php echo ($lang === 'esp') ? 'Fecha de llegada:' : 'Arrival date:'; ?></label>
                    <input type="date" class="form-control" id="arrival-date"  name="arrival-date" required>
                </div>
                <div class="form-group">
                    <label for="arrival-time"><?php echo ($lang === 'esp') ? 'Hora de llegada del vuelo:' : 'Flight arrival time:'; ?></label>
                    <input type="time" class="form-control" id="arrival-time"  name="arrival-time" required>
                </div>
                <div class="form-group">
                    <label for="arrival-flight-number"><?php echo ($lang === 'esp') ? 'Número de vuelo:' : 'Flight number:'; ?></label>
                    <input type="text" class="form-control" id="arrival-flight-number" name="arrival-flight-number" required>
                </div>
                <div class="form-group">
                    <label for="arrival-airline"><?php echo ($lang === 'esp') ? 'Compañía aérea:' : 'Airline company:'; ?></label>
                    <input type="text" class="form-control" id="arrival-airline"  name="arrival-airline" required>
                </div>
            </div>
            <!-- Departure details -->
            <div id="departure-section">
                <hr>
                <h4><?php echo ($lang === 'esp') ? 'Detalles de salida:' : 'Departure details:'; ?></h4>
                <div class="form-group">
                    <label for="departure-date"><?php echo ($lang === 'esp') ? 'Fecha de salida:' : 'Departure date:'; ?></label>
                    <input type="date" class="form-control" id="departure-date"  name="departure-date" required>
                </div>
                <div class="form-group">
                    <label for="departure-time"><?php echo ($lang === 'esp') ? 'Hora de salida del vuelo:' : 'Flight departure time:'; ?></label>
                    <input type="time" class="form-control" id="departure-time"  name="departure-time" required>
                </div>
                <div class="form-group">
                    <label for="departure-flight-number"><?php echo ($lang === 'esp') ? 'Número de vuelo:' : 'Flight number:'; ?></label>
                    <input type="text" class="form-control" id="departure-flight-number" idnamedeparture-flight-number" required>
                </div>
                <div class="form-group">
                    <label for="departure-airline"><?php echo ($lang === 'esp') ? 'Compañía aérea:' : 'Airline company:'; ?></label>
                    <input type="text" class="form-control" id="departure-airline"  name="departure-airline" required>
                </div>
                <div class="form-group">
                    <label for="pickup-time"><?php echo ($lang === 'esp') ? 'Hora de recogida requerida:' : 'Pick-up time required:'; ?></label>
                    <input type="time" class="form-control" id="pickup-time"  name="pickup-time" required>
                </div>
            </div>
            <div class="error" id="date-error">
                <?php echo ($lang === 'esp') ? 'La fecha de llegada debe ser anterior a la fecha de salida.' : 'Arrival date must be before departure date.'; ?>
            </div>
            <button type="submit" class="btn btn-custom btn-block"><?php echo ($lang === 'esp') ? 'Enviar' : 'Submit'; ?></button>
        </form>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
    $('#trip-type').change(function() {
        var tripType = $(this).val();
        if (tripType === 'round-trip') {
            $('#arrival-section input').prop('required', true);
            $('#departure-section input').prop('required', true);
            $('#arrival-section').show();
            $('#departure-section').show();
        } else if (tripType === 'one-way-airport-hotel') {
            $('#arrival-section input').prop('required', true);
            $('#departure-section input').prop('required', false);
            $('#arrival-section').show();
            $('#departure-section').hide();
        } else if (tripType === 'one-way-hotel-airport') {
            $('#arrival-section input').prop('required', false);
            $('#departure-section input').prop('required', true);
            $('#arrival-section').hide();
            $('#departure-section').show();
        }
    }).change(); // Trigger change event on page load to set the initial state

    $('#flight-form').submit(function(event) {
        var tripType = $('#trip-type').val();
        if (tripType === 'round-trip') {
            var arrivalDate = new Date($('#arrival-date').val());
            var departureDate = new Date($('#departure-date').val());
            if (arrivalDate >= departureDate) {
                $('#date-error').removeClass('d-none');
                event.preventDefault();
            } else {
                $('#date-error').addClass('d-none');
            }
        }
    });
});
</script>
</body>
</html>

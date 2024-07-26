<?= $this->extend('layouts/confirmations/adhHtml') ?>

<?= $this->section('styles') ?>

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 30px auto;
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

        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="form-container">
        <div class="form-title">
            <h3><?php echo ($lang === 'esp') ? 'Información de Vuelo' : 'Flight Information'; ?></h3>
        </div>
        <form id="flight-form" action="<?= site_url('public/addTransfer'); ?>" method="post">
            <!-- Guest -->
            <div class="form-group">
                <label for="guest"><?php echo ($lang === 'esp') ? 'Nombre del Huésped:' : 'Guest Name:'; ?></label>
                <input type="text" class="form-control" id="guest" name="guest" value="<?php echo $data["guest"]; ?>" readonly>
            </div>
            <!-- MAIL -->
            <div class="form-group" hidden>
                <label for="email"><?php echo ($lang === 'esp') ? 'Correo electrónico:' : 'E-mail:'; ?></label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $data["email"]; ?>" readonly>
            </div>
            <!-- Hotel -->
            <div class="form-group">
                <label for="hotel"><?php echo ($lang === 'esp') ? 'Hotel:' : 'Hotel:'; ?></label>
                <input type="text" class="form-control" id="hotel" name="hotel" value="<?php echo $data["hotel"]; ?>" readonly>
            </div>
            <!-- Folio -->
            <div class="form-group" hidden>
                <label for="folio"><?php echo ($lang === 'esp') ? 'Folio Reserva:' : 'Booking Folio:'; ?></label>
                <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $data["folio"]; ?>" readonly>
            </div>
            <!-- Folio -->
             <div class="row">
                <div class="col-8">
                    <div class="form-group" hidden>
                        <input type="text" class="form-control" id="pago" name="pago" value="<?php echo $data["pago"]; ?>" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group" hidden>
                        <input type="text" class="form-control" id="item" name="item" value="<?php echo $data["item"]; ?>" readonly>
                    </div>
                </div>
             </div>
            <!-- Ticket -->
            <div class="form-group" hidden>
                <label for="tickets"><?php echo ($lang === 'esp') ? 'ID de Ticket:' : 'Ticket ID:'; ?></label>
                <input type="text" class="form-control" id="tickets" name="newTicket" value="<?php echo $data["ticket"]; ?>" readonly>
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
                <input type="number" min="1" max="<?= $hotel == 'atpm' ? "6" : "8"  ?>" class="form-control" id="pax" name="pax" required>
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
                    <input type="text" class="form-control" id="departure-flight-number" name="departure-flight-number" required>
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

<!-- Loader -->
<div id="loader" class="loader" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<!-- jQuery and Bootstrap JS -->
   <script>
        $(document).ready(function() {

            function startLoader( v = true ){
                if( v ){
                    $('#loader').css('display', 'flex');
                }else{
                    $('#loader').css('display', 'none');
                }
            }

            $('#flight-form').submit(function(event) {
                    startLoader(true);
            });

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
<?= $this->endSection() ?>


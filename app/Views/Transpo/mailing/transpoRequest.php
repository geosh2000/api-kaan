<?= $this->extend('layouts/confirmations/adh') ?>

<?= $this->section('content') ?>
    <div>
        <div align="left" style="vertical-align:middle;display:inline-block;padding:20px 20px 0px 58px;">
            <img data-imagetype="External" src="<?= base_url('public/images/shuttle-icon.webp') ?>" align="middle" border="0" alt="Confirmada" title="Confirmada" style="display:block;width:49px;text-decoration:none;max-width:49px;border-width:0;border-style:none;"> 
        </div>
        <div style="vertical-align:top;display:inline-block;margin:0;padding:20px 10px 0 10px;border:0 solid transparent;">              
                    <p class="conf-font" style="font-size:14px;line-height:1.2;"><strong><?php if( $lang ): ?>Hola <?= ucwords(strtolower($data['guest'])); ?>, ¡gracias por reservar con nosotros!<?php else: ?>Hi <?= ucwords(strtolower($data['guest'])); ?>, thank you for booking with us!<?php endif; ?></strong></p>           
                    <p class="conf-font" style="font-size:24px;word-break:break-word;line-height:1.5;"><span style="color: rgb(81, 194, 125) !important; font-size: 24px;"><strong><?php if( $lang ): ?>Tu reserva incluye servicio de traslado<?php else: ?>Your reservation includes shuttle service.<?php endif; ?></strong></span></p>    
                    <p class="conf-font" style="font-size:16px;line-height:1.2;"><strong><?php if( $lang ): ?>Número de reserva:<?php else: ?>Reservation number:<?php endif; ?> <?= $data['folio']; ?></strong></p>

        </div>
    </div>

    <hr class="gray-hr">

    <div class="detail-font">
        <p class="conf-margin">
            <?php if( $lang ): ?>
                Uno de los beneficios al reservar en nuestro sitio web oficial con opción de pre-pago es recibir el servicio de transporte gratuito para un máximo de <?php echo ($hotel == 'atpm') ? "6" : "8"; ?> personas en el mismo vehículo 
                <span style="color:cornflowerblue">(servicio proporcionado por una empresa externa; 1 servicio por habitación)</span>
                <br><br>
                A manera de continuar con la reservación del transporte, por favor proporciónanos la información completa de vuelo, dando click en el siguiente botón para llenar el formulario:
            <?php else: ?>
                One of the benefits of booking on our official website with the pre-payment option is receiving free transportation service for up to 6 people in the same vehicle 
                <span style="color:cornflowerblue">(service provided by an external company; 1 service per room)</span>
                <br><br>
                In order to proceed with the reservation, please provide complete flight information by clicking the button below:
            <?php endif; ?></p>

    </div>

    <hr class="gray-hr">

    <div class="detail-font" style="text-align: center" id="botonFormulario">
        <a 
            href="<?= site_url('public/transfer-reg')."?lang=$lang&d=$token"; ?>" target="_blank"
            style="background-color: #4CAF50; color: white; padding: 15px 20px; border: none; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">
            <?php if( $lang ): ?>
                Llenar Formulario
            <?php else: ?>
                Fill Form
            <?php endif; ?>
        </a>
    </div>

    <hr class="gray-hr">


    <div class="detail-font" style="padding: 25px;">

        <p class="conf-margin">
            <?php if( $lang ): ?>
                Debido a las reparaciones actuales en la carretera al aeropuerto, sugerimos que tu recogida desde el hotel al aeropuerto el día de tu partida se programe con 4 horas de anticipación a la hora de tu vuelo. 
            <?php else: ?>
                According with the current road repairs to the airport, we suggest your pick-up from the hotel to the airport on your departure day scheduled 4 hours in advance of your flight time.
            <?php endif; ?>
        </p><br>
        <p class="conf-margin">
            <strong>
                <?php if( $lang ): ?>
                    Para programar tu servicio sin ningún contratiempo, debemos recibir la información completa al menos 3 días antes del día de tu llegada.
                <?php else: ?>
                    To schedule your service without any issues, we need to receive the complete information at least 3 days before your arrival date.
                <?php endif; ?>
            </strong>
        </p>
    </div>
<?= $this->endSection() ?>
    
    
    
                            
    
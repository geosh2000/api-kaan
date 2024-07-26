<?php 
    $lang = ($_GET['lang'] ?? 'esp') == 'esp';
    $hotel = strtolower($_GET['hotel'] ?? 'atpm');
?>
<style>
    .conf-font{ font-family:Arial,Helvetica Neue,Helvetica,sans-serif;margin:0; }
    .detail-font{ color: rgb(85, 85, 85) !important; font-size: 12px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; margin: 0px; padding: 0px 10px; line-height: 1.2; }
    .gray-hr {
        border: none;
        height: 1px;
        background-color: #dddddd;
        margin-top: 40px;
        margin-bottom: 40px;
    }
    .conf-margin{ margin:0;line-height:1.5; }
    .conf-value{ margin:0;padding:0 10px 0 10px;vertical-align:top;display:inline-block;text-align: left; width: 430px; }
    .conf-label{ margin:0;width: 215px;vertical-align:top;display:inline-block;text-align: left; }
</style>

<div style="margin: 0 auto; width: 720px;transform: scale(0.85625, 0.85625);transform-origin: left top;">
    <div style="background-color: black !important; margin: 0px; padding: 15px;">
        <div align="left" style="margin:0;padding:0 10px 0 20px;">
            <img data-imagetype="External" src="https://glassboardengine.azurewebsites.net//assets/img/<?php echo $hotel == 'atpm' ? 'logo' : 'logoOleo' ; ?>.png" border="0" alt="Texto alternativo" title="Texto alternativo" style="display:block;width:105px;text-decoration:none;max-width:105px;border-width:0;border-style:none;"> 
        </div>
    
    </div>
    
    
    <div>
        <div align="left" style="vertical-align:middle;display:inline-block;padding:20px 20px 0px 58px;">
            <img data-imagetype="External" src="shuttle-icon.webp" align="middle" border="0" alt="Confirmada" title="Confirmada" style="display:block;width:49px;text-decoration:none;max-width:49px;border-width:0;border-style:none;"> 
        </div>
        <div style="vertical-align:top;display:inline-block;margin:0;padding:20px 10px 0 10px;border:0 solid transparent;">              
                    <p class="conf-font" style="font-size:14px;line-height:1.2;"><strong><?php if( $lang ): ?>Hola ${main_guest}, ¡gracias por reservar en ${rsv_channel}<?php else: ?>Hi ${main_guest}, thank you for booking at ${rsv_channel}<?php endif; ?></strong></p>           
                    <p class="conf-font" style="font-size:24px;word-break:break-word;line-height:1.5;"><span style="color: rgb(81, 194, 125) !important; font-size: 24px;"><strong><?php if( $lang ): ?>Su reserva incluye servicio de traslado<?php else: ?>Your reservation includes shuttle service.<?php endif; ?></strong></span></p>    
                    <p class="conf-font" style="font-size:16px;line-height:1.2;"><strong><?php if( $lang ): ?>Número de reserva:<?php else: ?>Reservation number:<?php endif; ?> ${conf_number}</strong></p>
    
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
        <a style="background-color: #4CAF50; color: white; padding: 15px 20px; border: none; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">
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
    
    <hr class="gray-hr">
    
    <div class="detail-font" style="padding: 25px;background-color: rgb(242, 242, 242) !important;">
        <p class="conf-margin"><?php if( $lang ): ?>¿NECESITA ASISTENCIA? LLAME A NUESTROS NÚMEROS GRATUITOS<?php else: ?>DO YOU NEED ASSISTANCE? CALL OUR TOLL-FREE NUMBERS<?php endif; ?></p>
        <p class="conf-margin"><strong>México: (800) 062 8899</strong></p>
        <p class="conf-margin"><strong><?php if( $lang ): ?>EE. UU.<?php else: ?>USA<?php endif; ?>: 1 (888) 5858 234</strong></p>
        <p class="conf-margin"><strong><?php if( $lang ): ?>Resto del Mundo<?php else: ?>Rest of the world<?php endif; ?>: +52 (998) 271 6304</strong></p>
        
    </div>
    
    <br>
    
    <div class="detail-font">
        <p style="font-size:10px;text-align:center;margin:0;line-height:1.5;"><span style="font-size:10px;">ATELIER de Hoteles SA de CV</span></p>
        <p style="font-size:10px;text-align:center;margin:0;line-height:1.5;">
            <span style="font-size:10px;">
                <a href="https://atelierdehoteles.com<?php if( $lang ): ?>.mx/aviso-de-privacidad<?php else: ?>/privacy-policy<?php endif; ?>" target="_blank"  style="color: rgb(85, 85, 85) !important; text-decoration: underline;" title="" data-linkindex="0"><?php if( $lang ): ?>Política de privacidad<?php else: ?>Privacy Policy<?php endif; ?></a>
            </span>
        </p>    
    </div>
    
</div>  
    
    
                            
    
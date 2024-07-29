<?= $this->extend('layouts/confirmations/adh') ?>

<?= $this->section('content') ?>
    <div>
        <div align="left" style="vertical-align:middle;display:inline-block;padding:20px 20px 0px 58px;">
            <img data-imagetype="External" src="<?= base_url('public/images/shuttle-icon.webp') ?>" align="middle" border="0" alt="Confirmada" title="Confirmada" style="display:block;width:49px;text-decoration:none;max-width:49px;border-width:0;border-style:none;"> 
        </div>
        <div style="vertical-align:top;display:inline-block;margin:0;padding:20px 10px 0 10px;border:0 solid transparent;">              
                    <p class="conf-font" style="font-size:14px;line-height:1.2;"><strong><?php if( $lang ): ?>Hola <?= ucwords(strtolower($data['guest'])); ?>, ¡gracias por reservar con nosotros!<?php else: ?>Hi <?= ucwords(strtolower($data['guest'])); ?>, thank you for booking with us!<?php endif; ?></strong></p>           
                    <?php if( $data['isIncluida'] == "1" ): ?>
                        <p class="conf-font" style="font-size:24px;word-break:break-word;line-height:1.5;"><span style="color: rgb(81, 194, 125) !important; font-size: 24px;"><strong><?php if( $lang ): ?>Tu reserva incluye servicio de traslado<?php else: ?>Your reservation includes shuttle service.<?php endif; ?></strong></span></p>    
                    <?php else: ?>
                        <p class="conf-font" style="font-size:24px;word-break:break-word;line-height:1.5;"><span style="color: rgb(81, 194, 125) !important; font-size: 24px;"><strong><?php if( $lang ): ?>Estás a un paso de completar tu reserva de traslado.<?php else: ?>You're one step away from completing your transfer reservation.<?php endif; ?></strong></span></p>    
                    <?php endif; ?>
                    <p class="conf-font" style="font-size:16px;line-height:1.2;"><strong><?php if( $lang ): ?>Número de reserva:<?php else: ?>Reservation number:<?php endif; ?> <?= $data['folio']; ?></strong></p>

        </div>
    </div>

    <hr class="gray-hr">

        <!-- CON PAGO -->
        <div class="detail-font">
            <p class="conf-margin">
                <?php if( $lang ): ?>
                    <p>Para completar tu pago, por favor da clic en el siguiente vínculo seguro:</p>
                <?php else: ?>
                    <p>In order to complete your payment, please click on the following secure link:</p>
                <?php endif; ?></p>

        </div>


    <hr class="gray-hr">

    <div class="detail-font" style="text-align: center" id="botonFormulario">
        <a 
            href="<?= $link ?>" target="_blank"
            style="background-color: #4CAF50; color: white; padding: 15px 20px; border: none; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">
            <?php if( $lang ): ?>
                Realizar Pago
            <?php else: ?>
                Complete Payment
            <?php endif; ?>
        </a>
    </div>

    <hr class="gray-hr">


    <div class="detail-font" style="padding: 25px;">

        <p class="conf-margin">
            <?php if( $lang ): ?>
                Una vez completado el pago, recibirás la confirmación por correo electrónico. <strong>Recuérda que la fecha límite para completar tu pago es 3 días antes de tu llegada</strong>
            <?php else: ?>
                Once you complete your payment, you'll recieve your confirmation via email. <strong>Remember that the deadline to complete your payment is 3 days before your arrival.</strong>
            <?php endif; ?>
        </p><br>
    </div>
<?= $this->endSection() ?>
    
    
    
                            
    
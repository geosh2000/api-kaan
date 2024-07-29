<?= $this->extend('layouts/confirmations/adh') ?>

<?= $this->section('content') ?>
    <div>
        <div align="left" style="vertical-align:middle;display:inline-block;padding:20px 20px 0px 58px;">
            <img data-imagetype="External" src="<?= base_url('public/images/shuttle-icon.webp') ?>" align="middle" border="0" alt="Confirmada" title="Confirmada" style="display:block;width:49px;text-decoration:none;max-width:49px;border-width:0;border-style:none;"> 
        </div>
        <div style="vertical-align:top;display:inline-block;margin:0;padding:20px 10px 0 10px;border:0 solid transparent;">              
                    <p class="conf-font" style="font-size:14px;line-height:1.2;"><strong><?php if( $lang ): ?>Hola <?= ucwords(strtolower($data['guest'])); ?>, ¡gracias por reservar con nosotros!<?php else: ?>Hi <?= ucwords(strtolower($data['guest'])); ?>, thank you for booking with us!<?php endif; ?></strong></p>           
                    <p class="conf-font" style="font-size:24px;word-break:break-word;line-height:1.5;"><span style="color: rgb(81, 194, 125) !important; font-size: 24px;"><strong><?php if( $lang ): ?>Tu reserva se está procesando<?php else: ?>Your reservation is being processed<?php endif; ?></strong></span></p>    
                    <p class="conf-font" style="font-size:16px;line-height:1.2;"><strong><?php if( $lang ): ?>Número de reserva:<?php else: ?>Reservation number:<?php endif; ?> <?= $data['folio']; ?></strong></p>

        </div>
    </div>

    <hr class="gray-hr">


        <div class="detail-font">
            <p class="conf-margin">
                <?php if( $lang ): ?>
                    <p>Hemos recibido tus datos y estamos procesando tu reserva. En las próximas 24 horas recibirás un correo con los pasos a seguir</p>
                <?php else: ?>
                    <p>We have received your information and are processing your reservation. Within the next 24 hours, you will receive an email with the next steps.</p>
                <?php endif; ?></p>

        </div>


<?= $this->endSection() ?>
    
    
    
                            
    
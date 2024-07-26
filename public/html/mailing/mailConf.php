<?php 
    $lang = ($_GET['lang'] ?? 'esp') == 'esp';
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
            <img data-imagetype="External" src="${logo_url}" border="0" alt="Texto alternativo" title="Texto alternativo" style="display:block;width:105px;text-decoration:none;max-width:105px;border-width:0;border-style:none;"> 
        </div>
    
    </div>
    
    
    <div>
        <div align="left" style="vertical-align:middle;display:inline-block;padding:20px 20px 0px 58px;">
            <img data-imagetype="External" src="https://glassboardengine.azurewebsites.net/assets/img/okok.png" align="middle" border="0" alt="Confirmada" title="Confirmada" style="display:block;width:49px;text-decoration:none;max-width:49px;border-width:0;border-style:none;"> 
        </div>
        <div style="vertical-align:top;display:inline-block;margin:0;padding:20px 10px 0 10px;border:0 solid transparent;">              
                    <p class="conf-font" style="font-size:14px;line-height:1.2;"><strong><?php if( $lang ): ?>Hola ${main_guest}, ¡gracias por reservar en ${rsv_channel}<?php else: ?>Hi ${main_guest}, thank you for booking at ${rsv_channel}<?php endif; ?></strong></p>           
                    <p class="conf-font" style="font-size:24px;word-break:break-word;line-height:1.5;"><span style="color: rgb(81, 194, 125) !important; font-size: 24px;"><strong><?php if( $lang ): ?>Su reserva está confirmada<?php else: ?>Your reservation is confirmed<?php endif; ?></strong></span></p>    
                    <p class="conf-font" style="font-size:16px;line-height:1.2;"><strong><?php if( $lang ): ?>Número de reserva:<?php else: ?>Reservation number:<?php endif; ?> ${conf_number}</strong></p>
    
        </div>
    </div>
    
    <hr class="gray-hr">
    
    <div class="detail-font">
        <p style="margin:0;line-height:1.2;"><strong>${hotel_name}</strong> <?php if( $lang ): ?>lo espera el<?php else: ?>awaits you on<?php endif; ?> ${date_in}</p>
        <p style="margin:0;line-height:1.2;" aria-hidden="true">&nbsp;</p>
        <p style="margin:0;line-height:1.2;"><strong><?php if( $lang ): ?>DETALLES DE LA RESERVA:<?php else: ?>RESERVATION DETAILS:<?php endif; ?></strong></p>
        <br>
        <div align="left" style="margin:0;width: 230px;vertical-align:top;display:inline-block;text-align: left;">
            <p class="conf-margin"><?php if( $lang ): ?>ENTRADA:<?php else: ?>CHECK IN:<?php endif; ?></p>
            <p class="conf-margin"><?php if( $lang ): ?>SALIDA:<?php else: ?>CHECK OUT:<?php endif; ?></p>
        </div>
        <div align="left" class="conf-value">
            <p class="conf-margin"><strong>${date_in}</strong> (${time_in} hrs)</p>
            <p class="conf-margin"><strong>${date_out}</strong> (${time_out} hrs)</p>
        </div>
    </div>
    
    <hr class="gray-hr">
    
    <div class="detail-font">
        <div align="left" style="margin:0;width: 230px;vertical-align:top;display:inline-block;text-align: left;">
            <p class="conf-margin"><?php if( $lang ): ?>DIRECCIÓN<?php else: ?>ADDRESS<?php endif; ?>:</p>
        </div>
        <div align="left" class="conf-value">
            <p class="conf-margin"><strong>${dir_1}</strong></p>
            <p class="conf-margin"><strong>${dir_2}</strong></p>        
            <p class="conf-margin"><strong>${dir_3}</strong></p>        
            <p class="conf-margin"><strong>${dir_4}</strong></p>
        </div>
    </div>
    
    <hr class="gray-hr">
    
    <div class="detail-font">
        <div align="left" style="margin:0;width: 230px;vertical-align:top;display:inline-block;text-align: left;">
            <p class="conf-margin"><?php if( $lang ): ?>TITULAR<?php else: ?>HOLDER<?php endif; ?>:</p>
        </div>
        <div align="left" class="conf-value">
            <p class="conf-margin"><strong>${main_guest}</strong></p>
        </div>
    </div>
    <br>
    
    <div class="detail-font" style="padding: 25px;background-color: rgb(242, 242, 242) !important;">
    
        <!-- BLOQUE DE LA SUITE -->
            <div align="left" class="conf-label">
                <!-- ROOM TYPE START -->
                <p class="conf-margin"><?php if( $lang ): ?>SUITE 1<?php else: ?>SUITE 1<?php endif; ?>:</p>
                <!-- ROOM TYPE END -->
                <p class="conf-margin"><?php if( $lang ): ?>HUÉSPEDES<?php else: ?>GUESTS<?php endif; ?>:</p>
                <p class="conf-margin"><?php if( $lang ): ?>TIPO DE TARIFA<?php else: ?>RATE TYPE<?php endif; ?>:</p>
                <p class="conf-margin"><?php if( $lang ): ?>NOMBRE<?php else: ?>NAME<?php endif; ?>:</p>
                <!-- AMOUNT START -->
                <p class="conf-margin"><?php if( $lang ): ?>TIPO DE PAGO<?php else: ?>PAYMENT TYPE<?php endif; ?>:</p>
                    <p class="conf-margin"><?php if( $lang ): ?>MONTO TOTAL<?php else: ?>TOTAL AMOUNT<?php endif; ?>:</p>
                    <!-- BALANCE START -->
                    <p class="conf-margin" style="color:rgb(81, 194, 125)"><?php if( $lang ): ?>DEPOSITO PAGADO<?php else: ?>DEPOSIT PAID<?php endif; ?>:</p>
                    <p class="conf-margin" style="color:rgb(207, 0, 0)"><?php if( $lang ): ?>SALDO RESTANTE<?php else: ?>REMAINING BALANCE<?php endif; ?>:</p>
                    <!-- BALANCE END -->
                <!-- AMOUNT END -->

            </div>
            <div align="left" class="conf-value">
                <!-- ROOM TYPE START -->
                <p class="conf-margin"><strong>${room_code} - ${room_name}</strong></p>
                <!-- ROOM TYPE END -->
                <p class="conf-margin"><strong><?php if( $lang ): ?>${adults} Adultos ${children} Niños<?php else: ?>${adults} Adults ${children} Children<?php endif; ?></strong></p>
                <p class="conf-margin"><strong>${rate_type}</strong></p>
                <p class="conf-margin"><strong>${main_guest}</strong></p>
                <!-- AMOUNT START -->
                <p class="conf-margin"><strong>${payment_type}</strong></p>
                    <p class="conf-margin"><strong>$ ${total} ${currency}</strong></p>
                    <!-- BALANCE START -->
                    <p class="conf-margin" style="color:rgb(81, 194, 125)"><strong>$ ${deposit} ${currency}</strong></p>
                    <p class="conf-margin" style="color:rgb(207, 0, 0)"><strong>$ ${balance} ${currency}</strong></p>
                    <!-- BALANCE END -->
                <!-- AMOUNT END -->
            </div>
        <!-- FIN DEL BLOQUE DE LA SUITE -->
    
        <br>
    
        <div align="left" class="conf-label">
            <p class="conf-margin"><?php if( $lang ): ?>NOTAS<?php else: ?>NOTES<?php endif; ?>:</p>
        </div>
        <div align="left" class="conf-value">
            <p class="conf-margin"><strong>${notes}</strong></p>
        </div>
    
        <br>
    
        <div align="left" class="conf-label">
            <p class="conf-margin"><?php if( $lang ): ?>POLÍTICA DE CANCELACIÓN<?php else: ?>CANCELLATION POLICY<?php endif; ?>:</p>
        </div>
        <div align="left"  class="conf-value">
            <p class="conf-margin"><strong>${xld_policy}</strong></p>
        </div>

        <br><br>
        <span style="font-style: italic; color:rgb(50, 52, 54)">
            <?php if( $lang ): ?>
                Tarifa en esta reservación no incluye impuesto local de saneamiento ambiental de ${isa}, que deberá ser pagado en su registro en el hotel. Este monto puede cambiar al momento de tu llegada y está regulado por el gobierno del Estado de Quintana Roo.
            <?php else: ?>
                The rate for this reservation does not include the local environmental sanitation tax of ${isa}, which must be paid upon check-in at the hotel. This amount may change upon your arrival and is regulated by the government of the State of Quintana Roo.
            <?php endif; ?>
        </span>
    
    </div>
    
    
    <!-- DEPOSITOS START -->
    <hr>

    <div class="detail-font" style="padding: 25px;background-color: rgb(219, 196, 119) !important; color: black;">
        <p>
            <?php if( $lang ): ?>
                Para pagos por depósito o transferencia bancaria, se proporcionamos las siguiente cuentas. Es de suma importancia que indique como referencia  el número de su reserva.
            <?php else: ?>
                For payments by deposit or bank transfer, we provide the following accounts. It is crucial that you indicate your reservation number as the reference.
            <?php endif; ?>
        <p style="font-style: italic; color: red">
            <?php if( $lang ): ?>
                Una vez realizado el depósito o la transferencia, es necesario enviarnos la imagen del recibo a este mismo correo para poder registrarlo correctamente en su reserva. En caso de no recibir este recibo, el pago no se verá reflejado.
            <?php else: ?>
                Once the deposit or transfer has been made, it is necessary to send us the image of the receipt to this same email to correctly register it in your reservation. If we do not receive this receipt, the payment will not be reflected.
            <?php endif; ?>
        </p>
    </div>
    <!-- DEP ATPM START -->
    <div class="detail-font" style="padding: 25px;background-color: rgb(242, 242, 242) !important;">
        <h3 class="conf-margin"><?php if( $lang ): ?>CUENTA DE DEPÓSITO EN PESOS MEXICANOS<?php else: ?>MEXICAN PESOS DEPOSIT ACCOUNT<?php endif; ?>:</h3><br>
        <div align="left" class="conf-label">
            <p class="conf-margin"><?php if( $lang ): ?>BANCO<?php else: ?>BANK<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>CUENTA<?php else: ?>ACCOUNT<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>CLABE<?php else: ?>CLABE<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>BENEFICIARIO<?php else: ?>BENEFICIARY<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>RFC<?php else: ?>RFC<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>DIRECCIÓN<?php else: ?>ADDRESS<?php endif; ?>:</p>
        </div>
        <div align="left" class="conf-value">
            <p class="conf-margin"><strong>BANORTE (Banco Mercantil del Norte)</strong></p>
            <p class="conf-margin"><strong>1013686722</strong></p>
            <p class="conf-margin"><strong>072 691 010 136 867 227</strong></p>
            <p class="conf-margin"><strong>GUC HOTELES, SA DE CV</strong></p>
            <p class="conf-margin"><strong>AVH-161104-JQ0</strong></p>
            <p class="conf-margin"><strong>Av. Bonampak SM10 M2 L7 Cancún, Quintana Roo CP 77500</strong></p>
        </div>
    </div>

    <br>

    <div class="detail-font" style="padding: 25px;background-color: rgb(242, 242, 242) !important;">
        <h3 class="conf-margin"><?php if( $lang ): ?>CUENTA DE DEPÓSITO EN DÓLARES AMERICANOS<?php else: ?>US DOLLAR DEPOSIT ACCOUNT<?php endif; ?>:</h3><br>
        <div align="left" class="conf-label">
            <p class="conf-margin"><?php if( $lang ): ?>BANCO<?php else: ?>BANK<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>CUENTA<?php else: ?>ACCOUNT<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>CLABE<?php else: ?>CLABE<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>SWIFT/BIC<?php else: ?>SWIFT/BIC<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>DIRECCIÓN DEL BANCO<?php else: ?>BANK ADDRESS<?php endif; ?>:</p><br>
            <p class="conf-margin"><?php if( $lang ): ?>BENEFICIARIO<?php else: ?>BENEFICIARY<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>RFC<?php else: ?>RFC<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>DIRECCIÓN<?php else: ?>ADDRESS<?php endif; ?>:</p>
        </div>
        <div align="left" class="conf-value">
            <p class="conf-margin"><strong>BANORTE (Banco Mercantil del Norte)</strong></p>
            <p class="conf-margin"><strong>1013693391</strong></p>
            <p class="conf-margin"><strong>072 691 010 136 933 915</strong></p>
            <p class="conf-margin"><strong>MENOMXMTXXX</strong></p>
            <p class="conf-margin"><strong>Av. Tulum esq. Calle Viento 2717 SM4</strong></p>
            <p class="conf-margin"><strong>Cancún, Quintana Roo CP 77500</strong></p>
            <p class="conf-margin"><strong>GUC HOTELES, SA DE CV</strong></p>
            <p class="conf-margin"><strong>AVH-161104-JQ0</strong></p>
            <p class="conf-margin"><strong>Av. Bonampak SM10 M2 L7 Cancún, Quintana Roo CP 77500</strong></p>
        </div>
    </div>
    <!-- DEP ATPM END -->
    <!-- DEP OLCP START -->
    <div class="detail-font" style="padding: 25px;background-color: rgb(242, 242, 242) !important;">
        <h3 class="conf-margin"><?php if( $lang ): ?>CUENTA DE DEPÓSITO EN PESOS MEXICANOS<?php else: ?>MEXICAN PESOS DEPOSIT ACCOUNT<?php endif; ?>:</h3><br>
        <div align="left" class="conf-label">
            <p class="conf-margin"><?php if( $lang ): ?>BANCO<?php else: ?>BANK<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>CUENTA<?php else: ?>ACCOUNT<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>CLABE<?php else: ?>CLABE<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>BENEFICIARIO<?php else: ?>BENEFICIARY<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>RFC<?php else: ?>RFC<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>DIRECCIÓN<?php else: ?>ADDRESS<?php endif; ?>:</p>
        </div>
        <div align="left" class="conf-value">
            <p class="conf-margin"><strong>BANORTE (Banco Mercantil del Norte)</strong></p>
            <p class="conf-margin"><strong>0424379799</strong></p>
            <p class="conf-margin"><strong>072 691 004 243 797 995</strong></p>
            <p class="conf-margin"><strong>NAZZARENO HOLDINGS SA DE CV</strong></p>
            <p class="conf-margin"><strong>NHO-080526-LA3</strong></p>
            <p class="conf-margin"><strong>Blvd. Kukulkan ZT MZ55 L66 Ofic-1 Sec A Torre B, Zona Hotelera Cancún, Quintana Roo CP 77500</strong></p>
        </div>
    </div>

    <br>

    <div class="detail-font" style="padding: 25px;background-color: rgb(242, 242, 242) !important;">
        <h3 class="conf-margin"><?php if( $lang ): ?>CUENTA DE DEPÓSITO EN DÓLARES AMERICANOS<?php else: ?>US DOLLAR DEPOSIT ACCOUNT<?php endif; ?>:</h3><br>
        <div align="left" class="conf-label">
            <p class="conf-margin"><?php if( $lang ): ?>BANCO<?php else: ?>BANK<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>CUENTA<?php else: ?>ACCOUNT<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>CLABE<?php else: ?>CLABE<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>SWIFT/BIC<?php else: ?>SWIFT/BIC<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>DIRECCIÓN DEL BANCO<?php else: ?>BANK ADDRESS<?php endif; ?>:</p><br>
            <p class="conf-margin"><?php if( $lang ): ?>BENEFICIARIO<?php else: ?>BENEFICIARY<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>RFC<?php else: ?>RFC<?php endif; ?>:</p>
            <p class="conf-margin"><?php if( $lang ): ?>DIRECCIÓN<?php else: ?>ADDRESS<?php endif; ?>:</p>
        </div>
        <div align="left" class="conf-value">
            <p class="conf-margin"><strong>BANORTE (Banco Mercantil del Norte)</strong></p>
            <p class="conf-margin"><strong>0427374861</strong></p>
            <p class="conf-margin"><strong>072 691 004 273 748 613</strong></p>
            <p class="conf-margin"><strong>MENOMXMTXXX</strong></p>
            <p class="conf-margin"><strong>Blvd. Kukulkan ZT MZ55 L66 Ofic-1 Sec A Torre B, Zona Hotelera Cancún, Quintana Roo CP 77500</strong></p>
            <p class="conf-margin"><strong>NAZZARENO HOLDINGS SA DE CV</strong></p>
            <p class="conf-margin"><strong>NHO-080526-LA3</strong></p>
            <p class="conf-margin"><strong>3304 Flamingos</strong></p>
        </div>
    </div>
    <!-- DEP OLCP END -->

    
    <!-- DEPOSITOS END -->
    <hr>
    
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
    
    
                            
    
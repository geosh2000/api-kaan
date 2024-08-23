// Declarar zdToken previo a la carga de este js: var zdToken = '<?= $token ?>';
// Declarar zdSiteUrl previo a la carga de este js: var zdSiteUrl = '<?= site_url() ?>';
// Declarar zdQs previo a la carga de este js: var zdQs = '<?= $qs ?>';

class zdFields {

    static categoria    = 'ticket.customField:custom_field_26495291237524';
    static reserva      = 'ticket.customField:custom_field_26260741418644';
    static guest        = 'ticket.customField:custom_field_26260771754900';
    static status       = 'ticket.customField:custom_field_28774341519636';
    static hotel        = 'ticket.customField:custom_field_26493544435220';
    static tipoTranspo  = 'ticket.customField:custom_field_28630449017748';
    static transpoPago  = 'ticket.customField:custom_field_28630467255444';
    static transpoStatus= 'ticket.customField:custom_field_28774341519636';
    static transpoDefined= 'ticket.customField:custom_field_28802239047828';
    static idIda        = 'ticket.customField:custom_field_28837284664596';
    static idVuelta     = 'ticket.customField:custom_field_28837240808724';
    static ligaPago     = 'ticket.customField:custom_field_28727761630100';

}

class GlobalVar {
    constructor() {
        this.id = '';
        this.name = '';
        this.lang = '';
        this.reqId = '';
        this.ticketId = '';
    }

    setVal(key, val) {
        this[key] = val;
    }
}

class htmlTemplates {    
    static searchCrs = `<div class="mb-2 d-flex justify-content-end"><button class="btn btn-primary" id="extendedSearch">Extender a CRS</button></div>`;

    static status = {
        "-": '',
        "INCLUIDA": 'btn-incluNoData',
        "INCLUIDA (SOLICITADO)": 'btn-incluSolicitado',
        "SOLICITADO": 'btn-incluSolicitado',
        "LIGA PENDIENTE": 'btn-ligaPendiente',
        "PAGO PENDIENTE": 'btn-pagoPendiente',
        "CORTESÍA (CAPTURA PENDIENTE)": 'btn-pagadoSinIngresar',
        "PAGO EN DESTINO (CAPTURA PENDIENTE)": 'btn-pagadoSinIngresar',
        "PAGADA (CAPTURA PENDIENTE)": 'btn-pagadoSinIngresar',
        "CORTESÍA (CAPTURADO)": 'btn-pagadoRegistradoAtpm',
        "PAGO EN DESTINO (CAPTURADO)": 'btn-pagadoRegistradoAtpm',
        "PAGADA (CAPTURADO)": 'btn-pagadoRegistradoAtpm',
        "CANCELADA": 'btn-cancel',
    }
}

var client = ZAFClient.init();


function linkApp( url ){
    
    // Crear un formulario dinámico
    var form = $('<form>', {
        'method': 'POST',
        'action': zdSiteUrl + url + '?' + zdQs
    });

    // Agregar el campo de token al formulario
    $('<input>', {
        'type': 'hidden',
        'name': 'token',
        'value': zdToken
    }).appendTo(form);

    // Agregar el formulario al cuerpo y enviarlo
    form.appendTo('body').submit();
}

function formRedirect( form ){
    switch( form ){
        case (26597917087124):      // Transportacion
            linkApp( '/zdapp/transpo' );
            break;
        case (26261410445076):      // Confirmacion
            linkApp( '/zdapp/conf' );
            break;
        default:
            console.log("Sin app para redireccionar");
            return;
    }
}

function setUser( user ){
    const userDiv = document.getElementById('$user');
    userDiv.innerHTML = user;
}

$(document).ready(function () {


    // Cambio de modulo de acuerdo a formulario
    client.on('ticket.form.id.changed', function(eventData) {
        console.log('El campo ha cambiado:', eventData);
    
        formRedirect( eventData );
    });

});
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
?>

<?= $this->extend('Layouts/Zendesk/main') ?>

<?php
// Arreglo de hoteles
    $hoteles = array(
        array('value' => '1', 'label' => 'Atelier Playa Mujeres'),
        array('value' => '5', 'label' => 'Oleo Cancún Playa')
    );

    // Arreglo de idiomas
    $idiomas = array(
        array('value' => 'ESP', 'label' => 'Español'),
        array('value' => 'ENG', 'label' => 'Inglés')
    );

    // Arreglo de monedas
    $monedas = array(
        array('value' => 'MXN', 'label' => 'MXN'),
        array('value' => 'USD', 'label' => 'USD')
    );

    // Inicializamos las variables
    $hotel = isset($_GET['hotel']) ? $_GET['hotel'] : '';
    $idioma = isset($_GET['idioma']) ? $_GET['idioma'] : '';
    $moneda = isset($_GET['moneda']) ? $_GET['moneda'] : '';
    
    $mapHotel = array(
            'MXN' => array(
                    '1' => 2,
                    '5' => 6
                ),
            'USD' => array(
                    '1' => 1,
                    '5' => 5
                )
        );
    
    if( $hotel == '' ){
        $url = "https://atelier-cc.azurewebsites.net/public/blank.html";
    }else{
        $url = "https://reserve.atelierdehoteles.com/?language=$idioma&amp;currency=$moneda&amp;hotel=".($mapHotel[$moneda][$hotel])."&amp;frameshow=1&amp;companysource=callcenter";
    }

?>

<?= $this->section('styles') ?>
body {
      margin: 0;
      padding: 0;
    }
    #toolbar {
      background-color: #00000080;
      padding: 5px;
      color: white;
      position: relative; 
      border-radius: 10px;
    }
    #filtro-cintillo {
      background-color: #f1dea3; 
      color: #212529; 
      padding: 5px;
      border-radius: 10px;
    }
    iframe {
      width: 100%;
      height: calc(100vh - 180px);
      border: none;
      border-radius: 10px;
    }
    .error {
      border-color: red !important;
      border: 1px solid red;
    }
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="toolbar">
        <div class="">
            <div class="row">
                <div class="col">
                    <form class="form-inline" id="filter-form" onsubmit="updateFilters(); return false;">
                        <div class="d-flex justify-content-between">
                        <select name="hotel" class="rounded-pill form-control" required>
                                    <option value="" selected disabled>Hotel</option>
                                    <?php foreach ($hoteles as $option): ?>
                                    <option value="<?php echo $option['value']; ?>" <?php if ($hotel == $option['value']) echo 'selected'; ?>><?php echo $option['label']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                        
                        <select name="idioma" class="rounded-pill ml-1 form-control" required>
                                    <option value="" selected disabled>Idioma</option>
                                    <?php foreach ($idiomas as $option): ?>
                                    <option value="<?php echo $option['value']; ?>" <?php if ($idioma == $option['value']) echo 'selected'; ?>><?php echo $option['label']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                        
                        <select name="moneda" class="rounded-pill ml-1 form-control" required>
                                    <option value="" selected disabled>Moneda</option>
                                    <?php foreach ($monedas as $option): ?>
                                    <option value="<?php echo $option['value']; ?>" <?php if ($moneda == $option['value']) echo 'selected'; ?>><?php echo $option['label']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                        
                            </form>
                        <button class="rounded-pill mr-1 ml-2 btn btn-success" type="submit">Aplicar</button>
                    
                    <!-- Example single danger button -->
                    <div class="ml-auto btn-group dropleft" >
                    <button type="button" id="drop-codes" class="rounded-pill btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false" disabled>
                        Codigos
                    </button>
                    <div class="dropdown-menu" id='discountMenu'>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                    </div>           
                </div>
            </div>
        </div>
        
    </div>
    <div id="filtro-cintillo" class="mt-1 mb-1">
       Hotel: <span class='badge bg-success' id="sel-hotel">
        <?php 
        foreach ($hoteles as $option) {
            if ($option['value'] == $hotel) {
                echo $option['label'];
                break;
            }
        } ?>                           
        </span> / Idioma: <span class='badge bg-success' id="sel-idioma">
        <?php 
        foreach ($hoteles as $option) {
            if ($option['value'] == $hotel) {
                echo $option['label'];
                break;
            }
        } ?>
        </span> / Moneda: <span class='badge bg-success' id="sel-moneda">
        <?php 
        foreach ($monedas as $option) {
            if ($option['value'] == $moneda) {
                echo $option['label'];
                break;
            }
        } ?>
        </span>
    </div>

    <iframe src="<?php echo $url; ?>" frameborder="0"></iframe>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>

    $(document).ready(function () {

        const appTitle = document.getElementById('appTitle');
        appTitle.innerHTML = "GG - ADH Cotizador";

        $(document).on('click', '.copy', function( event ){
            var target = event.target;
            var codigo = target.getAttribute('value');
            copyToClipboard(codigo);
        })

    });

    var mapHotel = {
        'MXN': {
            '1': 2,
            '5': 6
        },
        'USD': {
            '1': 1,
            '5': 5
        }
    };


    var codes = <?= json_encode($codes) ?>;

    document.addEventListener('click', function(event) {
        // Verificar si el clic ocurrió en un elemento con la clase "dropdown-item"
        if (event.target.classList.contains('dropdown-item')) {
            // Obtener el valor del atributo "value"
            var value = event.target.getAttribute('value');

            // Copiar el valor al portapapeles
            navigator.clipboard.writeText(value).then(function() {
                console.log('Valor copiado al portapapeles: ' + value);
                // Aquí puedes agregar cualquier otro código que desees ejecutar después de copiar el valor al portapapeles
            }, function(err) {
                console.error('Error al copiar el valor al portapapeles: ', err);
            });
        }
    });
    
    document.addEventListener('click', function(event) {
        // Verificar si el clic ocurrió en un elemento con la clase "dropdown-item"
        if (event.target.classList.contains('dropdown-item')) {
            // Obtener el valor del atributo "value"
            var value = event.target.getAttribute('value');

            copyToClipboard(value);
        }
    });

    function copyToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;

        // Añadir el textarea al DOM
        document.body.appendChild(textArea);

        // Seleccionar y copiar el texto
        textArea.select();
        document.execCommand("copy");

        // Remover el textarea del DOM
        document.body.removeChild(textArea);
    }


    function updateFilters() {

        var hotelSelect = document.getElementsByName('hotel')[0];
        var idiomaSelect = document.getElementsByName('idioma')[0];
        var monedaSelect = document.getElementsByName('moneda')[0];
  
        var hotel = hotelSelect.value;
        var idioma = idiomaSelect.value;
        var moneda = monedaSelect.value;

        if (!hotel) {
            hotelSelect.classList.add('error');
            return;
        }
        if (!idioma) {
            idiomaSelect.classList.add('error');
            return;
        }
        if (!moneda) {
            monedaSelect.classList.add('error');
            return;
        }

        hotelSelect.classList.remove('error');
        idiomaSelect.classList.remove('error');
        monedaSelect.classList.remove('error');

        // Obtener el texto del label del select de hotel
        var hotelLabel = hotelSelect.options[hotelSelect.selectedIndex].text;

        // Obtener el código del hotel correspondiente a la moneda seleccionada
        var codigoHotel = mapHotel[moneda][hotel];

        var nuevaURL = "https://reserve.atelierdehoteles.com/?language=" + idioma + "&currency=" + moneda + "&hotel=" + codigoHotel + "&frameshow=1&companysource=callcenter";

        // Actualizar los elementos HTML con los valores seleccionados
        document.getElementById('sel-hotel').innerHTML = hotelLabel;
        document.getElementById('sel-moneda').innerHTML = moneda;
        document.getElementById('sel-idioma').innerHTML = idioma;

        // Actualizar la URL del iframe
        document.querySelector('iframe').src = nuevaURL;

        // Habilitar el botón de códigos
        document.getElementById('drop-codes').removeAttribute('disabled');

        // Obtener el objeto de códigos correspondiente al código del hotel
        var codigoHotelObj = codes[codigoHotel];

        // Construir dinámicamente el HTML para los elementos del menú desplegable
        var dropdownHTML = '';

        for (var key in codigoHotelObj) {
            if (codigoHotelObj.hasOwnProperty(key)) {
                dropdownHTML += '<a class="dropdown-item copy" href="#" value="' + codigoHotelObj[key].code + '">' +  key + ' (' + codigoHotelObj[key].descuento + ')</a>';
            }
        }

        // Actualizar el innerHTML del dropdown-menu con el HTML construido
        $('#discountMenu').html(dropdownHTML);

    }
</script>
<?= $this->endSection() ?>
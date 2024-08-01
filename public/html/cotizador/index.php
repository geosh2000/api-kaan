<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

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

    // Arreglo de Codigos
    $codes = array(
        "2" => array(
            "Comisionable 2%" => array('code' => 'AZFX9659', 'descuento' => '2%'),
            "F&F" => array('code' => 'XCIC3760', 'descuento' => '25%'),
            "Presidencia" => array('code' => 'TUDY0334', 'descuento' => '50%'),
            "Mayorista" => array('code' => 'KLSN8423', 'descuento' => '32%'),
            "Arteleros" => array('code' => 'DIVN9478', 'descuento' => '32%'),
        ),
        "1" => array(
            "Comisionable 2%" => array('code' => 'QOCE9721', 'descuento' => '2%'),
            "OB OJV" => array('code' => 'FRLB5898', 'descuento' => '25%'),
            "OB ALG" => array('code' => 'YVMG6841', 'descuento' => '25%'),
            "OB Classic Vacations" => array('code' => 'HKPX5241', 'descuento' => '25%'),
            "OB Flight Centre" => array('code' => 'JTJH7087', 'descuento' => '25%'),
            "OB Island Destinations" => array('code' => 'JSIR6396', 'descuento' => '25%'),
            "OB Pleasant Holidays" => array('code' => 'JYMZ6720', 'descuento' => '25%'),
            "OB Sunwing" => array('code' => 'KIXM2353', 'descuento' => '25%'),
            "OB Vacation Express" => array('code' => 'UMQM0291', 'descuento' => '25%'),
            "F&F" => array('code' => 'BYVO9717', 'descuento' => '25%'),
            "Presidencia" => array('code' => 'OTFP0601', 'descuento' => '50%'),
            "Mayorista" => array('code' => 'DZCI8644', 'descuento' => '32%'),
            "Agente 15" => array('code' => 'DIVN9478', 'descuento' => '15%')
        ),
        "6" => array(
            "Comisionable 2%" => array('code' => 'DQHR5943', 'descuento' => '2%'),
            "F&F" => array('code' => 'KZHQ1884', 'descuento' => '25%'),
            "Presidencia" => array('code' => 'QCMV4515', 'descuento' => '50%'),
            "Arteleros" => array('code' => 'JYCH5994', 'descuento' => '32%'),
        ),
        "5" => array(
            "Comisionable 2%" => array('code' => 'ANPO1819', 'descuento' => '2%'),
            "F&F" => array('code' => 'HPYW9855', 'descuento' => '25%'),
            "Presidencia" => array('code' => 'YVZX8605', 'descuento' => '50%'),
        )
    );
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cotizador ADH - Contact Center</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <style>
    body {
      margin: 0;
      padding: 0;
    }
    #toolbar {
      background-color: #00000080;
      padding: 5px;
      color: white;
      position: relative; 
    }
    #filtro-cintillo {
      background-color: #ffc107; 
      color: #212529; 
      padding: 5px;
      position: absolute; 
      bottom: 0;
      left: 0; 
      right: 0; 
    }
    iframe {
      width: 100%;
      height: calc(100vh - 106px);
      border: none;
    }
    .error {
      border-color: red !important;
      border: 1px solid red;
    }
  </style>
</head>
<body>
    <div id="toolbar">
        <div class="">
            <div class="row">
                <div class="col" style="height: 75px">
                    <div class="d-flex justify-content-between">
                    <form class="form-inline" id="filter-form" onsubmit="updateFilters(); return false;">
                        <select name="hotel" class="form-control" required>
                                    <option value="" selected disabled>Selecciona Hotel</option>
                                    <?php foreach ($hoteles as $option): ?>
                                    <option value="<?php echo $option['value']; ?>" <?php if ($hotel == $option['value']) echo 'selected'; ?>><?php echo $option['label']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                        
                        <select name="idioma" class="ml-1 form-control" required>
                                    <option value="" selected disabled>Selecciona Idioma</option>
                                    <?php foreach ($idiomas as $option): ?>
                                    <option value="<?php echo $option['value']; ?>" <?php if ($idioma == $option['value']) echo 'selected'; ?>><?php echo $option['label']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                        
                        <select name="moneda" class="ml-1 form-control" required>
                                    <option value="" selected disabled>Selecciona Moneda</option>
                                    <?php foreach ($monedas as $option): ?>
                                    <option value="<?php echo $option['value']; ?>" <?php if ($moneda == $option['value']) echo 'selected'; ?>><?php echo $option['label']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                        
                        <button class="ml-2 btn btn-success" type="submit">Aplicar</button>
                    </form>
                    
                    <!-- Example single danger button -->
                    <div class="ml-auto btn-group dropleft" >
                    <button type="button" id="drop-codes" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false" disabled>
                        Codigos
                    </button>
                    <div class="dropdown-menu">
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
    <div id="filtro-cintillo">
        Filtro seleccionado: Hotel: <span class='badge bg-success' id="sel-hotel">
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
  </div>

  
   <iframe src="<?php echo $url; ?>" frameborder="0"></iframe>

   <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script>

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


    var codes = {
        "2": {
            "Agentes 15%": { 'code': 'VAXO1823', 'descuento': '15%' },
            "Arteleros": { 'code': 'DIVN9478', 'descuento': '32%' },
            "Comisionable 2%": { 'code': 'AZFX9659', 'descuento': '2%' },
            "F&F": { 'code': 'SQCZ8412', 'descuento': '25%' },
            "Mayorista": { 'code': 'KLSN8423', 'descuento': '32%' },
            "Presidencia": { 'code': 'TUDY0334', 'descuento': '50%' },
        },
        "1": {
            "Comisionable 2%": { 'code': 'QOCE9721', 'descuento': '2%' },
            "OB OJV": { 'code': 'FRLB5898', 'descuento': '25%' },
            "OB ALG": { 'code': 'YVMG6841', 'descuento': '25%' },
            "OB Classic Vacations": { 'code': 'HKPX5241', 'descuento': '25%' },
            "OB Flight Centre": { 'code': 'JTJH7087', 'descuento': '25%' },
            "OB Island Destinations": { 'code': 'JSIR6396', 'descuento': '25%' },
            "OB Pleasant Holidays": { 'code': 'JYMZ6720', 'descuento': '25%' },
            "OB Sunwing": { 'code': 'KIXM2353', 'descuento': '25%' },
            "OB Vacation Express": { 'code': 'UMQM0291', 'descuento': '25%' },
            "F&F": { 'code': 'VDZX1597', 'descuento': '25%' },
            "Presidencia": { 'code': 'OTFP0601', 'descuento': '50%' },
            "Mayorista": { 'code': 'DZCI8644', 'descuento': '32%' },
            "Agente 15": { 'code': 'RHYM1928', 'descuento': '15%' }
        },
        "6": {
            "Comisionable 2%": { 'code': 'DQHR5943', 'descuento': '2%' },
            "F&F": { 'code': 'MBSE3616', 'descuento': '25%' },
            "Presidencia": { 'code': 'QCMV4515', 'descuento': '50%' },
            "Arteleros": { 'code': 'JYCH5994', 'descuento': '32%' },
        },
        "5": {
            "Comisionable 2%": { 'code': 'ANPO1819', 'descuento': '2%' },
            "F&F": { 'code': 'UNSG5106', 'descuento': '25%' },
            "Presidencia": { 'code': 'YVZX8605', 'descuento': '50%' },
        }
    };

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
            dropdownHTML += '<a class="dropdown-item" href="#" value="' + codigoHotelObj[key].code + '">' + key + ': ' + codigoHotelObj[key].code + ' - Descuento: ' + codigoHotelObj[key].descuento + '</a>';
        }
        }

        // Actualizar el innerHTML del dropdown-menu con el HTML construido
        var dropdownMenu = document.querySelector('.dropdown-menu');
        dropdownMenu.innerHTML = dropdownHTML;

        // Agregar un manejador de eventos de clic para cada <a> para copiar el código al portapapeles
        var dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            var codigo = event.target.getAttribute('value');
            // Copiar el código al portapapeles
            navigator.clipboard.writeText(codigo).then(function() {
            console.log('Código copiado al portapapeles: ' + codigo);
            }, function(err) {
            console.error('Error al copiar el código al portapapeles: ', err);
            });
        });
        });

        // Actualizar el innerHTML del dropdown-menu con el HTML construido
        document.querySelector('.dropdown-menu').innerHTML = dropdownHTML;
    }
  </script>
</body>
</html>



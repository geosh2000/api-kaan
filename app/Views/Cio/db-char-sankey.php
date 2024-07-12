<!-- CARGA LAYOUT DEL DASHBOARD DE CIO -->
<?= $this->extend('layouts/cio-dashboard') ?>

<!-- CONTENIDO PRINCIPAL -->
<?= $this->section('content') ?>

<style>
    .mainWindow {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 58px);
    }

    .quote {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }

    #legend {
        background-color: rgba(255, 255, 255, 0.7); /* Fondo semi-transparente blanco */
        border-radius: 5px; /* Bordes redondeados */
        padding: 10px; /* Espaciado interno */
        
        z-index: 1000; /* Coloca la leyenda sobre el gráfico */
        font-family: Arial, sans-serif; /* Fuente */
    }
</style>

<div class="mainWindow">
    <div class="container">
        <!-- <h2><small>(<?= $params['inicio'] ?> a <?= $params['fin'] ?>)</small></h2> -->
        <span><small>(Last Update: <?= $lastUpdate ?>)</small></span>
    </div>
    
    
    <!-- CHARTS -->
    <div class="container" id="charts">
       <div id="myChart1" style="width: 100%; height: 600px;"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    // Data provided
    const dataDb = <?= json_encode($data) ?>;
    const title = <?= json_encode($title) ?>;

  google.charts.load("current", {packages:["sankey"]});
  google.charts.setOnLoadCallback(drawChart);
   function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Desde');
    data.addColumn('string', 'Hacia');
    data.addColumn('number', 'Llamadas');
    data.addRows(dataDb);

    var colors = ["#1f77b4", // Azul
    "#ff7f0e", // Naranja
    "#2ca02c", // Verde
    "#d62728", // Rojo
    "#9467bd", // Morado
    "#8c564b", // Marrón
    "#e377c2", // Rosa
    "#7f7f7f", // Gris
    "#bcbd22", // Amarillo
    "#17becf", // Turquesa
    "#aec7e8", // Azul claro
    "#ffbb78", // Naranja claro
    "#98df8a", // Verde claro
    "#ff9896"  // Rojo claro
    ];

    // Set chart options
    var options = {
      sankey: {
        node: {
          colors: colors
        },
        link: {
          colorMode: 'gradient',
          colors: colors,
          color: { stroke: 'gray', strokeWidth: 0.5}
        }
      }
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.Sankey(document.getElementById('myChart1'));
    chart.draw(data, options);
   }
</script>
<?= $this->endSection() ?>
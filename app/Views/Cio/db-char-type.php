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
        position: absolute;
        right: 20px;
        top: 20px;
    }

    /* Estilo para los cuadros de color en la leyenda */
    .legend-color {
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;
    }
</style>

<div class="mainWindow">
    <div class="container">
        <!-- <h2><small>(<?= $params['inicio'] ?> a <?= $params['fin'] ?>)</small></h2> -->
        <span><small>(Last Update: <?= $lastUpdate ?>)</small></span>
    </div>
    
    <!-- CHARTS -->

    <div class="container d-flex justify-content-around" id="charts" style="position: relative; float: left;">
      <div class="container d-flex justify-content-around" id="charts" style="position: relative; float: left;">
        <canvas id="myChart1" width="400" height="600"></canvas>
      </div>
      <div class="container d-flex justify-content-around" id="charts" style="position: relative; float: left;">
        <div id="legend" class="ms-5"></div> <!-- Agregamos la leyenda aquí -->
      </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data provided
const type = <?= json_encode($type) ?>;
const title = <?= json_encode($title) ?>;

// Extracting data for the chart
const typelabels = type.map(entry => entry.Field);
const typeData = type.map(entry => entry.val);

// Creating the chart
const typeDiv = document.getElementById('myChart1').getContext('2d');

const typesChart = new Chart(typeDiv, {
  type: 'doughnut',
  data: {
      labels: typelabels, // Etiquetas para cada segmento
      datasets: [
        {
          label: 'Calls',
          data: typeData,
          backgroundColor: Chart.defaults.color.backgroundColor // Obtener los colores predeterminados de Chart.js
        }
      ]
    },
  options: {
    maintainAspectRatio: false,
    responsive: true,
    plugins: {
      legend: {
        display: false, // Ocultar leyenda predeterminada
      },
      title: {
        display: true,
        text: title
      },
      labels: {
        render: 'label', // Mostrar etiquetas sobre los segmentos
        fontColor: '#000', // Color del texto
        fontSize: 12, // Tamaño del texto
        fontStyle: 'bold', // Estilo del texto
        display: true, // Mostrar las etiquetas siempre
        position: 'outside' // Posición de las etiquetas (dentro o fuera del gráfico)
      }
    },
    tooltips: {
        callbacks: {
            label: function(tooltipItem, data) {
                let label = data.labels[tooltipItem.index] || '';
                let value = data.datasets[0].data[tooltipItem.index];

                if (label) {
                    label += ': ';
                }
                label += value + ' (' + ((value / data.datasets[0].data.reduce((a, b) => a + b, 0)) * 100).toFixed(2) + '%)';
                return label;
            }
        }
    }
  }
});

// Función para mostrar la leyenda personalizada
function showCustomLegend(chart) {
    const legend = document.getElementById('legend');
    const data = chart.data.datasets[0].data;
    const labels = chart.data.labels;
    const colors = chart.data.datasets[0].backgroundColor;

    let html = '<ul>';
    for (let i = 0; i < data.length; i++) {
        // Agregar cuadros de color a la izquierda de cada concepto en la leyenda
        html += `<li><span class="legend-color" style="background-color: ${colors[i]}"></span>${labels[i]}: ${data[i]} (${(100 * data[i] / data.reduce((a, b) => a + b, 0)).toFixed(2)}%)</li>`;
        console.log(data.reduce((a, b) => a + b,0));
    }
    html += '</ul>';
    legend.innerHTML = html;
}

// Mostrar la leyenda personalizada cuando se carga la página
showCustomLegend(typesChart);

</script>

<?= $this->endSection() ?>

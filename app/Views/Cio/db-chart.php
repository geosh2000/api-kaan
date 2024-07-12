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

    .card-deck {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        margin: 20px 0;
    }

    .card {
        width: 22%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
    }

    .card-text {
        font-size: 2rem;
        font-weight: bold;
        text-align: center;
    }

    .card-text small {
        display: block;
        font-size: 1rem;
        font-weight: normal;
    }
</style>

<div class="mainWindow">
    <div class="container mb-5">
        <h2><?= implode(",", $params['queue']) ?> <small>(<?= $params['inicio'] ?> a <?= $params['fin'] ?>)</small></h2>
        <span><small>(Last Update: <?= $lastUpdate ?>)</small></span>
    </div>

    <!-- Tarjetas -->
    <div class="card-deck">
      <div class="card">
        <div class="card-body">
            <h5 class="card-title">Llamadas</h5>
            <p class="text-center" style="font-size: 1.5rem; font-weight: bold;">
                <?= $totals['totalLlamadas'] ?>
            </p>
            <div class="d-flex">
                <div class="me-4">
                    <small class="text-muted">Ans: <?= $totals['Answered'] ?></small><br>
                    <small class="text-muted">Early: <?= $totals['EarlyAbandon'] ?></small><br>
                </div>
                <div class="">
                    <small class="text-muted">Abn: <?= $totals['Abandon'] ?></small><br>
                    <small class="text-muted">Tfr: <?= $totals['Transferida'] ?></small><br>
                </div>
            </div>
        </div>
    </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">SLA</h5>
                    <p class="card-text"><?= $totals['sla'] ?>%</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">AHT</h5>
                    <p class="card-text"><?= $totals['AHT'] ?> seg.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Abandon</h5>
                    <p class="card-text"><?= round(($totals['Abandon'] / ($totals['Transferida'] + $totals['Answered'])) * 100, 2) ?>%</p>
                </div>
            </div>
        </div>
    
    
    <!-- CHARTS -->
    <div class="container" id="charts">
        <div class="row">
            <div class="col-md-6">
                <canvas id="myChart1" width="400" height="250"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="myChart2" width="400" height="250"></canvas>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <canvas id="myChart3" width="400" height="250"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="myChart4" width="400" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data provided
    const data = <?= json_encode($data) ?>;

    // Extracting data for the chart
    const labels = data.map(entry => entry.Fecha);
    const answeredData = data.map(entry => entry.Answered);
    const abandonData = data.map(entry => entry.Abandon);
    const earlyAbandonData = data.map(entry => entry.EarlyAbandon);
    const fdhData = data.map(entry => entry.FDH);
    const transferidaData = data.map(entry => entry.Transferida);
    const slaData = data.map(entry => entry.sla);
    const ahtData = data.map(entry => entry.AHT);
    const asaData = data.map(entry => entry.ASA);
    const abandon_Data = data.map(entry => entry.Abandon_);

    // Creating the chart
    const ctx = document.getElementById('myChart1').getContext('2d');
    const sla = document.getElementById('myChart3').getContext('2d');
    const aht = document.getElementById('myChart2').getContext('2d');
    // const asa = document.getElementById('myChart4').getContext('2d');
    const abandon = document.getElementById('myChart4').getContext('2d');
    
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Answered',
            data: answeredData,
            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue
          },
          {
            label: 'Abandon',
            data: abandonData,
            backgroundColor: 'rgba(255, 99, 132, 0.5)', // Red
          },
          {
            label: 'Early Abandon',
            data: earlyAbandonData,
            backgroundColor: 'rgba(255, 206, 86, 0.5)', // Yellow
          },
          {
            label: 'FDH',
            data: fdhData,
            backgroundColor: 'rgba(75, 192, 192, 0.5)', // Green
          },
          {
            label: 'Transferida',
            data: transferidaData,
            backgroundColor: 'rgba(153, 102, 255, 0.5)', // Purple
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          x: {
            stacked: true
          },
          y: {
            stacked: true
          }
        }
      }
    });

    // SLA Graph
    const slaChart = new Chart(sla, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'SLA',
            data: slaData,
            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue
          },
            {
                label: 'Meta',
                data: Array(slaData.length).fill(80), // Crea un array con valores de 0.8
                borderColor: 'rgba(255, 0, 0, 0.5)', // Red
                borderDash: [5, 5] // Define un estilo de línea punteada
            }
        ]
      },
      options: {
        maintainAspectRatio: false
      }
    });

    // AHT Graph
    const ahtChart = new Chart(aht, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Average Handling Time',
            data: ahtData,
            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue
          }
        ]
      },
      options: {
        maintainAspectRatio: false
      }
    });

    // ASA Graph
    // const asaChart = new Chart(asa, {
    //   type: 'line',
    //   data: {
    //     labels: labels,
    //     datasets: [
    //       {
    //         label: 'Average Speed of Answer',
    //         data: asaData,
    //         backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue
    //       },
    //         {
    //             label: 'Meta',
    //             data: Array(slaData.length).fill(20), // Crea un array con valores de 0.8
    //             borderColor: 'rgba(255, 0, 0, 0.5)', // Red
    //             borderDash: [5, 5] // Define un estilo de línea punteada
    //         }
    //     ]
    //   },
    //   options: {
    //     maintainAspectRatio: false
    //   }
    // });

    // Abandon Graph
    const abandon_Chart = new Chart(abandon, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Abandon',
            data: abandon_Data,
            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue
          },
            {
                label: 'Meta',
                data: Array(slaData.length).fill(6), // Crea un array con valores de 0.8
                borderColor: 'rgba(255, 0, 0, 0.5)', // Red
                borderDash: [5, 5] // Define un estilo de línea punteada
            }
        ]
      },
      options: {
        maintainAspectRatio: false
      }
    });
</script>
<?= $this->endSection() ?>
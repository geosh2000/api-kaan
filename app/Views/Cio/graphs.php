<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gráfica de Columnas Animada</title>
  <!-- Importar Chart.js desde CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Bootstrap CSS para estilos -->
  <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1 class="text-center mt-5">Gráfica de Columnas Animada</h1>
    <div class="row mt-5">
      <div class="col">
        <!-- Canvas para la gráfica -->
        <canvas id="graficaColumnas" width="400" height="400"></canvas>
      </div>
    </div>
  </div>

  <!-- Script para generar la gráfica -->
  <script>
    var data = <?= json_encode($data) ?>;

    // Configuración de la gráfica
    var config = {
      type: 'bar',
      data: data,
      options: {
        animation: {
          duration: 1000, // Duración de la animación en milisegundos
          easing: 'easeOutQuart' // Función de aceleración de la animación
        },
        scales: {
          y: {
            beginAtZero: true // Empezar eje y en 0
          }
        }
      }
    };

    // Crear instancia de Chart.js y renderizar la gráfica
    var myChart = new Chart(
      document.getElementById('graficaColumnas'),
      config
    );
  </script>
</body>
</html>

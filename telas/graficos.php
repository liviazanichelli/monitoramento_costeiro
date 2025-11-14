<?php
include '../config.php';   
include '../header.php';   
?>

<h2 style="margin:20px 0;">Gráfico do Nível da Maré</h2>


<div style="text-align:center; margin-bottom:20px;">
    <a href="?dias=7" style="margin:0 10px;">Últimos 7 dias</a>
    <a href="?dias=14" style="margin:0 10px;">Últimos 14 dias</a>
    <a href="?dias=30" style="margin:0 10px;">Últimos 30 dias</a>
</div>

<canvas id="graficoMare" width="1000" height="400" style="max-width:95%; margin:auto; display:block;"></canvas>

<?php
// Recebe o período pelo GET (7, 14 ou 30 dias), padrão 7
$dias = isset($_GET['dias']) ? intval($_GET['dias']) : 7;

// Consulta os dados do banco
$query = "SELECT data_hora, nivel_mare FROM medicoes 
          WHERE data_hora >= NOW() - INTERVAL $dias DAY
          ORDER BY data_hora ASC";
$result = $conn->query($query);

$datas = [];
$mares = [];

while($row = $result->fetch_assoc()){
    $datas[] = date('d/m H:i', strtotime($row['data_hora']));
    $mares[] = $row['nivel_mare'];
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoMare').getContext('2d');
const graficoMare = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($datas); ?>,
        datasets: [{
            label: 'Nível da Maré (m)',
            data: <?php echo json_encode($mares); ?>,
            backgroundColor: 'rgba(0, 123, 255, 0.2)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3,
            pointRadius: 3,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true, position: 'top' },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            x: {
                display: true,
                title: { display: true, text: 'Data/Hora' }
            },
            y: {
                display: true,
                title: { display: true, text: 'Altura (m)' }
            }
        }
    }
});
</script>


<?php
include '../config.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=relatorio.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Data/Hora', 'Altura da Onda (m)', 'Velocidade do Vento (km/h)', 'Nível da Maré (m)']);

$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 7;
$wherePeriodo = ($periodo > 0) ? "WHERE data_hora >= NOW() - INTERVAL $periodo DAY" : "";

$query = "SELECT data_hora, altura_onda, velocidade_vento, nivel_mare FROM medicoes $wherePeriodo ORDER BY data_hora ASC";
$result = $conn->query($query);

while($row = $result->fetch_assoc()){
    fputcsv($output, [$row['data_hora'], $row['altura_onda'], $row['velocidade_vento'], $row['nivel_mare']]);
}

fclose($output);
exit;

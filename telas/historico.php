<?php
include '../config.php';
include '../header.php';
?>

<h2 style="margin:20px 0; text-align:center;">Histórico</h2>


<div style="text-align:center; margin-bottom:20px;">
    <a href="?periodo=7" style="margin:0 10px; padding:8px 15px; background:#0b4560; color:#fff; border-radius:5px; text-decoration:none;">Últimos 7 dias</a>
    <a href="?periodo=30" style="margin:0 10px; padding:8px 15px; background:#0b4560; color:#fff; border-radius:5px; text-decoration:none;">Últimos 30 dias</a>
    <a href="?periodo=0" style="margin:0 10px; padding:8px 15px; background:#0b4560; color:#fff; border-radius:5px; text-decoration:none;">Todos</a>
</div>

<?php

$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 7;
$wherePeriodo = ($periodo > 0) ? "WHERE data_hora >= NOW() - INTERVAL $periodo DAY" : "";


$query = "SELECT data_hora, altura_onda, velocidade_vento, nivel_mare
          FROM medicoes
          $wherePeriodo
          ORDER BY data_hora DESC";
$result = $conn->query($query);

if($result->num_rows > 0){
    echo '<table style="width:90%; margin:auto; border-collapse:collapse;">';
    echo '<thead>
            <tr style="background:#0b4560; color:#fff;">
                <th style="padding:8px;">Data/Hora</th>
                <th style="padding:8px;">Altura da Onda (m)</th>
                <th style="padding:8px;">Velocidade do Vento (km/h)</th>
                <th style="padding:8px;">Nível da Maré (m)</th>
            </tr>
          </thead><tbody>';

    while($row = $result->fetch_assoc()){
        
        $bg = '#f9f9f9';
        static $alt = true;
        $alt = !$alt;
        if(!$alt) $bg='#e7f4fb';

        echo "<tr style='background:$bg;'>
                <td style='padding:8px;'>{$row['data_hora']}</td>
                <td style='padding:8px;'>{$row['altura_onda']}</td>
                <td style='padding:8px;'>{$row['velocidade_vento']}</td>
                <td style='padding:8px;'>{$row['nivel_mare']}</td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo '<p style="text-align:center; margin-top:20px;">Nenhuma medição registrada neste período.</p>';
}
?>

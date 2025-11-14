<?php
include '../config.php';
include '../header.php';
?>

<main style="padding:40px 20px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#eef3f8; min-height:90vh;">

    <h2 style="text-align:center; font-size:42px; color:#0b4560; margin-bottom:25px; letter-spacing:0.5px; text-shadow:1px 1px 2px rgba(0,0,0,0.15);">
         Alertas de Eventos Extremos
    </h2>

    
    <div style="text-align:center; margin-bottom:35px;">
        <?php
        $periodos = [7=>'Últimos 7 dias', 30=>'Últimos 30 dias', 0=>'Todos'];
        foreach($periodos as $valor=>$texto){
            $ativo = (isset($_GET['periodo']) && $_GET['periodo']==$valor) || (!isset($_GET['periodo']) && $valor==7);
            $styleAtivo = $ativo ? "background:#0b4560; color:white; transform:scale(1.05); box-shadow:0 6px 15px rgba(0,0,0,.2);" : "background:white; color:#0b4560; border:2px solid #0b4560;";
            echo "<a href='?periodo=$valor' 
                    style='margin:0 10px; padding:10px 22px; border-radius:30px; text-decoration:none; font-weight:bold; transition:0.3s; $styleAtivo'
                    onmouseover=\"this.style.transform='scale(1.07)';\" 
                    onmouseout=\"this.style.transform='$ativo?scale(1.05):scale(1)'\">$texto</a>";
        }
        ?>
    </div>

<?php
$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 7;
$wherePeriodo = ($periodo > 0) ? "WHERE data_hora >= NOW() - INTERVAL $periodo DAY" : "";

$query = "SELECT data_hora, altura_onda, velocidade_vento, nivel_mare
          FROM medicoes
          $wherePeriodo
          ORDER BY data_hora DESC";
$result = $conn->query($query);

$alertas = [];
$contagem = ['Maré Alta'=>0, 'Vento Forte'=>0, 'Onda Gigante'=>0];

while($row = $result->fetch_assoc()){
    if($row['nivel_mare'] > 2){
        $alertas[] = ['data_hora'=>$row['data_hora'], 'tipo_alerta'=>'Maré Alta', 'descricao'=>"Nível da maré {$row['nivel_mare']} m"];
        $contagem['Maré Alta']++;
    }
    if($row['velocidade_vento'] > 50){
        $alertas[] = ['data_hora'=>$row['data_hora'], 'tipo_alerta'=>'Vento Forte', 'descricao'=>"Velocidade do vento {$row['velocidade_vento']} km/h"];
        $contagem['Vento Forte']++;
    }
    if($row['altura_onda'] > 2){
        $alertas[] = ['data_hora'=>$row['data_hora'], 'tipo_alerta'=>'Onda Gigante', 'descricao'=>"Altura da onda {$row['altura_onda']} m"];
        $contagem['Onda Gigante']++;
    }
}
?>


<div style="display:flex; flex-wrap:wrap; justify-content:center; gap:25px; margin-bottom:45px;">
    <?php
    $cards = [
        'Maré Alta' => ['grad' => 'linear-gradient(135deg,#ff6b6b,#ffb3b3)', 'icone'=>'🌊'],
        'Vento Forte' => ['grad' => 'linear-gradient(135deg,#ffb84d,#ffe0b3)', 'icone'=>'💨'],
        'Onda Gigante' => ['grad' => 'linear-gradient(135deg,#4da6ff,#cce0ff)', 'icone'=>'🌊']
    ];

    foreach($cards as $tipo => $style){
        echo "<div style='
                background:{$style['grad']};
                color:#222;
                padding:25px 35px;
                border-radius:20px;
                width:220px;
                text-align:center;
                box-shadow:0 8px 25px rgba(0,0,0,0.15);
                transition:all 0.3s ease;'>
                <div style='font-size:36px;'>{$style['icone']}</div>
                <h3 style='font-size:22px; margin:8px 0 6px 0;'>$tipo</h3>
                <p style='font-size:32px; font-weight:bold; margin:0;'>{$contagem[$tipo]}</p>
                <p style='font-size:14px; opacity:0.8;'>alertas detectados</p>
              </div>";
    }
    ?>
</div>


<?php
if(count($alertas) > 0){
    echo '<div style="overflow-x:auto; max-width:1000px; margin:auto; background:#fff; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,.1); padding:25px;">';
    echo '<table style="width:100%; border-collapse:collapse; border-radius:10px; overflow:hidden;">';
    echo '<thead>
            <tr style="background:#0b4560; color:#fff;">
                <th style="padding:14px 10px; text-align:left;">Data/Hora</th>
                <th style="padding:14px 10px; text-align:left;">Tipo de Alerta</th>
                <th style="padding:14px 10px; text-align:left;">Descrição</th>
            </tr>
          </thead><tbody>';
    $i=0;
    foreach($alertas as $a){
        $bg = ($i%2==0) ? "#fdfdfd" : "#f3f6fa";
        if($a['tipo_alerta']=="Maré Alta") $bg="#ffe6e6";
        elseif($a['tipo_alerta']=="Vento Forte") $bg="#fff4e0";
        elseif($a['tipo_alerta']=="Onda Gigante") $bg="#e6f2ff";

        echo "<tr style='background:$bg; transition:0.3s;'>
                <td style='padding:12px; color:#333;'>{$a['data_hora']}</td>
                <td style='padding:12px; font-weight:bold; color:#0b4560;'>{$a['tipo_alerta']}</td>
                <td style='padding:12px; color:#555;'>{$a['descricao']}</td>
              </tr>";
        $i++;
    }
    echo '</tbody></table></div>';
}else{
    echo '<p style="text-align:center; margin-top:30px; font-size:18px; color:#555;">Nenhum alerta detectado neste período.</p>';
}
?>
</main>



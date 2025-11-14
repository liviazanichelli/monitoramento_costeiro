<?php
include '../config.php';
include '../header.php';


$query = "SELECT 
AVG(altura_onda) AS onda, 
AVG(velocidade_vento) AS vento, 
AVG(nivel_mare) AS mare
FROM medicoes
WHERE data_hora >= NOW() - INTERVAL 24 HOUR";

$result = $conn->query($query);
$dados = $result->fetch_assoc();
?>

<main style="display:flex; flex-direction:column; align-items:center; min-height:90vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding:50px 20px; background:#f0f2f5;">

    <h1 style="font-size:40px; margin-bottom:40px; color:#1a3e59; text-shadow:1px 1px 2px rgba(0,0,0,0.1);">
        Painel de Indicadores Ambientais (Últimas 24h)
    </h1>

    <div style="display:flex; flex-wrap:wrap; gap:30px; justify-content:center; width:100%; max-width:1200px;">

        <?php
        $cards = [
            ['title'=>'Altura Média das Ondas', 'value'=>round($dados['onda'],2).' m', 'bg'=>'#e3f2fd', 'color'=>'#0b4560'],
            ['title'=>'Velocidade Média do Vento', 'value'=>round($dados['vento'],2).' km/h', 'bg'=>'#fff3e0', 'color'=>'#b85c00'],
            ['title'=>'Nível Médio da Maré', 'value'=>round($dados['mare'],2).' m', 'bg'=>'#e8f5e9', 'color'=>'#2e7d32']
        ];

        foreach($cards as $card){
            echo '<div style="
                    background:'.$card['bg'].';
                    padding:30px 40px; 
                    border-radius:15px; 
                    box-shadow:0 10px 25px rgba(0,0,0,0.1); 
                    min-width:250px; 
                    text-align:center; 
                    position:relative;
                    transition: transform 0.3s, box-shadow 0.3s;
                " 
                onmouseover="this.style.transform=\'translateY(-5px)\'; this.style.boxShadow=\'0 15px 30px rgba(0,0,0,0.15)\';" 
                onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 10px 25px rgba(0,0,0,0.1)\';"
            >
                <strong style="font-size:20px; color:'.$card['color'].';">'.$card['title'].'</strong>
                <p style="font-size:28px; margin-top:20px; font-weight:bold; color:#333;">'.$card['value'].'</p>
            </div>';
        }
        ?>

    </div>
</main>

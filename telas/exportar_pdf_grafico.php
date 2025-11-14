<?php
include '../config.php';
require('../assets/lib/fpdf/fpdf.php');

$periodo = isset($_POST['periodo']) ? intval($_POST['periodo']) : 7;
$wherePeriodo = ($periodo > 0) ? "WHERE data_hora >= NOW() - INTERVAL $periodo DAY" : "";

$query = "SELECT data_hora, altura_onda, velocidade_vento, nivel_mare FROM medicoes $wherePeriodo ORDER BY data_hora ASC";
$result = $conn->query($query);

$dados = [];
while($row = $result->fetch_assoc()){
    $dados[] = $row;
}

// Receber imagem do gráfico
$graficoBase64 = $_POST['grafico'];
$graficoBase64 = str_replace('data:image/png;base64,','',$graficoBase64);
$graficoBase64 = str_replace(' ','+',$graficoBase64);
$graficoData = base64_decode($graficoBase64);
file_put_contents('grafico_temp.png', $graficoData);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Relatorio Ambiental',0,1,'C');
$pdf->Ln(5);

// Inserir gráfico
$pdf->Image('grafico_temp.png',15,25,180);
$pdf->Ln(100);

// Tabela
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,10,'Data/Hora',1);
$pdf->Cell(40,10,'Onda (m)',1);
$pdf->Cell(50,10,'Vento (km/h)',1);
$pdf->Cell(40,10,'Maré (m)',1);
$pdf->Ln();

$pdf->SetFont('Arial','',11);
foreach($dados as $d){
    $pdf->Cell(50,10,$d['data_hora'],1);
    $pdf->Cell(40,10,$d['altura_onda'],1);
    $pdf->Cell(50,10,$d['velocidade_vento'],1);
    $pdf->Cell(40,10,$d['nivel_mare'],1);
    $pdf->Ln();
}

// Gerar PDF
$pdf->Output('D','relatorio_com_grafico.pdf');
unlink('grafico_temp.png');
exit;

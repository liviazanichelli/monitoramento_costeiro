<?php
include '../config.php';

// Recebe o período do POST
$periodo = isset($_POST['periodo']) ? intval($_POST['periodo']) : 7;
$formato = isset($_POST['formato']) ? $_POST['formato'] : 'csv';

// Define filtro de datas
$wherePeriodo = ($periodo > 0) ? "WHERE data_hora >= NOW() - INTERVAL $periodo DAY" : "";

// Consulta banco de dados 
$query = "SELECT data_hora AS DataHora, nivel_mare AS NivelMare,
                 altura_onda AS AlturaOnda, velocidade_vento AS Vento
          FROM medicoes
          $wherePeriodo
          ORDER BY data_hora DESC";
$result = $conn->query($query);

if($formato === 'csv'){
    // CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="relatorio.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['DataHora','NivelMare','AlturaOnda','Vento']);
    while($row = $result->fetch_assoc()){
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
} elseif($formato === 'pdf'){
    // PDF simples usando FPDF 
    require __DIR__ . '/../assets/lib/fpdf/fpdf.php';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,10,'DataHora',1);
    $pdf->Cell(40,10,'NivelMare',1);
    $pdf->Cell(40,10,'AlturaOnda',1);
    $pdf->Cell(40,10,'Vento',1);
    $pdf->Ln();
    $pdf->SetFont('Arial','',10);
    while($row = $result->fetch_assoc()){
        $pdf->Cell(40,10,$row['DataHora'],1);
        $pdf->Cell(40,10,$row['NivelMare'],1);
        $pdf->Cell(40,10,$row['AlturaOnda'],1);
        $pdf->Cell(40,10,$row['Vento'],1);
        $pdf->Ln();
    }
    $pdf->Output('D','relatorio.pdf');
    exit;
}
?>

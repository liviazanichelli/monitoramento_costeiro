<?php
include '../header.php'; 
?>

<main style="display:flex; flex-direction:column; align-items:center; justify-content:flex-start; min-height:90vh; font-family: Arial, sans-serif; padding:60px 20px; background:#f6f9fc;">

    
    <h1 style="font-size: 40px; margin-bottom: 15px; color:#0b4560; text-shadow:1px 1px 2px rgba(0,0,0,0.2);">
        Geração e Exportação de Relatórios
    </h1>

  
    <p style="font-size: 18px; margin-bottom: 40px; max-width:700px; text-align:center; color:#333;">
        Selecione o período do relatório e o formato desejado. <strong>Gerar Relatório</strong>.
    </p>

    
    <div style="background:#fff; padding:40px 30px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.1); display:flex; flex-direction:column; align-items:center; gap:35px; width:100%; max-width:500px;">

        
        <div style="display:flex; flex-direction:column; width:100%; gap:10px;">
            <label style="font-weight:bold; font-size:16px; color:#0b4560;">Período:</label>
            <select name="periodo" form="form-relatorio" style="padding:12px 15px; font-size:16px; border-radius:6px; border:1px solid #ccc; width:100%;">
                <option value="7">Últimos 7 dias</option>
                <option value="30">Últimos 30 dias</option>
                <option value="90">Últimos 90 dias</option>
            </select>
        </div>

       
        <div style="display:flex; flex-direction:column; align-items:center; gap:15px; width:100%;">
            <label style="font-weight:bold; font-size:16px; color:#0b4560;">Formato do arquivo:</label>
            <div style="display:flex; gap:50px; justify-content:center;">
                <label style="cursor:pointer; text-align:center;">
                    <input type="radio" name="formato" value="pdf" form="form-relatorio" style="display:none;" checked>
                    <img src="../assets/img/pdf_icon.jpg" alt="PDF" style="width:100px; height:100px; transition: transform 0.2s;">
                    <div style="margin-top:8px; font-weight:bold; color:#0b4560;">PDF</div>
                </label>

                <label style="cursor:pointer; text-align:center;">
                    <input type="radio" name="formato" value="csv" form="form-relatorio" style="display:none;">
                    <img src="../assets/img/csv_icon.png" alt="CSV" style="width:100px; height:100px; transition: transform 0.2s;">
                    <div style="margin-top:8px; font-weight:bold; color:#0b4560;">CSV</div>
                </label>
            </div>
        </div>

        
        <form id="form-relatorio" method="post" action="exportar_relatorio.php" style="width:100%; display:flex; justify-content:center;">
            <button type="submit" style="padding:15px 35px; font-size:18px; background:#0b4560; color:#fff; border:none; border-radius:8px; cursor:pointer; box-shadow:0 4px 10px rgba(0,0,0,0.15); transition: background 0.2s;">
                Gerar Relatório
            </button>
        </form>

    </div>

</main>


<script>
const icons = document.querySelectorAll('label img');
icons.forEach(icon => {
    icon.addEventListener('mouseover', () => icon.style.transform = 'scale(1.1)');
    icon.addEventListener('mouseout', () => icon.style.transform = 'scale(1)');
});
</script>




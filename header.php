<?php
session_start();
if(!isset($_SESSION['user'])){
    header('Location: /monitoramento_costeiro_grupo03_FINAL/login.php'); 
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Monitoramento Costeiro</title>
    
    <link rel="stylesheet" href="/monitoramento_costeiro_grupo03_FINAL/assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
</head>
<body>
<header>
    <img src="/monitoramento_costeiro_grupo03_FINAL/assets/img/logo.png" alt="logo">
    <nav>
        <a href="/monitoramento_costeiro_grupo03_FINAL/index.php">Mapa</a>
        <a href="/monitoramento_costeiro_grupo03_FINAL/telas/painel.php">Painel</a>
        <a href="/monitoramento_costeiro_grupo03_FINAL/telas/alertas.php">Alertas</a>
        <a href="/monitoramento_costeiro_grupo03_FINAL/telas/graficos.php">Gráfico</a>
        <a href="/monitoramento_costeiro_grupo03_FINAL/telas/historico.php">Histórico</a>
        <a href="/monitoramento_costeiro_grupo03_FINAL/telas/relatorios.php">Relatórios</a>
        <a href="/monitoramento_costeiro_grupo03_FINAL/telas/contato.php">Contato</a>
        <a href="/monitoramento_costeiro_grupo03_FINAL/logout.php">Sair</a>
    </nav>
</header>
<main>


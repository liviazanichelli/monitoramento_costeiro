<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monitoramento_costeiro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco: " . $conn->connect_error);
}
?>

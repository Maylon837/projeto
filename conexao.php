<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "esg";       
$port = 3307;          

$conn = new mysqli($servername, $username, $password, $dbname, $port); 

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error); 
}
?>
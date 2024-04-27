<?php
// Definición de las variables de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventario";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (\Throwable $th) {
    die("Error de conexión: " . $conn->connect_error);
}




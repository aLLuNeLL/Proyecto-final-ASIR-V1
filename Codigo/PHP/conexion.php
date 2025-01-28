<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "rls";

// Creamos la conexión y seleccionamos la base de datos
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificamos la conexión
if ($conn->connect_error) {
    echo "Código de error: " . $conn->connect_errno . "<br>";
    echo "Error de conexión: " . $conn->connect_error . "<br>";
}
?>
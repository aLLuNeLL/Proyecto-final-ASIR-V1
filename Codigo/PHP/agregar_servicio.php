<?php
session_start();
include('conexion.php'); // Asumimos que tienes un archivo de conexión con la base de datos
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre_servicio'], $_POST['descripcion_servicio'], $_POST['precio_servicio'])) {
        $nombre_servicio = $_POST['nombre_servicio'];
        $descripcion_servicio = $_POST['descripcion_servicio'];
        $precio_servicio = $_POST['precio_servicio'];

        // Insertar el servicio en la base de datos
        $query = "INSERT INTO servicios (nombre, descripcion, precio) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssd", $nombre_servicio, $descripcion_servicio, $precio_servicio);
            $stmt->execute();
            echo "<script>alert('Servicio agregado correctamente.');</script>";
        } else {
            echo "<script>alert('Error al agregar el servicio.');</script>";
        }
    }
    echo "<script>window.location.href='servicios.php';</script>";
}
?>
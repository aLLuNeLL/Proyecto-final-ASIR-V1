<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Incluir la conexión a la base de datos
include('conexion.php');

// Verifica si el parámetro id está en la URL
if (isset($_GET['id_servicio'])) {
    $id_servicio = $_GET['id_servicio']; // Asigna el valor del id recibido

    // Verifica que el id sea un número válido
    if (isset($id_servicio) > 0) {
        // Prepara la consulta SQL para eliminar el servicio
        $stmt = $conn->prepare("DELETE FROM servicios WHERE id_servicio = ?");

        // Vincula el parámetro $id_servicio a la consulta
        $stmt->bind_param("i", $id_servicio);  // "i" indica que el parámetro es un entero

        // Ejecuta la consulta
        if ($stmt->execute()) {
            echo "Servicio eliminado con éxito.";
        } else {
            echo "Error al eliminar el servicio.";
        }

        // Cierra el statement
        $stmt->close();
    } else {
        echo "El ID proporcionado no es válido.";
    }
} else {
    echo "($id_servicio)";
    echo "No se ha proporcionado el ID.";
}

echo "<a href='../servicios.php'>Volver</a>";

// Cierra la conexión
$conn->close();
?>
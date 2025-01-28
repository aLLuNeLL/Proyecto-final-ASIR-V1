<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    echo "Debe iniciar sesión para enviar una solicitud.";
    exit();
}

// Incluir archivo de conexión
include('conexion.php');

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['servicio'])) {
    // Capturar los servicios seleccionados y los detalles adicionales
    $servicios = $_POST['servicio']; // Array de IDs de servicios
    $detalles = isset($_POST['detalles']) ? htmlspecialchars($_POST['detalles']) : '';

    // Obtener el usuario que realiza la solicitud
    $usuario_id = $_SESSION['usuario']; // Asegúrate de que el ID del usuario está almacenado en la sesión correctamente

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Insertar en la tabla `presupuesto`
        $stmt = $conn->prepare("INSERT INTO presupuesto (id_cliente, descripcion) VALUES (?, ?)");
        $stmt->bind_param("is", $usuario_id, $detalles);

        if ($stmt->execute()) {
            // Obtener el ID generado para el presupuesto
            $id_presupuesto = $stmt->insert_id;

            // Insertar los servicios relacionados en `servicios_presupuesto`
            $stmt2 = $conn->prepare("INSERT INTO servicios_presupuesto (id_presupuesto, id_servicio) VALUES (?, ?)");

            foreach ($servicios as $id_servicio) {
                $stmt2->bind_param("ii", $id_presupuesto, $id_servicio);

                if (!$stmt2->execute()) {
                    throw new Exception("Error al insertar servicio en el presupuesto: " . $stmt2->error);
                }
            }

            // Confirmar la transacción
            $conn->commit();
            echo "<script>alert('Presupuesto creado correctamente.');</script><br>";
        } else {
            throw new Exception("Error al crear presupuesto: " . $stmt->error);
        }

        // Cerrar los statements
        $stmt->close();
        $stmt2->close();
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
    echo "<script>window.location.href='logueado.php';</script>";
} else {
    echo "<script>alert('No se seleccionó ningún servicio.');</script>";
    echo "<script>window.location.href='servicios.php';</script>";

}

// Cerrar la conexión
$conn->close();
?>
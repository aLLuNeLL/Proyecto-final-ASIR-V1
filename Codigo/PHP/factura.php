<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include("conexion.php");
/*-----------------------------------------------------------FACTURA----------------------------------------------------------*/

require('../fdpdf/fpdf.php'); // Ajusta la ruta según corresponda

// Obtener el último presupuesto generado
$query_presupuesto = "SELECT p.id_presupuesto, p.fecha_peticion, p.estado, 
                      c.nombre, c.apellido_1, c.apellido_2, 
                      c.nombre_empresa, c.direccion, c.telefono, c.correo 
                      FROM presupuesto p 
                      JOIN cliente c ON p.id_cliente = c.id_cliente 
                      ORDER BY p.id_presupuesto DESC LIMIT 1";
$result_presupuesto = $conn->query($query_presupuesto);

if (!$result_presupuesto || $result_presupuesto->num_rows === 0) {
    die("Error: No se encontró un presupuesto válido.");
}

$presupuesto = $result_presupuesto->fetch_assoc();

// Consultar servicios relacionados al presupuesto
$query_servicios = "SELECT s.nombre, s.descripcion, s.precio 
                    FROM servicios s 
                    JOIN servicios_presupuesto sp ON s.id_servicio = sp.id_servicio 
                    WHERE sp.id_presupuesto = ?";
$stmt_servicios = $conn->prepare($query_servicios);
$stmt_servicios->bind_param('i', $presupuesto['id_presupuesto']);
$stmt_servicios->execute();
$result_servicios = $stmt_servicios->get_result();

$servicios = [];
while ($servicio = $result_servicios->fetch_assoc()) {
    $servicios[] = $servicio;
}

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();

// Encabezado con logo y título
$pdf->SetFillColor(240, 248, 255); // Fondo azul claro
$pdf->Rect(0, 0, 210, 33, 'F'); // Rectángulo para encabezado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Image('../img/favicon.png', 10, 10, 15);
$pdf->SetTextColor(0, 0, 128);
$pdf->Cell(0, 10, utf8_decode('FACTURA'), 0, 1, 'C');
$pdf->Ln(15);

// Información de la empresa
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, utf8_decode('RSL'), 0, 1);
$pdf->Cell(0, 6, utf8_decode('C/Llança, 51'), 0, 1);
$pdf->Cell(0, 6, utf8_decode('935-473-257'), 0, 1);
$pdf->Cell(0, 6, utf8_decode('info@rsl.com'), 0, 1);
$pdf->Ln(10);

// Información del cliente y la factura
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(230, 230, 230); // Fondo gris claro
$pdf->Cell(95, 8, utf8_decode('Datos Cliente'), 1, 0, 'L', true);
$pdf->Cell(95, 8, utf8_decode('Detalles de la Factura'), 1, 1, 'L', true);

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(95, 8, utf8_decode($presupuesto['nombre'] . ' ' . $presupuesto['apellido_1'] . ' ' . $presupuesto['apellido_2']), 1);
$pdf->Cell(95, 8, utf8_decode('Identificador: ') . $presupuesto['id_presupuesto'], 1, 1);

$pdf->Cell(95, 8, utf8_decode($presupuesto['direccion']), 1);
$pdf->Cell(95, 8, $presupuesto['fecha_peticion'], 1, 1);

$pdf->Cell(95, 8, utf8_decode($presupuesto['telefono']), 1, 1);
$pdf->Cell(95, 8, utf8_decode($presupuesto['correo']), 1, 1);
$pdf->Ln(10);


// Tabla de servicios
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(173, 216, 230); // Fondo azul claro para cabecera
$pdf->Cell(80, 10, utf8_decode('Servicio'), 1, 0, 'C', true);
$pdf->Cell(80, 10, utf8_decode('Descripción'), 1, 0, 'C', true);
$pdf->Cell(30, 10, utf8_decode('Precio'), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);
$total = 0;
foreach ($servicios as $servicio) {
    $pdf->Cell(80, 10, utf8_decode($servicio['nombre']), 1);
    $pdf->Cell(80, 10, utf8_decode($servicio['descripcion']), 1);
    $pdf->Cell(30, 10, number_format($servicio['precio'], 2) . ' EUR', 1, 1, 'R');
    $total += $servicio['precio'];
}

// Totales
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(240, 240, 240); // Fondo gris claro para totales
$pdf->Cell(160, 10, utf8_decode('SUBTOTAL:'), 1, 0, 'R', true);
$pdf->Cell(30, 10, number_format($total, 2) . ' EUR', 1, 1, 'R', true);

$pdf->Cell(160, 10, utf8_decode('IVA (21%):'), 1, 0, 'R', true);
$pdf->Cell(30, 10, number_format($total * 0.21, 2) . ' EUR', 1, 1, 'R', true);

$pdf->Cell(160, 10, utf8_decode('TOTAL:'), 1, 0, 'R', true);
$pdf->Cell(30, 10, number_format($total * 1.21, 2) . ' EUR', 1, 1, 'R', true);

$pdf->Ln(10);

// Pie de página
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(0, 0, 128);
$pdf->Cell(0, 10, utf8_decode('Gracias por su compra. Si tiene preguntas, contacte con nosotros.'), 0, 1, 'C');

ob_end_clean();
$pdf->Output('I', 'Factura_Presupuesto_' . $presupuesto['id_presupuesto'] . '.pdf');

?>
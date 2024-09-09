<?php
require_once '../vendor/autoload.php';

use Taller\Controllers\CarController;

// Leer los datos de los coches
$carController = new CarController('../cars.json');
$data = $carController->readJsonFile();
$cars = $data['cars'];

// Generar PDF con TCPDF
$pdf = new \TCPDF(); // Instanciar TCPDF directamente
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = "<h1>Car Details</h1>";
$html .= "<table border='1' cellpadding='5'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Price (COP)</th>
                    <th>Fuel (Galons)</th>
                </tr>
            </thead>
            <tbody>";

foreach ($cars as $car) {
    $html .= "<tr>
                <td>" . (isset($car['id']) ? $car['id'] : 'N/A') . "</td>
                <td>" . (isset($car['brand']) ? $car['brand'] : 'N/A') . "</td>
                <td>" . (isset($car['model']) ? $car['model'] : 'N/A') . "</td>
                <td>" . (isset($car['year']) ? $car['year'] : 'N/A') . "</td>
                <td>" . (isset($car['price']) ? '$' . number_format($car['price'], 0, '', '.') : 'N/A') . "</td>
                <td>" . (isset($car['fuel']) ? $car['fuel'] : 'N/A') . "</td>
              </tr>";
}

$html .= "</tbody></table>";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('car_details.pdf', 'I'); // 'I' para mostrar en el navegador, 'D' para descargar

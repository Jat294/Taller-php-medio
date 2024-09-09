<?php

require_once '../vendor/autoload.php';

use Taller\Controllers\CarController;
use Taller\Models\Car;
use Respect\Validation\Validator as v;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = (int)$_POST['price']; // Convertir a entero
    $fuel = (int)$_POST['fuel']; // Convertir a entero

    // Validar los datos
    $brandValidator = v::stringType()->notEmpty();
    $modelValidator = v::stringType()->notEmpty();
    $yearValidator = v::intVal()->between(1886, (int)date('Y'));
    $priceValidator = v::intVal()->positive();
    $fuelValidator = v::intVal()->positive();

    if ($brandValidator->validate($brand) && $modelValidator->validate($model) && $yearValidator->validate($year) && $priceValidator->validate($price) && $fuelValidator->validate($fuel)) {
        $carController = new CarController('../cars.json');
        $car = new Car($brand, $model, $year, $price, $fuel);
        $carController->createCar($car);
        header('Location: index.php');
    } else {
        echo "Invalid input data";
    }

    // Generar PDF con TCPDF
    $pdf = new \TCPDF(); // Instanciar TCPDF directamente
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    $html = "
        <h1>Car Details</h1>
        <p><strong>Brand:</strong> $brand</p>
        <p><strong>Model:</strong> $model</p>
        <p><strong>Year:</strong> $year</p>
        <p><strong>Price:</strong> $price</p>
        <p><strong>Fuel:</strong> $fuel</p>
    ";
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('car_details.pdf', 'I'); // 'I' para mostrar en el navegador, 'D' para descargar

    // Redirigir a index.php
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Car</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Add Car</h1>
        <form method="post">
            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" name="brand" id="brand" required>
            </div>
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" class="form-control" name="model" id="model" required>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="text" class="form-control" name="year" id="year" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" id="price" required>
            </div>
            <div class="form-group">
                <label for="fuel">Fuel</label>
                <input type="number" class="form-control" name="fuel" id="fuel" required>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</body>

</html>
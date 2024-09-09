<?php
require_once '../vendor/autoload.php';

use Taller\Controllers\CarController;
use Taller\Models\Car;

$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $unit = $_POST['unit'];

    $carController = new CarController('../cars.json');
    $carData = $carController->getCarById($id);

    if ($carData) {
        $car = new Car($carData['brand'], $carData['model'], $carData['year'], $carData['price'], $carData['fuel']);
        $convertedFuel = $car->calculateFuel($unit);
        $result = "The fuel capacity in $unit is: " . number_format($convertedFuel, 2);
    } else {
        $result = "Car not found.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Convert Fuel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1>Convert Fuel</h1>
        <div class="alert alert-info">
            <?php echo $result; ?>
        </div>
        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
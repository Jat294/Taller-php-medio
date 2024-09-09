<?php
require_once '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Taller\Controllers\CarController;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('../logs.log', Logger::WARNING));

// Add records to the log
$log->warning('Foo');
$log->error('Bar');

$carController = new CarController('../cars.json');
$data = $carController->readJsonFile();
$cars = $data['cars'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taller Intermedio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1>Taller Intermedio!</h1>

    <div class="container">
        <table class="table table-bordered table-striped ">
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
            <tbody>
                <?php
                foreach ($cars as $index => $car) {
                    echo "<tr>";
                    echo "<td>" . (isset($car['id']) ? $car['id'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($car['brand']) ? $car['brand'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($car['model']) ? $car['model'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($car['year']) ? $car['year'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($car['price']) ? '$' . number_format($car['price'], 0, '', '.') : 'N/A') . "</td>";
                    echo "<td>" . (isset($car['fuel']) ? $car['fuel'] : 'N/A') . "</td>";
                    echo "<td>";
                    echo "<form method='post' action='convert_price.php' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='" . $car['id'] . "'>";
                    echo "<select name='currency' class='form-select' required>";
                    echo "<option value='USD'>USD</option>";
                    echo "<option value='EUR'>EUR</option>";
                    echo "<option value='GBP'>GBP</option>";
                    echo "</select>";
                    echo "<button type='submit' class='btn btn-primary'>Convert Price</button>";
                    echo "</form>";
                    echo "<form method='post' action='convert_fuel.php' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='" . $car['id'] . "'>";
                    echo "<select name='unit' class='form-select' required>";
                    echo "<option value='liters'>Liters</option>";
                    echo "<option value='gallons'>Gallons</option>";
                    echo "</select>";
                    echo "<button type='submit' class='btn btn-secondary'>Convert Fuel</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="add.php" class="btn btn-success">Create new car</a>
        <a href="generate_pdf.php" class="btn btn-primary">Generate PDF</a> <!-- Botón para generar PDF -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
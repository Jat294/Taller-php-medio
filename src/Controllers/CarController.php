<?php

namespace Taller\Controllers;

use Taller\Models\Car;

class CarController
{
    private string $jsonFile;
    private int $latestId = 0;

    public function __construct(string $jsonFile)
    {
        $this->jsonFile = $jsonFile;
    }

    public function readJsonFile()
    {
        return json_decode(
            file_get_contents($this->jsonFile),
            true
        );
    }

    public function createCar(Car $car)
    {
        $data = $this->readJsonFile();
        $car->setId($this->generateUniqueId($data['cars']));
        $data['cars'][] = $car->toArray(); // Agregar el nuevo carro al array 'cars'
        $this->writeJsonFile($data);
    }

    private function generateUniqueId($cars)
    {
        if ($this->latestId == 0) {
            $maxId = 0;
            foreach ($cars as $car) {
                if ($car['id'] > $maxId) {
                    $maxId = $car['id'];
                }
            }
            $latestId = $maxId + 1;
            $this->latestId = $latestId;
            return $this->latestId;
        } else {
            $this->latestId++;
            return $this->latestId;
        }
    }

    private function writeJsonFile($data)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->jsonFile, $json);
    }

    public function getLatestId()
    {
        return $this->latestId;
    }

    public function getCarById($id)
    {
        $data = $this->readJsonFile();
        foreach ($data['cars'] as $car) {
            if ($car['id'] == $id) {
                return $car;
            }
        }
        return null;
    }

    public function updateCar($id)
    {
        $car = $this->getCarById($id);
        if ($car != null) {
            $this->createCar($car);
        }
        return;
    }

    public function deleteCar($id)
    {
        $data = $this->readJsonFile();
        foreach ($data['cars'] as $index => $car) {
            if ($car['id'] == $id) {
                array_splice($data['cars'], $index, 1);
                $this->writeJsonFile($data);
                return;
            }
        }
    }
}

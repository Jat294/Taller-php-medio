<?php

namespace Taller\Models;

class Car
{
    private int $id;
    private string $brand;
    private string $model;
    private string $year;
    private int $price;
    private int $fuel;

    public function __construct(string $brand, string $model, string $year, int $price, int $fuel)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->price = $price;
        $this->fuel = $fuel;
    }

    //Función para calcular el precio del carro en otras monedas habiendo sido dado en pesos Colombianos
    public function calculatePrice(String $currency)
    {
        $exchangeRate = 0;
        switch ($currency) {
            case 'USD':
                $exchangeRate = 0.00027;
                break;
            case 'EUR':
                $exchangeRate = 0.00023;
                break;
            case 'GBP':
                $exchangeRate = 0.00020;
                break;
            default:
                $exchangeRate = 0.00027;
                break;
        }
        return $this->price * $exchangeRate;
    }

    //Función para calcular la capacidad de combustible del carro en litros habiendo sido dado en galones
    public function calculateFuel(string $unit)
    {
        $conversionRate = 0;
        switch ($unit) {
            case 'liters':
                $conversionRate = 3.78541;
                break;
            case 'gallons':
                $conversionRate = 0.264172;
                break;
            default:
                $conversionRate = 3.78541;
                break;
        }
        return $this->fuel * $conversionRate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getFuel()
    {
        return $this->fuel;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setFuel($fuel)
    {
        $this->fuel = $fuel;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'price' => $this->price,
            'fuel' => $this->fuel
        ];
    }
}

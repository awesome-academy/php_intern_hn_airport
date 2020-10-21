<?php
namespace App\Repositories\ConfigBasic;

interface ConfigBasicRepositoryInterface
{
    public function findCost($distance, $carType);

    public function findAllCarTypes();

    public function findLowestCostCarType($carType);

    public function deleteConfigByDistance($distance);
}

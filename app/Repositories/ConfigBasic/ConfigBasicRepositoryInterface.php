<?php
namespace App\Repositories\ConfigBasic;

interface ConfigBasicRepositoryInterface
{
    public function findCost($distance, $carType);
}

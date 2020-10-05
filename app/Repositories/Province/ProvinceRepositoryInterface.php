<?php
namespace App\Repositories\Province;

interface ProvinceRepositoryInterface
{
    public function getProvinceHasAiport();

    public function searchByName($cityName);
}

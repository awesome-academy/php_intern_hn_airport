<?php
namespace App\Repositories\HostDetail;

interface HostDetailRepositoryInterface
{
    public function createHostDetail($attributes = [], $quantity);

    public function filterHostDetail($carTypeId, $provinceAirportId);
}
